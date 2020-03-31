
<?php 

	include(ROOT_PATH. 'db.php'); 
	class OrderView {
		public function get_order_list ($date) {
			$db = new db();
			$site = $db->query('SELECT * FROM tb_site')->fetchArray();
			return $site;
			
		}
	}
?>