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
	}
?>