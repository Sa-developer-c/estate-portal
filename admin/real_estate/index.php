<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Real Estates</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="real_estate_table">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Code</th>
						<th>الاسم</th>
						<th>Agent</th>
						<th>الحالة</th>
						<th>إجراء</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT r.*, CONCAT(a.lastname, ', ', a.firstname, ' ', COALESCE(a.middlename, '')) as fullname FROM real_estate_list r inner join agent_list a on r.agent_id = a.id order by r.name asc ");
					while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><p class="m-0 truncate-1"><?= $row['code'] ?></p></td>
							<td><p class="m-0 truncate-1"><?= $row['name'] ?></p></td>
							<td><p class="m-0 truncate-1"><?= $row['fullname'] ?></p></td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success px-3 rounded-pill">متوفر</span>
								<?php else: ?>
									<span class="badge badge-danger px-3 rounded-pill">مباع</span>
								<?php endif; ?>
							</td>
							<td align="center">
								<a class="btn btn-default bg-gradient-light btn-flat btn-sm" href="?page=real_estate/view_estate&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> عرض</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr>
						<th>#</th>
						<th>Code</th>
						<th>الاسم</th>
						<th>Agent</th>
						<th>الحالة</th>
						<th>إجراء</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	// إنشاء مدخلات فلترة تحت كل عنوان
	$('#real_estate_table thead tr')
		.clone(true)
		.addClass('filters')
		.appendTo('#real_estate_table thead');

	var table = $('#real_estate_table').DataTable({
		orderCellsTop: true,
		fixedHeader: true,
		initComplete: function () {
			var api = this.api();
			api.columns().eq(0).each(function (colIdx) {
				if (colIdx == 5) return; // تجاهل عمود الإجراءات

				var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
				$(cell).html('<input type="text" placeholder="بحث..." class="form-control form-control-sm" />');

				$('input', cell).on('keyup change', function () {
					api
						.column(colIdx)
						.search(this.value)
						.draw();
				});
			});
		},
		columnDefs: [
			{ orderable: false, targets: [5] }
		],
		order: [[0, 'asc']],
		language: {
			search: "بحث عام:",
			lengthMenu: "عرض _MENU_ مدخلات",
			info: "عرض _START_ إلى _END_ من أصل _TOTAL_ مدخل",
			paginate: {
				first: "الأول",
				last: "الأخير",
				next: "التالي",
				previous: "السابق"
			},
			zeroRecords: "لا توجد نتائج مطابقة",
		}
	});
	$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
});
</script>
