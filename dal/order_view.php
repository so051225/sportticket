
<?php 

	include(ROOT_PATH. 'db.php'); 
	class OrderView {
		public function get_order_list ($date) {
			$db = new db();
			
			$q ="
			SELECT `tb_order`.`oid`, `tb_order`.`cuid`, `tb_order`.`id_type`, `tb_order`.`sid`, `tb_order`.`cid`, `order_no`, `ac_date`, `start_time`, `end_time`, `pay_method`, `amount`, `pay_time`, `order_status`, `cancel_reason`, `people_count`, `site_name`, `court_name`, '羽毛球' as `court_type`, `tb_court`.`court_no` as `court_no`, CONCAT(DATE_FORMAT(`start_time`, '%Y-%m-%d %H:%i'), '-', DATE_FORMAT(`end_time`, '%H:%i')) as `time_range_str`, '' as `action`, DATE_FORMAT(`tb_order`.`pay_time`, '%H:%i:%s') as `pay_time_str` FROM `tb_order`, `tb_court` WHERE `tb_order`.`cid` = `tb_court`.`cid` and date(`tb_order`.`pay_time`) = ?";
			
			$orders = $db->query($q, $date)->fetchAll();
			return $orders;
			
		}
	}
?>