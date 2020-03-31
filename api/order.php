<?php

include_once('../config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 


$view = new OrderView();
$list = $view->get_order_list(1);
echo json_encode($list)

?>