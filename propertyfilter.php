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
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : '';
$p_type = isset($_GET['p_type']) ? trim($_GET['p_type']) : '';

// بناء الاستعلام الأساسي مع الانضمام لجلب بيانات الميتا المطلوبة مباشرة من قاعدة البيانات
$sql = "
    SELECT r.*, t.name as rtype,
        MAX(CASE WHEN m.meta_field = 'purpose' THEN m.meta_value END) as purpose,
        MAX(CASE WHEN m.meta_field = 'location' THEN m.meta_value END) as meta_location
    FROM real_estate_list r
    LEFT JOIN type_list t ON r.type_id = t.id
    LEFT JOIN real_estate_meta m ON r.id = m.real_estate_id
    WHERE r.status = 1
";

// شروط LIKE لتشابه جزئي
if (!empty($location)) {
    $location_escaped = $conn->real_escape_string($location);
    $sql .= " AND m.meta_field = 'location' AND m.meta_value LIKE '%{$location_escaped}%'";
}

if (!empty($type)) {
    $type_escaped = $conn->real_escape_string($type);
    $sql .= " AND EXISTS (
        SELECT 1 FROM real_estate_meta m2 
        WHERE m2.real_estate_id = r.id 
        AND m2.meta_field = 'purpose' 
        AND m2.meta_value LIKE '%{$type_escaped}%'
    )";
}

if (!empty($p_type)) {
    $sql .= " AND r.type_id = '{$p_type}'";
}

$sql .= " GROUP BY r.id ORDER BY r.name ASC";

$qry = $conn->query($sql);
$found_results = false;
// عرض النتائج
while ($row = $qry->fetch_assoc()):
  $found_results = true;
    // تحميل باقي بيانات الميتا
    $meta_qry = $conn->query("SELECT * FROM real_estate_meta WHERE real_estate_id = '{$row['id']}'");
    $meta = $meta_qry->fetch_all(MYSQLI_ASSOC);
    $meta = $meta ? array_column($meta, 'meta_value', 'meta_field') : [];
?>
    <div class="col-md-4 ftco-animate">
        <div class="properties">
            <a href=".?p=view_estate&id=<?= $row['id'] ?>" class="img img-2 d-flex justify-content-center align-items-center"
                style="background-image: url('<?php echo validate_image(isset($meta['thumbnail_path']) ? $meta['thumbnail_path'] : "") ?>');">
                <div class="icon d-flex justify-content-center align-items-center">
                    <span class="icon-search2"></span>
                </div>
            </a>
            <div class="text p-3">
                <span class="status sale"><?= htmlspecialchars($row['purpose']) ?></span>
                <div class="d-flex">
                    <div class="one">
                        <h3><a href=".?p=view_estate&id=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a></h3>
                        <p><?= htmlspecialchars($row['rtype']) ?></p>
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

// ✅ في حال لم يتم العثور على أي نتائج
if (!$found_results):
?>
    <div class="col-12 text-center">
        <div class="alert alert-warning" role="alert">
            لم يتم العثور على أي عقارات تطابق معايير البحث.
        </div>
    </div>
<?php endif; ?>


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