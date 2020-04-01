<?php

include_once('../global.php');
include_once('../dao/order.php');
include_once('../dal/order_view.php');
include_once('../dal/customer_view.php');
include_once('../dal/court_view.php');

$common = new GlobalCommon();

date_default_timezone_set('Asia/Shanghai');
$datetime = new DateTime();
$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));

// check count of used time
function is_valid_times($cuid, $date) {
	var_dump($cuid, $date);
	$order_view = new OrderView();
	$count = $order_view->get_record_count($cuid, $date);
	return $count <= 2;
	return true;
}

// get data from post request
print_r($_POST);

// $datetime->format('Y-m-d H:i:s');

$order = new Order();
$order->id_type = $_POST['id_type'];
$order->sid = $common->get_siteid();
$order->cid = $_POST['court_id'];
$order->ac_date = $datetime->format('Y-m-d');

// order number
$prefix = sprintf("%03d", $common->get_siteid());
$order->order_no = $prefix . $datetime->format('YmdHis');

// order time
if ($_POST['time_option'] == "time_option_1") {
	$order->start_time = $_POST['time_option_1_start'];
	$order->end_time = $_POST['time_option_1_end'];
} else {
	$order->start_time = $_POST['time_option_2_start'];
	$order->end_time = $_POST['time_option_2_end'];
}

$order->pay_method = $_POST['pay_method'];
$order->amount = 20.00;
$order->pay_time = $_POST['pay_time'];
$order->order_status = 0;
$order->cancel_reason = "";
$order->people_count = $_POST['quantity'];
$order->site_name = $common->get_sitename();

// customer
$customer_view = new CustomerView();
$cuid = $customer_view->get_customerid($_POST['id_type'], $_POST['id_value']);
if ($cuid == NULL) {
	$cuid = $customer_view->add_customer($_POST['id_type'], $_POST['id_value']);
}
$order->cuid = $cuid;
$customer = $customer_view->get_customer_by_id($cuid);
var_dump ($customer);

// court
$court_view = new CourtView();
$court = $court_view->get_court_by_cid($_POST['court_id']);
$order->court_name = $court == NULL ? "" : $court['court_no'];

// validation checking
if (is_valid_times($order->cuid, $datetime->format('Y-m-d'))) {
	// create order
	$order_view = new OrderView();
	$order_view->post_order($order);
	// var_dump("create order success");
} else {
	// var_dump("create order failed");
}

header("Location: /sportticket");
exit();

?>