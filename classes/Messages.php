<?php
require_once('../config.php');

class Messages extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function capture_err() {
        if(!$this->conn->error)
            return false;
        else {
            $message['status'] = 'failed';
            $message['error'] = $this->conn->error;
            return json_encode($message);
            exit;
        }
    }

	function send_message() {
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = addslashes(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		$sql = "INSERT INTO `messages` SET {$data}";
		$save = $this->conn->query($sql);
	
		header('Content-Type: application/json'); 
	
		if($save){
			$message = [
				'status' => 'success',
				'msg' => 'تم الإرسال'
			];
		} else {
			$message = [
				'status' => 'failed',
				'error' => $this->conn->error . "[{$sql}]"
			];
		}
	
		echo json_encode($message);
		exit;
	}
	
	function fetch_messages() {
		extract($_POST);
		$data = [];
	
		$qry = $this->conn->query("SELECT * FROM messages 
			WHERE property_id = '{$property_id}' 
			AND ((sender_id = '{$sender_id}' OR receiver_id = '{$receiver_id}') 
			OR (sender_id = '{$receiver_id}' OR receiver_id = '{$sender_id}')) 
			ORDER BY id ASC");
	
		while($row = $qry->fetch_assoc()){
			$data[] = $row;
		}
	
		// جلب أسماء وصور المستخدمين المشاركين في المحادثة
		$user_ids = array_unique(array_merge(
			array_column($data, 'sender_id'),
			array_column($data, 'receiver_id')
		));
	
		$user_names = [];
		$user_avatars = [];
		$user_ids_str = implode(",", array_map('intval', $user_ids));
		$uqry = $this->conn->query("SELECT id, CONCAT(lastname, ' ', firstname) as fullname, avatar FROM agent_list WHERE id IN ($user_ids_str)");
		while($row = $uqry->fetch_assoc()) {
			$user_names[$row['id']] = $row['fullname'];
			$user_avatars[$row['id']] = $row['avatar'];
		}
	
		return json_encode([
			'status' => 'success',
			'messages' => $data,
			'user_names' => $user_names,
			'user_avatars' => $user_avatars
		]);
	}
	function mark_sold() {
		extract($_POST);
		$update = $this->conn->query("UPDATE `real_estate_list` SET status = 0, sold_date = NOW() WHERE id = '{$id}'");
		if ($update) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode([
				'status' => 'failed',
				'msg' => 'خطأ في تحديث الحالة: ' . $this->conn->error
			]);
		}
		exit;
	}
	
	function feedback() {
		extract($_POST);
		$id = intval($id); // حماية أساسية
		$rating = intval($rating); // تحويل التقييم لعدد صحيح
	
		// تأكد إذا العقار موجود
		$check = $this->conn->query("SELECT feedback FROM `real_estate_list` WHERE id = '{$id}'");
		if ($check && $check->num_rows > 0) {
			$current = $check->fetch_assoc();
	
			if (empty($current['feedback'])) {
				
				$update = $this->conn->query("UPDATE `real_estate_list` SET feedback = '{$rating}' WHERE id = '{$id}'");
				if ($update) {
					echo json_encode(['status' => 'success']);
				} else {
					echo json_encode([
						'status' => 'failed',
						'msg' => 'خطأ في تحديث التقييم: ' . $this->conn->error
					]);
				}
			} else {
				// لو فيه تقييم سابق، ممكن تعرض رسالة أنه موجود أصلاً
				echo json_encode([
					'status' => 'failed',
					'msg' => 'تم تقييم هذا العقار مسبقاً'
				]);
			}
		} else {
			echo json_encode([
				'status' => 'failed',
				'msg' => 'العقار غير موجود'
			]);
		}
		exit;
	}
}	

// تنفيذ الإجراء
$Messages = new Messages();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);

switch ($action) {
    case 'send_message':
        echo $Messages->send_message();
        break;

    case 'fetch_messages':
        echo $Messages->fetch_messages();
        break;

		case 'mark_sold':
			echo $Messages->mark_sold();
			break;

			case 'feedback': // اضف هذا السطر
				echo $Messages->feedback();
				break;
		
    default:
       
        break;
}
