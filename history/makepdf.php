<?php
	if(isset($_POST["create_pdf"])){  
		require_once('tcpdf/tcpdf.php');  
		$headerString = "Saal ".$building.", Kuupäeval ".date_format(date_create($_GET['date']), "d.m.Y").", Vahetuses ".$shift;
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
		$pdf->SetTitle($headerString);  
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $headerString);  
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', '20')); 
		$pdf->SetHeaderMargin(10);

	
		$pdf->SetDefaultMonospacedFont('helvetica');   
		$pdf->SetMargins(PDF_MARGIN_LEFT, '25', PDF_MARGIN_RIGHT);  
		$pdf->setPrintFooter(false);  
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  
		$pdf->SetFont('helvetica', '', 10);  
		$pdf->AddPage();  
		$content = '';
		
		$sql = "
			SELECT ID, MachineID, MachineName, RoomID, RoomName, PosX, PosY 
			FROM t_pressid 
			WHERE RoomName ='".$building."' and PosX is not null";
		$result = $conn->query($sql);
		$counter = 0;
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
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
				
				$content .= '<span>Press: '.$row["MachineName"].'</span>';
				if ($result2->num_rows > 0) {
					$row2 = $result2->fetch_assoc();
					
					$sql3 = "Select MatBez from `t artikel` where `artikel-nr`=".$row2["Artikkel"];
					$matkirjeldus = $conn->query($sql3);
						
					while($row3 = $matkirjeldus->fetch_assoc()) {
						$material = $row3["MatBez"];
					}
						
					$result2 = $conn->query($sql2);
					
					
								
					$outputString .= '
						<div>Artikkel: '.$row2["Artikkel"].'</div>
						<span>Detail: '.$material.'</span>
						<br>
						<table style="border: solid black 1px;">
							<tr>
								<th style="border: solid black 1px;" align="center" width="35">Kogus</th>
								<th style="border: solid black 1px;" align="center" width="35">Norm</th>
								<th style="border: solid black 1px;" align="center" width="90">Põhjus</th>
							</tr>';
					
					while($row2 = $result2->fetch_assoc()) {
						$reason = $row2['pohjus'];
						$amount = intval($row2['kogus']);
						$norm = intval($row2['norm']);
							
						if ($reason == NULL) {
							$reason = "-";
						}
						if ($amount >= $norm) {
							$background = '#28A745';
						} elseif (($norm - $amount) <= 5) {
							$background = '#FFC107';
						} else {
							$background = '#DC3545';
						}
						$outputString .= 
							'<tr>
								<td bgcolor="'.$background.'" align="center">'.$amount.'</td>
								<td align="center">'.$norm.'</td>
								<td align="center">'.$reason.'</td>
							</tr>';
					}
					$outputString .= '</table>';
				
					$content .= $outputString;
					$outputString = '';
					$pdf->setCellPaddings(1, 1, 1, 0);
					$pdf->setCellMargins(1, 1, 1, 1);
					$pdf->SetFillColor(255, 255, 255);
					$pdf->MultiCell(58, 40, $content, 1, 'L', 1, ($counter % 3) - 1, '', '', true, 0, true);
					$content = '';
					$counter++;
				} else {
					$content = '';
					//$content .= '<div>Seisak</div></div>';
				}
				
				
			}
		}
		ob_end_clean();
		$pdf->Output('sample.pdf', 'I');  
	}  
?>