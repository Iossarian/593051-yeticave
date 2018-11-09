<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();

$sql =  "SELECT * FROM lots
        WHERE end_time <= NOW() AND winner_id IS NULL";
?>