<?php

// http://localhost/sportticket/api/getAvailableHours.php

$CUTOFF_MINUTES = 50;

$datetime = new DateTime();
$datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));

$hours_start = $datetime->format('H');
$hours_end = $datetime->format('H');
$minutes = $datetime->format('i');

if ($minutes > $CUTOFF_MINUTES) {
	$hours_start += 1;
	$hours_end += 1;
}

$options = array();
for ($hours = $hours_start; $hours <= $hours_end; $hours++) {
	array_push($options, $hours);
}

// echo json_encode("[18, 19]");
echo json_encode($options);

?>