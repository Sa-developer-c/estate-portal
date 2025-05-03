<?php

$is_logged_in = isset($_SESSION['userdata']); // تحقق من حالة الجلسة
?>
<div class="top">
    	<div class="container">
    		<div class="row d-flex align-items-center">
    			<div class="col">
    				<p class="social d-flex">
    					<a href="mailto:estate-portal@gmail.com"><span class="icon-mail_outline"></span></a>
    					<a href="https://wa.me/+972597578662?text=Hello%20there!"><span class="icon-whatsapp"></span></a>
    					<a href="https://www.facebook.com/share/16AFvyAUZg/"><span class="icon-facebook"></span></a>
    				</p>
    			</div>
    			<div class="col d-flex justify-content-end">
    				<p class="social"><a href="telto:+972597578662"> <span class="icon-phone"></span>+972597578662</p>
    			</div>
    		</div>
    	</div>
    </div>


        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="./"><span><?php echo $_settings->info('short_name') ?></span>
        <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
        </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> القائمة
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="./" class="nav-link">الرئيسية</a></li>
	          <li class="nav-item"><a href="property.php" class="nav-link">العقارات</a></li>
	          <li class="nav-item"><a href="agents.php" class="nav-link">الوكلاء</a></li>
	          <li class="nav-item"><a href="./?p=about" class="nav-link">حول</a></li>
			  <?php if ($is_logged_in){ ?>
				<li class="nav-item"><a href="./agent" class="nav-link"><span class="icon-home2"></span>عقاراتي</a></li>
				<li class="nav-item cta cta-colored"><a href="<?php echo base_url.'/classes/Login.php?f=logout_agent' ?>" class="nav-link"><span class="icon-sign-out"></span>تسجيل خروج</a></li>

				<?php }else{ ?>
	          <li class="nav-item cta"><a href="./admin" class="nav-link ml-lg-2"><span class="icon-user"></span>دخول مسؤول</a></li>
	          <li class="nav-item cta cta-colored"><a href="./agent" class="nav-link"><span class="icon-sign-in"></span>دخول مستخدم</a></li>
	          <li class="nav-item cta cta-colored"><a href="<?php echo base_url ?>agent/registration.php" class="nav-link"><span class="icon-pencil"></span>تسجيل</a></li>
            <?php }?>
	        </ul>
	      </div>
	    </div>
	  </nav>