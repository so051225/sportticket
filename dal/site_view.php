

<?php 

include_once(ROOT_PATH. 'db.php'); 

class SiteView {
	public function get_site_by_id ($siteid) {
		$db = new db();
		$site = $db->query('SELECT * FROM tb_site WHERE sid = ?', $siteid)->fetchArray();
		return $site;
	}
}

?>