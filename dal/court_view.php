


<?php 

include(ROOT_PATH. 'db.php'); 

class CourtView {

	public function get_court_by_siteid ($siteid) {
		$db = new db();
		$courtlist = $db->query('SELECT * FROM tb_court WHERE sid = ?', $siteid)->fetchAll();
		return $courtlist;
	}
}

?>