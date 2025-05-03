<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT r.*,t.name as rtype FROM `real_estate_list` r inner join `type_list` t on r.type_id = t.id where r.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
        if(isset($id)){
            $meta_qry = $conn->query("SELECT * FROM `real_estate_meta` where real_estate_id = '{$id}'");
            while($row = $meta_qry->fetch_assoc()){
                ${$row['meta_field']} = $row['meta_value'];
            }

            $amenity_arr = [];
            $amentiy_qry = $conn->query("SELECT * FROM `amenity_list` where id in (SELECT `amenity_id` FROM `real_estate_amenities` where real_estate_id = '{$id}') order by `name`");
            while($row = $amentiy_qry->fetch_assoc()){
                $amenity_arr[$row['type']][] = $row;
            }
        }
        if(isset($agent_id)){
            $agent_det = [];
            $agent = $conn->query("SELECT *,CONCAT(lastname,', ', firstname, ' ', COALESCE(middlename,''))as fullname FROM `agent_list` where id = '{$agent_id}' ");
            $agent_det = $agent->fetch_array();
        }
    }else{
        echo '<script> alert("Unknown Real Estate\'s ID."); location.replace("./?page=real_estate"); </script>';
    }
}else{
    echo '<script> alert("Real Estate\'s ID is required to access the page."); location.replace("./?page=real_estate"); </script>';
}




$property_id = $id;
$current_user_id = isset($_SESSION['userdata']['id']);
$agent_id = isset($agent_det['id']) ? $agent_det['id'] : 0;



?>
<style>
    .view-image img{
        width:100%;
        height:10vh;
        object-fit:scale-down;
        object-position: center center;
    }
    .mapouter{position:relative;text-align:right;height:500px;width:100%;}
    .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}
</style>
<div class="container">
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow" style="direction: rtl;text-align: right;">
        <div class="card-header">
            <h4 class="card-title">تفاصيل العقار: <b><?= isset($code) ? $code : "" ?></b></h4>
        </div>
        <div class="card-body">
            <div class="row gx-4 gx-lg-5 align-items-top">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0 border border-dark" loading="lazy" id="display-img" src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" alt="..." />
                    <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                        <div class="col">
                            <a href="javascript:void(0)" class="view-image active"><img src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                        </div>
                        <?php 
                        if(isset($id)):
                        if(is_dir(base_app."uploads/estate_".$id)):
                        $fileO = scandir(base_app."uploads/estate_".$id);
                            foreach($fileO as $k => $img):
                                if(in_array($img,array('.','..')))
                                    continue;
                        ?>
                        <div class="col">
                            <a href="javascript:void(0)" class="view-image"><img src="<?php echo validate_image('uploads/estate_'.$id.'/'.$img."?v=".strtotime($date_updated)) ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="small mb-1">SKU: BST-498</div> -->
                    <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $name ?></h1>
                    <p class="m-0"><small><?= $rtype ?></small></p>
                    <fieldset>
                        <legend class="h4 text-muted">تفاصيل</legend>
                        <div class="row">
                            <div class="col-6">
                                <span class="text-muted">النوع: </span><?= isset($type) ? $type : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">العرض: </span><?= isset($purpose) ? $purpose : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">المساحة:</span><?= isset($area) ? $area : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">سعر البيع : </span><?= isset($sale_price) ? format_num($sale_price) : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">الموقع </span><?= isset($location) ? $location : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">الحالة: </span> 
                                <?php if(isset($status) && $status == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">متوفر</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">مباع</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </fieldset>
                    <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
                    <fieldset>
                        <legend class="h4 text-muted">الخصائص</legend>
                        <?php  if(isset($amenity_arr) && count($amenity_arr) > 0): ?>
                        <?php  if(isset($amenity_arr[1]) && count($amenity_arr[1]) > 0): ?>
                            <div><b>داخلي</b></div>
                            <div class="row">
                            <?php foreach($amenity_arr[1] as $v): ?>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <span class="badge badge-success text-light rounded mr-2"><i class="fa fa-check"></i></span> <?= $v['name'] ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div><b>خارجي:</b></div>
                            <div class="row">
                            <?php foreach($amenity_arr[2] as $v): ?>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <span class="badge badge-success text-light rounded mr-2"><i class="fa fa-check"></i></span> <?= $v['name'] ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php else: ?>
                            <center><small class="text-mute"><i>الخصائص مُباعة</i></small></center>
                        <?php endif; ?>
                    </fieldset>
                </div>
            </div>
            <?php if(isset($coordinates)): ?>
            <div class="row">
                <div class="col-md-12">
                    <h4>موقع الخريطة</h4>
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe src="<?= $coordinates ?>" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
            <?php if($status == 0){ ?>
                <h2 class="col-12  pt-3 cart-title text-center">
                        <span class="badge badge-success px-3 rounded-pill">شكراً للزبون الكريم <?php echo $_settings->userdata('firstname')?> 
                        تم بيع العقار بتاريخ <?php echo $sold_date?></span>
                    </h2>
                    <?php if($agent_det['id'] == $_SESSION['userdata']['id']){?>
                        <?php 
// سنجلب قيمة feedback من قاعدة البيانات (ربما تم جلبها أصلاً ضمن $agent_det أو بيانات العقار، تأكد)
                            $feedback_rating = 0;
                            $rating_qry = $conn->query("SELECT feedback FROM real_estate_list WHERE id = '{$property_id}'");
                            if($rating_qry && $rating_qry->num_rows > 0){
                                $rating_row = $rating_qry->fetch_assoc();
                                $feedback_rating = (int)$rating_row['feedback'];
                            }
                            ?>
                            <script>
                            var existingRating = <?php echo $feedback_rating; ?>;
                            </script>
                        <div class="feedback-card mx-auto">
                            <h4 class="fw-bold">يرجى تقييم تجربتك معنا</h4>
                            <p class="text-muted">من 1 لـ 5 </p>

                            <div class="star-rating my-3">
                                <i class="icon-star" data-value="1"></i>
                                <i class="icon-star" data-value="2"></i>
                                <i class="icon-star" data-value="3"></i>
                                <i class="icon-star" data-value="4"></i>
                                <i class="icon-star" data-value="5"></i>
                            </div>
                            <form id="feedbackForm">
                                <!-- <div class="mb-3">
                                    <textarea class="form-control" rows="4" placeholder="Write your feedback..." required></textarea>
                                </div> -->
                                <input type="hidden" name="rating" id="ratingInput">
                                <input type="hidden" name="id" value="<?php echo $property_id; ?>">
                                <button type="submit" class="btn btn-submit w-100">أرسل التقييم</button>
                            </form>
                        
                        </div>
                        <?php }?>
                    
                <?php }elseif(isset($_SESSION['userdata']) &&$agent_det['id'] == $_SESSION['userdata']['id']  && $status == 1){ ?>
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 pt-4">
                    <h4 class="pl-2 cart-title">
                        <a href="javascript:void(0)" id="mark-sold-btn" class="text-danger">
                            هل تم الاتفاق؟ اضغط هنا لتغيير حالة العقار لـ
                            <span class="badge badge-danger px-3 rounded-pill">مباع</span>
                        </a>
                    </h4>
                <?php }elseif(isset($_SESSION['userdata']) && $agent_det['id'] != $_SESSION['userdata']['id']  && $status == 1){ ?>
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 pt-4">
                    <div class="card card-outline card-info rounded-0 shadow">
                        <div class="card-header">
                            <h4 class="cart-title"><b>معلومات الوكيل:</b></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <img src="<?= validate_image(isset($agent_det['avatar']) ? $agent_det['avatar'] : "") ?>" alt="Agent Image" class="img-fluid img-thumbnail mb-2 w-100 bg-gradient-gray border" id="agent-avatar">
                                    
                                
                                </div>
                                <div class="col-8">
                                    <dl>
                                        <dt class="text-muted"><b>الاسم الكامل</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['fullname']) ? $agent_det['fullname'] : "" ?></dd>
                                        <dt class="text-muted"><b>التواصل #</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['contact']) ? $agent_det['contact'] : "" ?></dd>
                                        <dt class="text-muted"><b>البريد الالكتروني</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['email']) ? $agent_det['email'] : "" ?></dd>
                                    </dl>
   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                              
                           
               
               
                    <?php } ?>
                 </div>


                 
                
                       <!-- chat -->
                    


                       <?php if(isset($_SESSION['userdata']) && $status == 1){?>
                       <div class="container d-flex justify-content-center col-6" >
                            <div class="card c mt-5">
                                <div class="d-flex flex-row justify-content-between p-2 adiv text-white" id="backbutton">
                                    
                                <i class="fas fa-chevron-left"></i>
                                <span class="pb-3">دردشة مباشرة
                                    
                                </span>
                                <i class="fas fa-times"></i>
                                </div>
                                
                                <div class="px-3" style="max-height: 300px; overflow-y: auto;" id="chat-box">
                                        <!-- سيتم تعبئته ديناميكياً -->
                                    </div>

                                <form id="messageForm">
                                    <input type="hidden" name="property_id" value="<?= $property_id ?>">
                                    <input type="hidden" name="sender_id" value="<?= $_SESSION['userdata']['id'] ?>">
                                    <input type="hidden" name="receiver_id" id="receiver_id" value="<?= $agent_id ?>">
                                <div class="form-group px-3 row">
                                    <textarea class="form-control col-10"name="message"id="message" rows="5" placeholder="اكتب رسالتك هنا"></textarea>
                                    <button type="submit" name="send-message" class="btn col-2 send">أرسل </button>
                                </div>
                                </form>
                            </div>
                            </div>
                            <?php }?>

            </div>


            
        </div>
    </div>
</div>
</div>

