<?php

// http://localhost/sportticket/api/getSiteAmount.php

include_once('../global.php');

$sid = (new GlobalCommon())->get_siteid();

$datetime = new DateTime();
$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));
$today = $datetime->format('Y-m-d');

function isWeekend($date) {
	$weekDay = date('w', strtotime($date));
	return ($weekDay == 0 || $weekDay == 6);
}

$amount = '20.0';
if ($sid == 1) {
	$amount = isWeekend($today) ? '20.0' : '10.0';
}

echo json_encode($amount);

?>