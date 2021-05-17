<?php
	require_once('config.php');
	require_once('functions.php');
	
	date_default_timezone_set('Europe/Tallinn');
	$time = date("H,i,s");
	$roomName = $_GET['roomName'];
	
	$currentShift = findShift($time);
	$currentQuarter = findQuarter($time);
	
	echo "<div class='press-container'>";
	
	drawPresses($currentShift, $currentQuarter, $roomName, $conn, $time);
	
	echo "</div>";
	
?>