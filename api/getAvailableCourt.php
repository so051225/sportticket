<?php

// http://localhost/sportticket/api/getCourtBySite.php?siteid=1

include_once('../config.php');
include_once('../global.php');
include_once(ROOT_PATH . 'dal\court_view.php'); 
include_once(ROOT_PATH . 'dal\order_view.php'); 

function checkCourt($cid, $hour) {

	$datetime = new DateTime();
	$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));
	$today = $datetime->format('Y-m-d');
	$start_time_str = $today . ' ' . $hour . ':00:00';

	$is_available = false;

	$view = new OrderView();
	$is_available = $view->check_court_available($cid, $start_time_str);
	
	return $is_available;
}

function getCourtsBySiteId($siteId) {
	$view = new CourtView();
	$list = $view->get_court_by_siteid($siteId);
	return $list;
}

// get courts list
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$siteId = $queries['siteid'];
$courts = getCourtsBySiteId($siteId);

// get available hour
$hourStartEnd = (new GlobalCommon())->get_available_hours();

$options = array();
for ($hours = $hourStartEnd[0]; $hours <= $hourStartEnd[1]; $hours++) {
	
	$options[$hours] = array();
	foreach($courts as $court) {
		if (checkCourt($court['cid'], $hours)){
			array_push($options[$hours], $court);
		}
	}
}
echo json_encode($options)

?>
