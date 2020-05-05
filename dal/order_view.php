
<?php 

	include_once(ROOT_PATH. 'db.php'); 
	class OrderView {
		
		public static $q = "
			SELECT `tb_order`.`oid`, `tb_order`.`cuid`, `tb_order`.`id_type`, `tb_order`.`sid`, `tb_order`.`cid`, `order_no`, `ac_date`, `start_time`, `end_time`, `pay_method`, `amount`, `pay_time`, `order_status`, `cancel_reason`, `people_count`, `site_name`, `court_name`, '羽毛球' as `court_type`, `tb_court`.`court_no` as `court_no`, CONCAT(DATE_FORMAT(`start_time`, '%Y-%m-%d %H:%i'), '-', DATE_FORMAT(`end_time`, '%H:%i')) as `time_range_str`, '' as `action`, DATE_FORMAT(`tb_order`.`pay_time`, '%H:%i:%s') as `pay_time_str`, DATE_FORMAT(`tb_order`.`pay_time`, '%H:%i') as `recept_pay_time_str`, DATE_FORMAT(`tb_order`.`pay_time`, '%Y-%m-%d') as `recept_pay_time_date_str`, CONCAT(DATE_FORMAT(`start_time`, '%H:%i'), '-', DATE_FORMAT(`end_time`, '%H:%i')) as `receipt_time_range_str`, CONCAT('MOP ', amount) as `amount_str`, DATE_FORMAT(`start_time`, '%Y-%m-%d') as `receipt_date_str`, `tb_site`.`site_name_zh` as `site_name_zh`, `tb_site`.`site_name_pt` as `site_name_pt`, (case when tb_order.id_type = 'ID' then right(tb_customer.id,4) when tb_order.id_type = 'ESPORT_ID' then right(tb_customer.esport_id,6) else right(tb_customer.other_id,4) end) as `customer_id`, (case when `tb_order`.`order_status` = 0 then '成功' else '已取消' end)as `status_str` FROM `tb_order`, `tb_court`, `tb_site`, `tb_customer` WHERE `tb_order`.`cid` = `tb_court`.`cid` and `tb_court`.`sid` = `tb_site`.`sid` and `tb_customer`.`cuid` = `tb_order`.`cuid` ";
			
		public function get_order_list ($date, $sid, $ismonth) {
			$db = new db();

			if ($ismonth === 'N') 
				$query = self::$q . " and date(`tb_order`.`pay_time`) = ? and `tb_order`.`sid` = ? ";
			else 
				$query = self::$q . " and (abs(DATEDIFF(date(`tb_order`.`pay_time`), ?)) <= 30 ) and `tb_order`.`sid` = ? ";
			
			$orders = $db->query($query, $date, $sid)->fetchAll();
	
			$db->close();
			return $orders;			
		}
		
		public function get_order_by_id ($oid) {
			
			$db = new db();			
			$query = self::$q . " and `tb_order`.`oid` = ?";		
			
			$order = $db->query($query, $oid)->fetchArray();
			$db->close();
			return $order;
		}

		public function cancel_order_by_id ($oid) {
			
			$db = new db();			
			$query = " update `tb_order` set `order_status` = 1 where oid = ?";		
			
			$flag = $db->query($query, $oid);			
			
			$db->close();
			return $flag;
		}

		public function post_order($data) {
			$db = new db();
			$order = $db->query('INSERT INTO tb_order(cuid,id_type,sid,cid,order_no,ac_date,start_time,end_time,pay_method,amount,pay_time,order_status,cancel_reason,people_count,site_name,court_name) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
				$data->cuid,
				$data->id_type,
				$data->sid,
				$data->cid,
				$data->order_no,
				$data->ac_date,
				$data->start_time,
				$data->end_time,
				$data->pay_method,
				$data->amount,
				$data->pay_time,
				$data->order_status,
				$data->cancel_reason,
				$data->people_count,
				$data->site_name,
				$data->court_name
			);
			
			$oid = $db->lastInsertID();
			
			$db->close();			
		
			return $oid;
		}

		public function get_record_count($cuid, $date) {
			$db = new db();
			$record = $db->query(
				'SELECT * FROM tb_order WHERE cuid = ? AND ac_date = ? AND order_status = 0',
				$cuid, $date
			);
			$numRows = $record->numRows();
			$db->close();			
			return $numRows;
		}

		public function check_court_available($cid, $start_time) {
			$db = new db();
			$record = $db->query(
				'SELECT * FROM tb_order WHERE cid = ? AND start_time = ? AND order_status = 0',
				$cid, $start_time
			);
			$numRows = $record->numRows();
			$db->close();
			return $numRows == 0;
		}

		public function check_customer_limit($cuid, $start_time) {
			return $this->get_record_count($cuid, $start_time) < 2;
		}
	}
?>