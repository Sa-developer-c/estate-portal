<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
  <body>

	<?php require_once('inc/topBarNav.php') ?>

    <div class="hero-wrap" style="background-image: url('images/bg_1.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="">الرئيسية</a></span> <span>العقارات</span></p>
            <h1 class="mb-3 bread">العقارات</h1>
          </div>
        </div>
      </div>
    </div>

   
    

    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
				<?php
			 $qry = $conn->query("SELECT r.*, t.name as rtype FROM `real_estate_list` r inner join type_list t on r.type_id = t.id where r.status = 1 order by r.`name` asc");
			 while($row = $qry->fetch_assoc()):
			  $meta_qry = $conn->query("SELECT * FROM `real_estate_meta` where real_estate_id = '{$row['id']}' ");
			  $meta = array_column($meta_qry->fetch_all(MYSQLI_ASSOC),"meta_value", "meta_field");
		?>
    			<div class="col-md-4 ftco-animate">
    				<div class="properties">
    					<a href=".?p=view_estate&id=<?= $row['id'] ?>" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url('<?php echo validate_image(isset($meta['thumbnail_path']) ? $meta['thumbnail_path'] : "") ?>');">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<span class="status sale"><?= isset($meta['purpose']) ? $meta['purpose'] : "" ?></span>
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href=".?p=view_estate&id=<?php echo ($row['id']) ?>"><?= $row['name']?> .</a></h3>
		    						<p><?php echo $row['rtype'] ?></p>
	    						</div>
	    						<div class="two">
	    							<span class="price"><?= isset($meta['sale_price']) ? format_num($meta['sale_price']) : "" ?>₪</span>
    							</div>
    						</div>
    						<p><?= isset($meta['location']) ? $meta['location'] : "" ?></p>
    						<hr>
    					
    					</div>
    				</div>
    			</div>
    			<?php
				endwhile;
			?>
    		
    		</div>
    		<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
    	</div>
    </section>
		


    
  
	<?php require_once('inc/footer.php') ?>
  </body>
</html>