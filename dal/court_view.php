


<?php 

include_once(ROOT_PATH. 'db.php'); 

class CourtView {

	public function get_court_by_siteid ($siteid) {
		$db = new db();
		$courtlist = $db->query('SELECT * FROM tb_court WHERE sid = ?', $siteid)->fetchAll();
		return $courtlist;
	}

	public function get_court_by_cid($cid) {
		$db = new db();

		$court = $db->query('SELECT * FROM tb_court WHERE cid = ?', $cid)->fetchArray();
		$db->close();

		return $court;
	}
}

?>