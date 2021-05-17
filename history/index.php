<html>
	<head>
		<title>Ajaloo vaatamine</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>
	<body>
		<form action="index.php" method="get">
		<div class="menu-container" id="searchbar">
			<div class="menu-item">
				<label class="element">
					<input type="radio" name="hoone" value="A"
					<?php 
						if (isset($_GET['hoone']) && $_GET['hoone'] == "A") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>Saal A</span>
				</label>
				<label class="element">
					<input type="radio" name="hoone" value="B"
					<?php 
						if (isset($_GET['hoone']) && $_GET['hoone'] == "B") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>Saal B</span>
				</label>
				<label class="element">
					<input type="radio" name="hoone" value="C1"
					<?php 
						if (isset($_GET['hoone']) && $_GET['hoone'] == "C1") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>Saal C1</span>
				</label>
				<label class="element">
					<input type="radio" name="hoone" value="C2"
					<?php 
						if (isset($_GET['hoone']) && $_GET['hoone'] == "C2") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>Saal C2</span>
				</label>
				<label class="element">
					<input type="radio" name="hoone" value="F"
					<?php 
						if (isset($_GET['hoone']) && $_GET['hoone'] == "F") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>Saal F</span>
				</label>
			</div>
				
			<div class="menu-item">
				<label class="element">
					<input type="radio" name="vahetus" value="1"
					<?php 
						if (isset($_GET['vahetus']) && $_GET['vahetus'] == "1") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>1. Vahetus</span>
				</label>
				<label class="element">
					<input type="radio" name="vahetus" value="2"
					<?php 
						if (isset($_GET['vahetus']) && $_GET['vahetus'] == "2") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>2. Vahetus</span>
				</label>
				<label class="element">
					<input type="radio" name="vahetus" value="3"
					<?php 
						if (isset($_GET['vahetus']) && $_GET['vahetus'] == "3") {
							echo 'checked = "true"';
						}
					?>
					>
					<span>3. Vahetus</span>
				</label>
			</div>
			
			<div class="menu-item">
				<input class="date-field" type="date" name="date"
				<?php
					if (isset($_GET['date'])) {
						echo "value=" . date_format(date_create($_GET['date']), "Y-m-d"); 
					} else {
						echo "value=" . date('Y-m-d');
					}
				?>
				>
			</div>
			</form>
			<div class="menu-item">
				<input class="submit-button" id="submit" type="submit" value="SAADA PÄRING"></input>
				
				<form method="post" class="menu-item" style="margin: 0px;">
					<input class="submit-button" id="pdf" name="create_pdf" type="submit" value="PRINDITAV PDF"></input>
				</form>
		
			</div>
			
			
			<div class="toggle-btn" onclick="toggleSearchBar()">
				<span class="button-design"></span>
				<span class="button-design"></span>
				<span class="button-design"></span>
			</div>
		</div>
		
		
		<script src="scripts/app.js"></script>
			<?php
				require_once('config.php');
				include('functions.php');
				
				date_default_timezone_set('Europe/Tallinn');
				$time = date("H,i,s");
				
				if (isset($_GET['hoone'])) {
					$building = $_GET['hoone'];
				}
				if (isset($_GET['date'])) {
					$date = date_format(date_create($_GET['date']), "j-n-Y");
					$date2 = date_format(date_create($_GET['date']), "Y-m-d");
				}
				if (isset($_GET['vahetus'])) {
					$shift = $_GET['vahetus'];
				}
				
				require_once('makepdf.php');
				
				if (!isset($_GET['hoone'], $_GET['date'], $_GET['vahetus'])) {
					echo "<div class='information'><h2>Sisesta päring</h2></div>";
					if (isset($_GET['date'])) {
						if (!isset($_GET['hoone'])) {
							echo "<div class='alert'>Palun valige hoone!</div>";
						}
						if (!isset($_GET['vahetus'])) {
							echo "<div class='alert'>Palun valige vahetus!</div>";
						}
					}
					
				} else {	
					$dropdownString = "";
					$latestDate = NULL;
					
					$currentShift = findShift($time);
					$currentQuarter = findQuarter($time);
					
					echo "
						<div class='information'><h2>Saal ".$building.", 
						Kuupäeval ".date_format(date_create($_GET['date']), "d.m.Y").", 
						Vahetuses ".$shift."</h2></div>
						<div style='display: flex; justify-content: center;'><div class='schematic'>";
					
					if ($shift == "3") {
						$date = date("j-n-Y", strtotime('+1 day', strtotime($date)));
					}
					
					
					$sql = "
						SELECT ID, MachineID, MachineName, RoomID, RoomName, PosX, PosY 
						FROM t_pressid 
						WHERE RoomName ='".$building."' and PosX is not null";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							if ($building == 'B'){
								$top = $row["PosY"] - 70;	
								$left = $row["PosX"] - 550;
							} else if ($building == 'A'){
								$top= $row["PosY"];
								$left = $row["PosX"] - 450;
							} else {
								$top = $row["PosY"];
								$left = $row["PosX"] - 300;
							}
							
							$pressString = "";
							$outputString = "";
							
							$pressString .= "<div class='press' style=top:".$top."px;left:".$left."px;><div>".$row["MachineName"];
							$machineId = $row["MachineID"];
							
							$sql2 = "SELECT MAX(t_toodangu_registreerimine.ID), MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'1' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln1 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.27),0) AS norm ,`t prod seisakud pohjused`.pohjus
									FROM t_toodangu_registreerimine
									LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v1
									LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
									WHERE ln1+ln2+ln3+ln4 > 1
									AND Vahetus = " . $shift . "
									AND DATE(t_toodangu_registreerimine.timestamp) = '" . $date2 . "'
									AND MachineID = " . $machineId . "
									GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
									UNION
									SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'2' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln2 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.29),0) AS norm ,`t prod seisakud pohjused`.pohjus
									FROM t_toodangu_registreerimine
									LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v2
									LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
									WHERE ln1+ln2+ln3+ln4 > 1
									AND Vahetus = " . $shift . "
									AND DATE(t_toodangu_registreerimine.timestamp) = '" . $date2 . "'
									AND MachineID = " . $machineId . "
									GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
									UNION
									SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'3' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln3 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.21),0) AS norm ,`t prod seisakud pohjused`.pohjus
									FROM t_toodangu_registreerimine
									LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v3
									LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
									WHERE ln1+ln2+ln3+ln4 > 1
									AND Vahetus = " . $shift . "
									AND DATE(t_toodangu_registreerimine.timestamp) = '" . $date2 . "'
									AND MachineID = " . $machineId . "
									GROUP BY MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,veerand,kp,kogus,norm ,`t prod seisakud pohjused`.pohjus
									UNION
									SELECT t_toodangu_registreerimine.ID, MachineID, t_toodangu_registreerimine.Artikkel, Vahetus,'4' AS veerand, CONCAT(DAY(`timestamp`),'-',MONTH(`timestamp`),'-',YEAR(`timestamp`)) AS kp,ln4 AS kogus,ROUND((`t_vahetuse_normid`.Tsykleid * 0.23),0) AS norm ,`t prod seisakud pohjused`.pohjus
									FROM t_toodangu_registreerimine
									LEFT JOIN `t prod seisakud pohjused` ON `t prod seisakud pohjused`.PohjuseID = v4
									LEFT JOIN `t_vahetuse_normid` ON t_toodangu_registreerimine.Artikkel = t_vahetuse_normid.Artikkel
									WHERE ln1+ln2+ln3+ln4 > 1
									AND Vahetus = " . $shift . "
									AND DATE(t_toodangu_registreerimine.timestamp) = '" . $date2 . "'
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
					
								
								$outputString .= "</div><div class='results'>";
								
								$dropdownString .= "
									<div class='dropdown-content'>
										<div class='dropdown-element'>Press: ".$row["MachineName"]."</div>
										<div class='dropdown-element'>Artikkel: ".$row2["Artikkel"]."</div>
										<div class='dropdown-element'>Detail: ".$material."</div>
										<div class='table'>
											<ul><li>Kogus</li><li>Norm</li><li>Põhjus</li></ul>
										";
								while($row2 = $result2->fetch_assoc()) {
									$reason = $row2['pohjus'];
									$amount = intval($row2['kogus']);
									$norm = intval($row2['norm']);
									$quarter = intval($row2['veerand']);
									$bgcolor = "";
									
									if ($reason == NULL) {
										$reason = "-";
									}
									
									if ($date == date("j-n-Y") && $shift == $currentShift && $quarter > $currentQuarter - 1) {
										$bgcolor = "#F7FAFC";
									} elseif ($amount >= $norm) {
										$bgcolor = "#28A745";
									} elseif  (($norm - $amount) <= 5){
										$bgcolor = "#FFC107";
									} else {
										$bgcolor = "#DC3545";
									}
									
									$dropdownString .= "<ul><li style='background-color: ".$bgcolor.";'>".$amount."</li><li>".$norm."</li><li>".$reason."</li></ul>";
									$outputString .= "
										<div style='background-color: ".$bgcolor.";width: 25%; height: 100%; text-align:center;
										float: left; font-size:8;'></div>";
								}
								$dropdownString .= "</div></div>";
								$pressString .= $dropdownString . $outputString . "</div>";
								echo $pressString;
								$outputString = "";
								$pressString = "";
								$dropdownString = "";
							}
						else {
							$pressString .= $outputString . "</div><div style='font-size:14'>Seisak</div>";
							echo $pressString;
							
						}
							echo "</div>";
						}
					} else {
						echo "<div class='alert'>0 tulemust!</div>";
					}
					
					echo "</div></div>";
					
					$conn->close();
				}
			?>
	</body>
</html>