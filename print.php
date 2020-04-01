<?php

include_once('config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$oid = date($queries['oid']);
$view = new OrderView();
$order = $view->get_order_by_id(1);

?>