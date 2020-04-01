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
$today = $datetime->format('Y-m-d');

// 消毒 post values

$start_hour = str_replace( 'time_option_', '', $_POST['time_option']);
$start_time_str = $today . ' ' . $start_hour . ':00:00';
$end_time_str = $today . ' ' . ($start_hour + 1) . ':00:00';


$cid = $_POST['court_id'];


// check court availability

$is_error = false;
$errs = array();

$order_view = new OrderView();
$is_error = !$order_view -> check_court_available($cid, $start_time_str);

if ($is_error) {
	array_push($errs, '錯誤: 場地時間已佔用');
}


// real insert record
if(!$is_error) {
	$order = new Order();
	$order->id_type = $_POST['id_type'];
	$order->sid = $common->get_siteid();
	$order->cid = $_POST['court_id'];
	$order->ac_date = $today;

	// order number
	$prefix = sprintf("%03d", $common->get_siteid());
	$order->order_no = $prefix . $datetime->format('YmdHis');

	// order time
	// $start_hour = str_replace( 'time_option_', '', $_POST['time_option']);

	// $start_time_str = $order->ac_date . ' ' . $start_hour . ':00:00';
	// $end_time_str = $order->ac_date . ' ' . ($start_hour + 1) . ':00:00';

	$order->start_time = $start_time_str;
	$order->end_time = $end_time_str;

	// if ($_POST['time_option'] == "time_option_1") {
	// 	$order->start_time = $_POST['time_option_1_start'];
	// 	$order->end_time = $_POST['time_option_1_end'];
	// } else {
	// 	$order->start_time = $_POST['time_option_2_start'];
	// 	$order->end_time = $_POST['time_option_2_end'];
	// }

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

	// check customer limit (2 hr)	
	$is_error =  !$order_view->check_customer_limit($cuid, $today);
	
	if ($is_error) {
		array_push($errs, '錯誤: 用戶今天使用兩小時');
	}
	
	if (!$is_error) {
		// court
		$court_view = new CourtView();
		$court = $court_view->get_court_by_cid($_POST['court_id']);
		$order->court_name = $court == NULL ? "" : $court['court_no'];

		$order_view = new OrderView();
		$order_view->post_order($order);
		header("Location: /sportticket/index.php");
		exit();
	}
}

?>

<?php if ($is_error): ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>錯誤</title>
</head>
<body>
	<div class='container'>
		<?php 
			foreach ($errs as $value) {
			  	echo $value;
			}
		?>
		<br>
		<button class="btn btn-danger" onclick="window.location.href ='/sportticket/index.php'"><i class="fa fa-home"></i>返回</button>
	</div>
</body>
</html>
<?php endif; ?>