<?php
$today = date("Y-m-d");
$today2 = date("2017-2-10");
$start = new DateTime($today2);
$end = new DateTime($today);

$interval = $end->diff($start);

$days = $interval->days;

echo $days;
