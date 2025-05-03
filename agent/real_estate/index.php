<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Real Estates</h3>
		<div class="card-tools">
			<a href="?page=real_estate/manage_estate" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  إإنشاء جديد</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
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
						$qry = $conn->query("SELECT r.*,CONCAT(a.lastname, ', ', a.firstname, ' ', COALESCE(a.middlename, '')) as fullname FROM real_estate_list r inner join agent_list a on r.agent_id = a.id where r.agent_id = '{$_settings->userdata('id')}' order by r.name asc ");
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
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		إجراء
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="?page=real_estate/view_estate&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> عرض</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=real_estate/manage_estate&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> تعديل</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> حذف</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("هل أنت متأكد من حذف هذا العقار بشكل دائم؟","delete_real_estate",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_real_estate($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_real_estate",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("حدث خطأ ما..",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("حدث خطأ ما..",'error');
					end_loader();
				}
			}
		})
	}
</script>