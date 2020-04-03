<?php

// http://localhost/sportticket/api/checkCourtAvailable.php?hour=18&cid=1

include_once('../config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$cid = $_GET['cid'];
$hour = $_GET['hour'];

$datetime = new DateTime();
$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));
$today = $datetime->format('Y-m-d');
$start_time_str = $today . ' ' . $hour . ':00:00';


$is_error = false;
$is_available = false;

if (!$is_error) {
	$view = new OrderView();
	$is_available = $view->check_court_available($cid, $start_time_str);
}

echo json_encode($is_available);

?>