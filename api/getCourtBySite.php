<?php

// http://localhost/sportticket/api/getCourtBySite.php?siteid=1

include_once('../config.php');
include_once(ROOT_PATH . 'dal\court_view.php'); 

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$view = new CourtView();
$list = $view->get_court_by_siteid($queries['siteid']);
echo json_encode($list)

?>