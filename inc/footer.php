

<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">

        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  جميع الحقوق محفوظة &copy;<script>document.write(new Date().getFullYear());</script></a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>





  <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>



    <!-- overlayScrollbars -->

              <!-- newwwwwwww -->
   
   <script src="<?php echo base_url ?>js/jquery.min.js"></script>
  <script src="<?php echo base_url ?>js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?php echo base_url ?>js/popper.min.js"></script>
  <script src="<?php echo base_url ?>js/bootstrap.min.js"></script>
  <script src="<?php echo base_url ?>js/jquery.easing.1.3.js"></script>
  <script src="<?php echo base_url ?>js/jquery.waypoints.min.js"></script>
  <script src="<?php echo base_url ?>js/jquery.stellar.min.js"></script>
  <script src="<?php echo base_url ?>js/owl.carousel.min.js"></script>
  <script src="<?php echo base_url ?>js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo base_url ?>js/aos.js"></script>
  <script src="<?php echo base_url ?>js/jquery.animateNumber.min.js"></script>
  <script src="<?php echo base_url ?>js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url ?>js/jquery.timepicker.min.js"></script>
  <script src="<?php echo base_url ?>js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="<?php echo base_url ?>js/google-map.js"></script>
  <script src="<?php echo base_url ?>js/main.js"></script>



    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>

    
  <script>
    function _filter(){
        var brands = []
            $('.brand-item:checked').each(function(){
                brands.push($(this).val())
            })
        _b = JSON.stringify(brands)
        var checked = $('.brand-item:checked').length
        var total = $('.brand-item').length
        if(checked == total)
            location.href="./?";
        else
            location.href="./?b="+encodeURI(_b);
    }
    function check_filter(){
        var checked = $('.brand-item:checked').length
        var total = $('.brand-item').length
        if(checked == total){
            $('#brandAll').attr('checked',true)
        }else{
            $('#brandAll').attr('checked',false)
        }
        if('<?php echo isset($_GET['b']) ?>' == '')
            $('#brandAll,.brand-item').attr('checked',true)
    }
    $(function(){
        check_filter()
        $('#brandAll').change(function(){
            if($(this).is(':checked') == true){
                $('.brand-item').attr('checked',true)
            }else{
                $('.brand-item').attr('checked',false)
            }
            _filter()
        })
        $('.brand-item').change(function(){
            _filter()
        })
    })

</script>

<script>
let currentChatUserId = null; // لتتبع المحادثة الحالية

$(function(){
    $('#messageForm').submit(function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: _base_url_ + "classes/Messages.php?f=send_message",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            success: function(resp){
                console.log("الرد:", resp);
                if (resp.status === 'success') {
                    $('#message').val('');
                    fetchMessages();
                } else {
                    alert_toast("حدث خطأ أثناء إرسال الرسالة.", 'error');
                    console.error("خطأ في الرد:", resp);
                }
            },
            error: function(xhr){
                console.log("خطأ في الاتصال أو في الاستجابة:");
                console.log(xhr.responseText);
                alert_toast("حدث خطأ في الاتصال بالخادم.", 'error');
            }
        });
    });
});

function fetchMessages(){
    $.ajax({
        url: _base_url_ + "classes/Messages.php?f=fetch_messages",
        method: "POST",
        data: {
            property_id: "<?= $property_id ?>",
            sender_id: "<?= $_SESSION['userdata']['id'] ?>",
            receiver_id: "<?= $agent_id ?>"
        },
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                let messages = resp.messages;
                let html = '';

                if ("<?= $agent_id ?>" == "<?= $_SESSION['userdata']['id'] ?>") {
                    if (currentChatUserId) {
                        let filtered = messages.filter(m => 
                            m.sender_id == currentChatUserId || m.receiver_id == currentChatUserId
                        );
                        loadConversation(filtered);
                        return;
                    }

                    $('#backbutton').html(`<i class="fas fa-chevron-left"></i>
                        <span class="pb-3">دردشة مباشرة <?php echo $_SESSION['userdata']['id']; ?></span>
                        <i class="fas fa-times"></i>`); // إعادة تعيين العنوان

                    if (messages.length === 0) {
                        html = '<div class="alert alert-info text-center">لا توجد محادثات حالياً</div>';
                    } else {
                        let users = {};
                        messages.forEach(msg => {
                            let user_id = msg.sender_id != "<?= $agent_id ?>" ? msg.sender_id : msg.receiver_id;
                            if (!users[user_id]) {
                                users[user_id] = [];
                            }
                            users[user_id].push(msg);
                        });

                        html = '<div class="list-group">';
                        for (let user_id in users) {
                            let name = resp.user_names[user_id] || `المستخدم #${user_id}`;
                            let avatar = resp.user_avatars[user_id] || 'default_avatar.png';
                            html += `<a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick='loadConversation(${JSON.stringify(users[user_id])})'>
                                        <img src="${avatar}" alt="${name}" class="rounded-circle" width="30" height="30">
                                        ${name}
                                    </a>`;
                                    userNames = resp.user_names || {};

                        }
                        html += '</div>';
                    }
                } else {
                    if(messages.length === 0 || 
                        ("<?= $_SESSION['userdata']['id']?>" != "<?= $agent_id ?>" &&
                        !messages.some(msg => msg.sender_id == "<?= $_SESSION['userdata']['id']?>" || msg.receiver_id == "<?= $_SESSION['userdata']['id']?>"))){
                        html = '<div class="alert alert-info text-center">تواصل مع صاحب العقار مباشرة</div>';
                    } else {
                        messages.forEach(function(msg){
                            let senderAvatar = resp.user_avatars[msg.sender_id] || 'default_avatar.png';
                            if(msg.sender_id == <?= $_SESSION['userdata']['id']?>){
                                html += `<div class="d-flex flex-row p-3">
                                        <img src="${senderAvatar}" width="30" height="30">
                                        <div class="chat ml-2 p-3 bg-light rounded shadow-sm">${msg.message}</div>
                                    </div>`;
                            } else if(msg.receiver_id == <?= $_SESSION['userdata']['id']?>) {
                                html += `<div class="d-flex flex-row p-3" style="direction: ltr;text-align: left;">
                                        <div class="bg-white mr-2 p-3 rounded shadow-sm"><span class="text-muted">${msg.message}</span></div>
                                        <img src="${senderAvatar}" width="30" height="30">
                                    </div>`;
                            }
                        });
                    }
                }

                $('#chat-box').html(html);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }
        },
        error: function(){
            console.log("فشل في جلب الرسائل.");
        }
    });
}

function loadConversation(conversation){
    if (conversation.length > 0) {
        currentChatUserId = conversation[0].sender_id != <?= $_SESSION['userdata']['id']?> 
                            ? conversation[0].sender_id 
                            : conversation[0].receiver_id;
    }

    let html = '';
    conversation.forEach(function(msg){
        if(msg.sender_id == <?= $_SESSION['userdata']['id']?>){
            html += `<div class="d-flex flex-row p-3">
                    <div class="chat ml-2 p-3 bg-light rounded shadow-sm">${msg.message}</div>
                </div>`;
        } else {
            html += `<div class="d-flex flex-row p-3" style="direction: ltr;text-align: left;">
                    <div class="bg-white mr-2 p-3 rounded shadow-sm"><span class="text-muted">${msg.message}</span></div>
                </div>`;
            $('#receiver_id').val(msg.sender_id);
        }
    });

    $('#chat-box').html(html);
    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

    // ✅ الحصول على اسم المستخدم باستخدام currentChatUserId
    let username = userNames[currentChatUserId] || `المستخدم #${currentChatUserId}`;

    // ✅ تحديث زر العودة
    $('#backbutton').html(`
        <button onclick="currentChatUserId = null; fetchMessages();" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> عودة إلى المحادثات
        </button>
        <span class="pb-3">محادثة مع ${username}</span>
        <i class="fas fa-times"></i>
    `);
}


setInterval(fetchMessages, 10000);
fetchMessages();
</script>


<script>
$(document).ready(function() {
    $('#mark-sold-btn').click(function() {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "هل تريد تغيير حالة العقار إلى (مباع)؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تم البيع!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: _base_url_ + "classes/Messages.php?f=mark_sold",
                    method: 'POST',
                    data: {
                        id: <?= $id ?> // معرف العقار الحالي
                    },
                    dataType: 'json',
                    success: function(resp){
                        if(resp.status === 'success'){
                            Swal.fire('تم البيع!', 'تم تحديث حالة العقار بنجاح.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('فشل!', resp.msg || 'حدث خطأ ما.', 'error');
                        }
                    },
                    error: function(xhr){
                        Swal.fire('خطأ في الاتصال!', xhr.responseText, 'error');
                    }
                });
            }
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".star-rating i");
  let selectedRating = 0;

  // إذا كان فيه تقييم موجود، نعرضه مباشرة
  if (existingRating > 0) {
      selectedRating = existingRating;
      for (let i = 0; i < selectedRating; i++) {
          stars[i].classList.add("active");
      }
      document.getElementById("ratingInput").value = selectedRating;
  }

  stars.forEach(star => {
      star.addEventListener("click", function () {
          selectedRating = this.getAttribute("data-value");
          stars.forEach(s => s.classList.remove("active"));
          for (let i = 0; i < selectedRating; i++) {
              stars[i].classList.add("active");
          }
          document.getElementById("ratingInput").value = selectedRating; // نحدث قيمة الإدخال المخفي
      });
  });

  document.getElementById("feedbackForm").addEventListener("submit", function (e) {
      e.preventDefault();
      if (selectedRating == 0) {
          Swal.fire({
              icon: 'warning',
              title: 'تنبيه',
              text: 'يرجى التقييم قبل الارسال',
          });
          return;
      }

      const formData = new FormData(this);

      fetch('classes/Messages.php?f=feedback', { 
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
    if (data.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'شكراً لك!',
            text: 'تم إرسال تقييمك بنجاح',
            confirmButtonColor: '#19707F'
        }).then(() => {
            location.reload(); // 🔥 إعادة تحميل الصفحة بعد الضغط على "OK" في السويت ألرت
        });
        this.reset();
        stars.forEach(s => s.classList.remove("active"));
        selectedRating = 0;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: data.msg
        });
    }
})

      .catch(error => {
          console.error('Error:', error);
      });
  });
});

</script>