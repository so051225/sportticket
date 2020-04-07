<?php

	include_once('config.php');
	include_once(ROOT_PATH . 'dal\site_view.php'); 
	
	class GlobalCommon{		
	
		public function get_sitename () {
			$siteView = new SiteView();
			$site = $siteView->get_site_by_id($this->get_siteid());
			return $site['site_name_zh'];
		}
		
		public function get_siteid() {
			global $config_siteid;	
			return $config_siteid;
		}
		
		public function get_today() {
			
			date_default_timezone_set('Asia/Shanghai');
			$datetime = new DateTime();
			$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));
			$today = $datetime->format('Y-m-d');
			
			return $today;
		}
	}
?>