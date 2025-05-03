<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_amenity(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = addslashes(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `amenity_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "اسم الميزة موجود بالفعل.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `amenity_list` set {$data} ";
		}else{
			$sql = "UPDATE `amenity_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "تم حفظ الميزة الجديدة بنجاح.";
			else
				$resp['msg'] = " تم تحديث الخدمة بنجاح.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_amenity(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `amenity_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," تم حذف الخدمة بنجاح.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `type_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "نوع العقار موجود بالفعل.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `type_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `type_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," تم حفظ نوع العقار الجديد بنجاح.");
			else
				$this->settings->set_flashdata('success'," تم تحديث نوع العقار بنجاح.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," تم حذف نوع العقار بنجاح.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_estate(){
		$_POST['description'] = htmlentities($_POST['description']);
		if(empty($id)){
			$prefix = date("Ym");
			$code = sprintf("%'.05d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `real_estate_list` where code = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$_POST['code'] = $prefix.$code;
			$_POST['agent_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$rel_tbl_allowed_fields = ["code","name","type_id","agent_id","status"];
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,$rel_tbl_allowed_fields)){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `real_estate_list` set {$data} ";
		}else{
			$sql = "UPDATE `real_estate_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$eid = empty($id) ? $this->conn->insert_id : $id;
			$resp['eid'] = $eid;
			$upload_path = "uploads/estate_".$eid;
			$resp['msg'] = " Data successfully saved.";
			$resp['status'] = 'success';
			if(!is_dir(base_app.$upload_path))
				mkdir(base_app.$upload_path);
			if(isset($_FILES['imgs']) && count($_FILES['imgs']['tmp_name']) > 0){
				$err = "";
				foreach($_FILES['imgs']['tmp_name'] as $k => $v){
					if(!empty($_FILES['imgs']['tmp_name'][$k])){
						$accept = array('image/jpeg','image/png');
						if(!in_array($_FILES['imgs']['type'][$k],$accept)){
							$err = "Image file type is invalid";
							break;
						}
						if($_FILES['imgs']['type'][$k] == 'image/jpeg')
							$uploadfile = imagecreatefromjpeg($_FILES['imgs']['tmp_name'][$k]);
						elseif($_FILES['imgs']['type'][$k] == 'image/png')
							$uploadfile = imagecreatefrompng($_FILES['imgs']['tmp_name'][$k]);
						if(!$uploadfile){
							$err = "Image is invalid";
							break;
						}
						list($width,$height) = getimagesize($_FILES['imgs']['tmp_name'][$k]);
						$temp = imagescale($uploadfile,$width,$height);
						$spath = base_app.$upload_path.'/'.$_FILES['imgs']['name'][$k];
						$i = 0;
						while(true){
							if(is_file($spath)){
								$spath = base_app.$upload_path.'/'.$i."_".$_FILES['imgs']['name'][$k];
							}else{
								break;
							}
							$i++;
						}
						if($_FILES['imgs']['type'][$k] == 'image/jpeg')
						imagejpeg($temp, $spath);
						elseif($_FILES['imgs']['type'][$k] == 'image/png')
						imagepng($temp, $spath);

						imagedestroy($temp);
					}
				}
				if(!empty($err)){
					$resp['msg'] .= " But ".$err;
				}
			}
			if(!empty($_FILES['img']['tmp_name'])){
				$err = "";
				if(!is_dir(base_app."uploads/thumbnails")){
					mkdir(base_app."uploads/thumbnails");
				}
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$err = "Image file type is invalid";
				}
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = "uploads/thumbnails/$eid.$ext";
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$err = "Image is invalid";
				}
				list($width,$height) = getimagesize($_FILES['img']['tmp_name']);
				$temp = imagescale($uploadfile,$width,$height);
				if(is_file(base_app.$fname))	
					unlink(base_app.$fname);			
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploaded = imagejpeg($temp, base_app.$fname);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploaded = imagepng($temp, base_app.$fname);
				else
					$uploaded = false;
				if($uploaded){
					$_POST['thumbnail_path'] = $fname."?v=".(time());
				}

				imagedestroy($temp);
				if(!empty($err)){
					$resp['msg'] .= " But ".$err;
				}
			}
			$data="";
			foreach($_POST as $k =>$v){
				if(!in_array($k,array_merge($rel_tbl_allowed_fields,['id','amenity_ids']))){
					if(!empty($data)) $data .=", ";
					$k = $this->conn->real_escape_string($k);
					$v = $this->conn->real_escape_string($v);
					$data .= "('{$eid}', '{$k}', '{$v}')";
				}
			}
			if(!empty($data)){
				$this->conn->query("DELETE FROM `real_estate_meta` where `real_estate_id` = '{$eid}'");
				$sql2 = "INSERT INTO `real_estate_meta` (`real_estate_id`, `meta_field`, `meta_value`) VALUES {$data}";
				$save2 = $this->conn->query($sql2);
				if(!$save2){
					$resp['status'] = 'failed';
					$resp['msg'] = " Saving Real Estate Data failed.";
					$resp['err'] = $this->conn->error;
					$resp['sql'] = $sql2;
					if(empty($id))
					$this->conn->query("DELETE FROM `real_estate_list` where id = '{$eid}'");
				}else{
					$data="";
					foreach($amenity_ids as $k =>$v){
							if(!empty($data)) $data .=", ";
							$data .= "('{$eid}', '{$v}')";
					}
					if(!empty($data)){
						$this->conn->query("DELETE FROM `real_estate_amenities` where `real_estate_id` = '{$eid}'");
						$sql3 = "INSERT INTO `real_estate_amenities` (`real_estate_id`, `amenity_id`) VALUES {$data}";
						$save3 = $this->conn->query($sql3);
						if(!$save3){
							$resp['status'] = 'failed';
							$resp['msg'] = " Saving Real Estate Data failed.";
							$resp['err'] = $this->conn->error;
							$resp['sql'] = $sql3;
							if(empty($id))
							$this->conn->query("DELETE FROM `real_estate_list` where id = '{$eid}'");
						}
					}
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_estate(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `real_estate_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," estate successfully deleted.");
			if(is_dir(base_app."uploads/estate_".$id)){
				$fopen = scandir(base_app."uploads/estate_".$id);
				foreach($fopen as $file){
					if(!in_array($file,[".",".."])){
						unlink(base_app."uploads/estate_".$id."/".$file);
					}
				}
				rmdir(base_app."uploads/estate_".$id);
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_amenity':
		echo $Master->save_amenity();
	break;
	case 'delete_amenity':
		echo $Master->delete_amenity();
	break;
	case 'save_type':
		echo $Master->save_type();
	break;
	case 'delete_type':
		echo $Master->delete_type();
	break;
	case 'save_sub_type':
		echo $Master->save_sub_type();
	break;
	case 'delete_sub_type':
		echo $Master->delete_sub_type();
	break;
	case 'save_estate':
		echo $Master->save_estate();
	break;
	case 'delete_estate':
		echo $Master->delete_estate();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	default:
		// echo $sysset->index();
		break;
}