<?php

include_once('../config.php');
include_once(ROOT_PATH . 'global.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$global = new GlobalCommon();
$sid = $global->get_siteid();

// date
if (array_key_exists('date', $queries))
	$date = date($queries['date']);
else
	$date = $global->get_today($global->get_today());

// ismonth
if (array_key_exists('ismonth', $queries))
	$ismonth = $queries['ismonth'] === 'Y'? 'Y' : 'N';
else
	$ismonth = 'N';

$view = new OrderView();
$result = array();

$list = $view->get_order_list($date, $sid, $ismonth);

$result['data'] = $list;

echo json_encode($result)
?>