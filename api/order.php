<?php

include_once('../config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$date = date($queries['date']);
$view = new OrderView();
$result = array();

$list = $view->get_order_list($date);

$result['data'] = $list;

echo json_encode($result)
?>