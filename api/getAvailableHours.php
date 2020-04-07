<?php

// http://localhost/sportticket/api/getAvailableHours.php

include_once('../global.php');

$options = (new GlobalCommon())->get_available_hours();

// echo json_encode("[18, 19]");
echo json_encode($options);

?>