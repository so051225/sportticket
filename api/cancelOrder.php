<?php

// http://localhost/sportticket/api/cancelOrder.php?oid=1

include_once('../config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$oid = htmlspecialchars($_POST["oid"]);

$view = new OrderView();
$list = $view->cancel_order_by_id($oid);
// header("Location:  http://localhost/sportticket/index.php");

echo json_encode($list)

//exit();

?>