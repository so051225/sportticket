
<?php 

	include_once(ROOT_PATH. 'db.php'); 
	class OrderView {
		
		public static $q ="
			SELECT `tb_order`.`oid`, `tb_order`.`cuid`, `tb_order`.`id_type`, `tb_order`.`sid`, `tb_order`.`cid`, `order_no`, `ac_date`, `start_time`, `end_time`, `pay_method`, `amount`, `pay_time`, `order_status`, `cancel_reason`, `people_count`, `site_name`, `court_name`, '羽毛球' as `court_type`, `tb_court`.`court_no` as `court_no`, CONCAT(DATE_FORMAT(`start_time`, '%Y-%m-%d %H:%i'), '-', DATE_FORMAT(`end_time`, '%H:%i')) as `time_range_str`, '' as `action`, DATE_FORMAT(`tb_order`.`pay_time`, '%H:%i:%s') as `pay_time_str`, DATE_FORMAT(`tb_order`.`pay_time`, '%H:%i') as `recept_pay_time_str`, DATE_FORMAT(`tb_order`.`pay_time`, '%Y-%m-%d') as `recept_pay_time_date_str`, CONCAT(DATE_FORMAT(`start_time`, '%H:%i'), '-', DATE_FORMAT(`end_time`, '%H:%i')) as `receipt_time_range_str`, CONCAT('MOP ', amount) as `amount_str`, DATE_FORMAT(`start_time`, '%Y-%m-%d') as `receipt_date_str`, `tb_site`.`site_name_zh` as `site_name_zh`, `tb_site`.`site_name_pt` as `site_name_pt`, (case when tb_order.id_type = 'ID' then right(tb_customer.id,4) when tb_order.id_type = 'ESPORT_ID' then right(tb_customer.esport_id,5) else right(tb_customer.other_id,4) end) as `customer_id` FROM `tb_order`, `tb_court`, `tb_site`, `tb_customer` WHERE `tb_order`.`cid` = `tb_court`.`cid` and `tb_court`.`sid` = `tb_site`.`sid` and `tb_customer`.`cuid` = `tb_order`.`cuid` ";
			
		public function get_order_list ($date) {
			$db = new db();
			
			$query = self::$q . " and date(`tb_order`.`pay_time`) = ?";
			
			$orders = $db->query($query, $date)->fetchAll();
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
	}
?>