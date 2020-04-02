<?php

include_once('../config.php');
include_once(ROOT_PATH . 'global.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$date = date($queries['date']);
$view = new OrderView();
$result = array();

$sid = (new GlobalCommon())->get_siteid();

$list = $view->get_order_list($date, $sid);

$result['data'] = $list;

echo json_encode($result)
?>