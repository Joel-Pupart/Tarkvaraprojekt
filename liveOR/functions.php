<?php
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
	
	function drawPresses($currentShift, $currentQuarter, $roomName, $conn, $time) {
		
		$sql = "
		SELECT ID, MachineID, MachineName, RoomID, RoomName, PosX, PosY 
		FROM t_pressid 
		WHERE PosX is not null
		AND RoomName = '" . $roomName . "';";
			
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($roomName == 'B'){
					//PW-250-1
					if($row["MachineID"] == 11) {
						$top = 200;
						$left = 200;
					}
					//PW250-2
					if($row["MachineID"] == 12) {
						$top = 200;
						$left = 800;
					}
					//PW250-3
					if($row["MachineID"] == 13) {
						$top = 200;
						$left = 1400;
					}
					//PW250-6
					if($row["MachineID"] == 16) {
						$top = 800;
						$left = 1400;
					}
					//PW250-7
					if($row["MachineID"] == 62) {
						$top = 800;
						$left = 800;
					}
					//PW250-8
					if($row["MachineID"] == 63) {
						$top = 800;
						$left = 200;
					}
					//PW250-18
					if($row["MachineID"] == 141) {
						$top = 1400;
						$left = 2100;
					}
					//PW250-12
					if($row["MachineID"] == 125) {
						$top = 800;
						$left = 2700;
					}
					//PW250-13
					if($row["MachineID"] == 126) {
						$top = 800;
						$left = 3300;
					}
					//PW250-14
					if($row["MachineID"] == 127) {
						$top = 1400;
						$left = 3300;
					}
					//PW250-15
					if($row["MachineID"] == 128) {
						$top = 1400;
						$left = 2700;
					}
					
					/* PW250-10
					if($row["MachineID"] == 72) {
						$top = 1200;
						$left = 2000;
					}*/
					/*
					$top = $row["PosY"] - 70;	
					$left = $row["PosX"] - 550;
					$top = $top * 7;
					$left = $left * 7 + 1500;*/
				} else if ($roomName == 'A'){
					//PL100-1
					if($row["MachineID"] == 75) {
						$top = 650;
						$left = 750;
					}
					//PW60-6
					if($row["MachineID"] == 170) {
						$top = 1650;
						$left = 3450;
					}
					//PW60-2
					if($row["MachineID"] == 45) {
						$top = 150;
						$left = 3450;
					}
					//PW60-1
					if($row["MachineID"] == 31) {
						$top = 150;
						$left = 750;
					}
					//PW100-5
					if($row["MachineID"] == 46) {
						$top = 650;
						$left = 2550;
					}
					//PW100-6
					if($row["MachineID"] == 47) {
						$top = 150;
						$left = 1350;
					}
					//PW40-5
					if($row["MachineID"] == 50) {
						$top = 1650;
						$left = 150;
					}
					//PW100-8
					if($row["MachineID"] == 73) {
						$top = 150;
						$left = 2550;
					}
					//PW40-3
					if($row["MachineID"] == 27) {
						$top = 1650;
						$left = 1950;
					}
					//PW40-2
					if($row["MachineID"] == 26) {
						$top = 1650;
						$left = 750;
					}
					//PW40-6
					if($row["MachineID"] == 51) {
						$top = 1650;
						$left = 1350;
					}
					//PW100-15
					if($row["MachineID"] == 222) {
						$top = 650;
						$left = 3450;
					}
					//PW100-10
					if($row["MachineID"] == 97) {
						$top = 1150;
						$left = 3450;
					}
					//PL100-3
					if($row["MachineID"] == 77) {
						$top = 650;
						$left = 150;
					}
					//PW60-5
					if($row["MachineID"] == 70) {
						$top = 1150;
						$left = 1350;
					}
					//PW60-4
					if($row["MachineID"] == 69) {
						$top = 1150;
						$left = 750;
					}
					//PW60-8
					if($row["MachineID"] == 208) {
						$top = 1650;
						$left = 2550;
					}
					//PW60-7
					if($row["MachineID"] == 207) {
						$top = 1150;
						$left = 150;
					}
					//PW100-14
					if($row["MachineID"] == 205) {
						$top = 650;
						$left = 1350;
					}
					//PW60-3
					if($row["MachineID"] == 61) {
						$top = 150;
						$left = 150;
					}
					/*
					$top= $row["PosY"];
					$left = $row["PosX"] - 450;
					$top = $top * 4 - 50;
					$left = $left * 6 + 2000;*/
				} else if ($roomName == 'C1') {
					//FM2-26
					if($row["MachineID"] == 217) {
						$top = 200;
						$left = 2000;
					}
					//FM2-25
					if($row["MachineID"] == 216) {
						$top = 200;
						$left = 1400;
					}
					//FM7-3
					if($row["MachineID"] == 204) {
						$top = 200;
						$left = 800;
					}
					//FM2-27
					if($row["MachineID"] == 218) {
						$top = 200;
						$left = 2600;
					}
					//FM7-2
					if($row["MachineID"] == 79) {
						$top = 1300;
						$left = 100;
					}
					//TYC-1
					if($row["MachineID"] == 89) {
						$top = 1100;
						$left = 1700;
					}
					//TYC-4
					if($row["MachineID"] == 86) {
						$top = 1100;
						$left = 3500;
					}
					//FM2-10
					if($row["MachineID"] == 53) {
						$top = 1600;
						$left = 700;
					}
					//TYC-3
					if($row["MachineID"] == 87) {
						$top = 1100;
						$left = 2900;
					}
					//FM2-12
					if($row["MachineID"] == 55) {
						$top = 800;
						$left = 300;
					}
					//TYC-2
					if($row["MachineID"] == 88) {
						$top = 1100;
						$left = 2300;
					}
					//FM7-1
					if($row["MachineID"] == 78) {
						$top = 200;
						$left = 200;
					}
					//FM2-11
					if($row["MachineID"] == 54) {
						$top = 1100;
						$left = 900;
					}
					/*
					$top = $row["PosY"];
					$left = $row["PosX"] - 300;
					$top = $top * 7 + 100;
					$left = $left * 7 + 2200;*/
				} else if ($roomName == 'C2') {
					//FM2-24
					if($row["MachineID"] == 215) {
						$top = 300;
						$left = 300;
					}
					//FM2-22
					if($row["MachineID"] == 101) {
						$top = 300;
						$left = 1500;
					}
					//FM2-23
					if($row["MachineID"] == 102) {
						$top = 300;
						$left = 900;
					}
					//FM2-21
					if($row["MachineID"] == 68) {
						$top = 300;
						$left = 2100;
					}
					//FM2-20
					if($row["MachineID"] == 67) {
						$top = 300;
						$left = 2700;
					}
					//FM2-19
					if($row["MachineID"] == 66) {
						$top = 300;
						$left = 3300;
					}
					//FM2-18
					if($row["MachineID"] == 65) {
						$top = 1200;
						$left = 3300;
					}
					//FM2-17
					if($row["MachineID"] == 64) {
						$top = 1200;
						$left = 2700;
					}
					//FM2-16
					if($row["MachineID"] == 60) {
						$top = 1200;
						$left = 2100;
					}
					//FM2-15
					if($row["MachineID"] == 59) {
						$top = 1200;
						$left = 1500;
					}
					//FM2-14
					if($row["MachineID"] == 58) {
						$top = 1200;
						$left = 900;
					}
					//FM2-13
					if($row["MachineID"] == 57) {
						$top = 1200;
						$left = 300;
					}
				} else {
					//Saal F
					//PW100-11
					if($row["MachineID"] == 98) {
						$top = 150;
						$left = 1500;
					}
					//PW40-7
					if($row["MachineID"] == 167) {
						$top = 1150;
						$left = 3300;
					}
					//PW250-19
					if($row["MachineID"] == 224) {
						$top = 1150;
						$left = 900;
					}
					//PW100-16
					if($row["MachineID"] == 223) {
						$top = 1150;
						$left = 1500;
					}
					//PL250-3
					/*
					if($row["MachineID"] == 3) {
						$top = 650;
						$left = 900;
					}*/
					//PW60-9
					if($row["MachineID"] == 209) {
						$top = 650;
						$left = 2400;
					}
					//PW40-4
					if($row["MachineID"] == 28) {
						$top = 650;
						$left = 900;
					}
					//PL250-2
					if($row["MachineID"] == 2) {
						$top = 1150;
						$left = 2700;
					}
					//PW100-13
					if($row["MachineID"] == 100) {
						$top = 150;
						$left = 2100;
					}
					//PW100-12
					if($row["MachineID"] == 99) {
						$top = 150;
						$left = 300;
					}
					//PW100-7
					if($row["MachineID"] == 80) {
						$top = 1150;
						$left = 2100;
					}
					//PW250-9
					if($row["MachineID"] == 71) {
						$top = 150;
						$left = 3300;
					}
					//PW250-5
					if($row["MachineID"] == 15) {
						$top = 1650;
						$left = 1200;
					}
					//PW250-4
					if($row["MachineID"] == 14) {
						$top = 1650;
						$left = 1800;
					}
					//PW250-17
					if($row["MachineID"] == 140) {
						$top = 1650;
						$left = 2400;
					}
					//PW40-1
					if($row["MachineID"] == 25) {
						$top = 650;
						$left = 1500;
					}
					//PW250-11
					if($row["MachineID"] == 124) {
						$top = 150;
						$left = 2700;
					}
					//PW250-10
					if($row["MachineID"] == 72) {
						$top = 1150;
						$left = 300;
					}
					//PW100-9
					if($row["MachineID"] == 96) {
						$top = 150;
						$left = 900;
					}
					//PW250-16
					if($row["MachineID"] == 139) {
						$top = 1650;
						$left = 3000;
					}
					/*
					$top = $row["PosY"];
					$left = $row["PosX"] - 300;
					$top = $top * 3.5 + 100;
					$left = $left * 6 + 1850;*/
				}
				
				if ($currentShift == 3 && $time > date("00,00,00") && $time < date("06,00,00")) {
					$dateString = "CURDATE() - 1";
				} else {
					$dateString = "CURDATE()";
				}
				
				$machineId = $row["MachineID"];
				
				$sql2 = "SELECT MAX(t_toodangu_registreerimine.ID), MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'1' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln1 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.27),0) AS norm ,`t prod seisakud pohjused`.pohjus
						FROM t_toodangu_registreerimine
						LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v1
						LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
						WHERE ln1+ln2+ln3+ln4 > 1
						AND Vahetus = " . $currentShift . "
						AND DATE(t_toodangu_registreerimine.timestamp) = " . $dateString . "
						AND MachineID = " . $machineId . "
						GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
						UNION
						SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'2' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln2 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.29),0) AS norm ,`t prod seisakud pohjused`.pohjus
						FROM t_toodangu_registreerimine
						LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v2
						LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
						WHERE ln1+ln2+ln3+ln4 > 1
						AND Vahetus = " . $currentShift . "
						AND DATE(t_toodangu_registreerimine.timestamp) = " . $dateString . "
						AND MachineID = " . $machineId . "
						GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
						UNION
						SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'3' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln3 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.21),0) AS norm ,`t prod seisakud pohjused`.pohjus
						FROM t_toodangu_registreerimine
						LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v3
						LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
						WHERE ln1+ln2+ln3+ln4 > 1
						AND Vahetus = " . $currentShift . "
						AND DATE(t_toodangu_registreerimine.timestamp) = " . $dateString . "
						AND MachineID = " . $machineId . "
						GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
						UNION
						SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'4' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln4 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.23),0) AS norm ,`t prod seisakud pohjused`.pohjus
						FROM t_toodangu_registreerimine
						LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v4
						LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
						WHERE ln1+ln2+ln3+ln4 > 1
						AND Vahetus = " . $currentShift . "
						AND DATE(t_toodangu_registreerimine.timestamp) = " . $dateString . "
						AND MachineID = " . $machineId . "
						GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus;";
						
				$result2 = $conn->query($sql2);
				
				if ($result2->num_rows > 0) {
					$row2 = $result2->fetch_assoc();
								
					$sql3 = "Select MatBez from `t artikel` where `artikel-nr`=".$row2["Artikkel"];
					$matkirjeldus = $conn->query($sql3);
									
					while($row3 = $matkirjeldus->fetch_assoc()) {
						$material = $row3["MatBez"];
					}
					
					$result2 = $conn->query($sql2);
						
					echo "
					<div class='container'>
						<div class='press' style=top:".$top."px;left:".$left."px;>
							<div class='press-element'>Press: ".$row["MachineName"]."</div>
							<div class='press-element'>Artikkel: ".$row2["Artikkel"]."</div>
							<div class='press-element'>Detail: ".$material."</div>
							<div class='table'>
								<ul><li>Kogus</li><li>Norm</li><li>Põhjus</li></ul>";
					while($row2 = $result2->fetch_assoc()) {
						$reason = $row2['pohjus'];
						$amount = intval($row2['kogus']);
						$norm = intval($row2['norm']);
						$quarter = intval($row2['veerand']);
						$bgcolor = "";
									
						if ($reason == NULL) {
							$reason = "-";
						}
						
						if ($quarter >= $currentQuarter && $amount <= 0) {
							$bgcolor = "#F7FAFC";
						} elseif ($amount >= $norm) {
							$bgcolor = "#28A745";
						} elseif  (($norm - $amount) <= 5){
							$bgcolor = "#FFC107";
						} else {
							$bgcolor = "#DC3545";
						}
									
						echo "<ul><li style='background-color: ".$bgcolor.";'>".$amount."</li><li>".$norm."</li><li>".$reason."</li></ul>";
					}
						
					echo "</div></div></div>";
				} else {
					echo "
					<div class='container'>
						<div class='press' style=top:".$top."px;left:".$left."px;>
							<div>Press: ".$row["MachineName"]."</div>
							<div class='stopped'>Seisak</div>
						</div>
					</div>";
				}
			}
		}
	}
?>