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

		public function get_available_hours() {
			$CUTOFF_MINUTES = 50;

			$datetime = new DateTime();
			$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));

			$hours_start = $datetime->format('H');
			$hours_end = $datetime->format('H');
			$minutes = $datetime->format('i');

			if ($minutes > $CUTOFF_MINUTES) {
				$hours_start += 1;
				$hours_end += 1;
			}
			
			return [$hours_start, $hours_end];
		}
	}
?>