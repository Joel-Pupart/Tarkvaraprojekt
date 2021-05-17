<?php
	function findQuarter($time) {
		if ($time > date("08,00,00") && $time < date("14,00,00")) {
			if ($time >= date("06,00,00") && $time < date("08,00,00")){
				$currentQuarter = 1;
			} elseif ($time >= date("08,00,00") && $time < date("10,00,00")){
				$currentQuarter = 2;
			} elseif ($time >= date("10,00,00") && $time < date("12,00,00")){
				$currentQuarter = 3;
			} else {
				$currentQuarter = 4;
			}
		} elseif ($time > date("14,00,00") && $time < date("22,00,00")) {
			if ($time >= date("14,00,00") && $time < date("16,00,00")){
				$currentQuarter = 1;
			} elseif ($time >= date("16,00,00") && $time < date("18,00,00")){
				$currentQuarter = 2;
			} elseif ($time >= date("18,00,00") && $time < date("20,00,00")){
				$currentQuarter = 3;
			} else {
				$currentQuarter = 4;
			}
		} else {
			if ($time >= date("22,00,00") && $time < date("00,00,00")){
				$currentQuarter = 1;
			} elseif ($time >= date("00,00,00") && $time < date("02,00,00")){
				$currentQuarter = 2;
			} elseif ($time >= date("02,00,00") && $time < date("04,00,00")){
				$currentQuarter = 3;
			} else {
				$currentQuarter = 4;
			}
		}
		
		return $currentQuarter;
	}
		
	function findShift($time) {
		if ($time > date("08,00,00") && $time < date("14,00,00")) {
			$currentShift = 1;
		} elseif ($time > date("14,00,00") && $time < date("22,00,00")) {
			$currentShift = 2;
		} else {
			$currentShift = 3;
		}
		
		return $currentShift;
	}
?>