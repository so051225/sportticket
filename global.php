<?php

	
	include_once('db.php'); 
	
	class GlobalCommon{		
	
		public function get_sitename () {
			$db = new db();
			$site = $db->query('SELECT * FROM tb_site WHERE sid = ?', $this->get_siteid())->fetchArray();
			return $site['site_name_zh'];
		}
		
		public function get_siteid() {
			global $config_siteid;	
			return $config_siteid;
		}
	}
?>