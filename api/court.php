<?php

include_once('../config.php');
include_once(ROOT_PATH . 'dal\court_view.php'); 

$view = new CourtView();
$list = $view->get_court_by_siteid(1);
echo json_encode($list)

?>