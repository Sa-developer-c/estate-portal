
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
</style>
<?php 
$brands = isset($_GET['b']) ? json_decode(urldecode($_GET['b'])) : array();
?>
    <section class="home-slider owl-carousel">
    <?php 
                       $qry = $conn->query("SELECT r.*, t.name as rtype FROM `real_estate_list` r inner join type_list t on r.type_id = t.id where r.status = 1 order by r.`name` asc");
                       while($row = $qry->fetch_assoc()):
                        $meta_qry = $conn->query("SELECT * FROM `real_estate_meta` where real_estate_id = '{$row['id']}' ");
                        $meta = array_column($meta_qry->fetch_all(MYSQLI_ASSOC),"meta_value", "meta_field");
                    ?>   
					<div class="slider-item" style="background-image:url('<?php echo validate_image(isset($meta['thumbnail_path']) ? $meta['thumbnail_path'] : "") ?>');">
						<div class="overlay"></div>
						<div class="container">
						<div class="row no-gutters slider-text align-items-md-end align-items-center justify-content-end">
						<div class="col-md-6 text p-4 ftco-animate">
							<h1 class="mb-3"><?= isset($meta['type']) ? $meta['type'] : "" ?></h1>
							<span class="location d-block mb-3"><i class="icon-my_location"></i><?php echo $row['rtype'] ?></span>
							<p><?= isset($meta['purpose']) ? $meta['purpose'] : "" ?></p>
							<span class="price"><?= isset($meta['sale_price']) ? format_num($meta['sale_price']) : "" ?></span>
							<a href=".?p=view_estate&id=<?php echo ($row['id']) ?>" class="btn-custom p-3 px-4 bg-primary">عرض التفاصيل <span class="icon-plus ml-1"></span></a>
						</div>
						</div>
						</div>
					</div>
					<?php endwhile; ?>

    </section>


    <section class="ftco-search">
    	<div class="container">
	    	<div class="row">
					<div class="col-md-12 search-wrap">
						<h2 class="heading h5 d-flex align-items-center pr-4"><span class="ion-ios-search mr-3"></span> ابحث عن العقار</h2>
						<form action="propertyfilter.php" class="search-property" method="GET">
	        		<div class="row">
	  
	        			<div class="col-md align-items-end">
	        				<div class="form-group">
	        					<label for="#">المدينة</label>
	        					<div class="form-field">
	          					<div class="select-wrap">
	                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
	                      <select name="location" id="" class="form-control">
	                      	<option value="">المدينة</option>
	                        <option value="نابلس">نابلس</option>
	                        <option value="رام الله">رام الله</option>
	                        <option value="قلقيلية">قلقيلية</option>
	                        <option value="بيت لحم">بيت لحم</option>
	                        <option value="الخليل">الخليل</option>
	                        <option value="جنين">جنين</option>
	                        <option value="أريحا">أريحا</option>
	                      </select>
	                    </div>
			              </div>
		              </div>
	        			</div>	        			
						<div class="col-md align-items-end">
	        				<div class="form-group">
	        					<label for="#">نوع العقار</label>
	        					<div class="form-field">
	          					<div class="select-wrap">
	                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
	                      <select name="p_type" id="" class="form-control">
	                      	<option value="">النوع</option>
	                        <option value="1">شقة</option>
	                        <option value="2">مكتب</option>
	                        <option value="3">بيت</option>
	                      </select>
	                    </div>
			              </div>
		              </div>
	        			</div>
	        			<div class="col-md align-items-end">
	        				<div class="form-group">
	        					<label for="#">حالة العقار</label>
	        					<div class="form-field">
	          					<div class="select-wrap">
	                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
	                      <select name="type" id="" class="form-control">
	                      	<option value="">النوع</option>
	                        <option value="ايجار">ايجار</option>
	                        <option value="بيع">بيع</option>
	                      </select>
	                    </div>
			              </div>
		              </div>
	        			</div>






	        			<div class="col-md align-self-end">
	        				<div class="form-group">
	        					<div class="form-field">
			                <input type="submit" value="ابحث" name='fillter' class="form-control btn btn-primary">
			              </div>
		              </div>
	        			</div>
	        		</div>
	        	</form>
					</div>
	    	</div>
	    </div>
    </section>

