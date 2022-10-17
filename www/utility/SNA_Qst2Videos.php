<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
<head>
	<title>Utility</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="generator" content="Amee IV" />
	<meta name="author" content="Ing. Francesco Pinzani" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<?php require_once('../impianto/inc/function.php');?>
</head>

<style>
	p.tit {font-size: 2.4em;font-weight: 400;text-align: center;}
	body {font: 9pt arial};
	table {margin: 0;padding: 0;border-collapse: collapse;border: none}
	table thead td {padding: 2px;font-weight: bold;color: #fff;background-color: #444;}
	table tbody td {padding: 2px;border-bottom: solid 1px #ddd;}
</style>

<body>

<?php if ($partnerPT) { ?> 
	<br />
	<p class="tit">SNA Question2Videos</p>
	<br />
	<table>
		<thead>
			<tr>
				<td>QstCode</td>
				<td>n.</td>
				<td>Video Lessons</td>
				<td>Video Review</td>
				<td>Teaching Sources</td>
			</tr>
		</thead>
		<tbody>
				<?php

				$sqlP = "
					SELECT *  
					FROM platform__SNA__questions 
					WHERE validate=1 
					ORDER BY id ASC";
				$resultP=mysqli_query($conn,$sqlP);
				if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

				while ($rowP=mysqli_fetch_array($resultP)) { 
					
					$qst_id=$rowP["id"];
					$qst_code="SNA".$qst_id;


					$sqlVL = "
						SELECT id, validate, questions 
						FROM platform__SNA__VID_lessons
						WHERE (INSTR(questions, '_{$qst_id}_')>0 AND validate=1)";
					$resultVL=mysqli_query($conn, $sqlVL);
					$nVL=mysqli_num_rows($resultVL);

					$VLStr="";
					while ($rowVL=mysqli_fetch_array($resultVL)) { 
						$VLId_id=$rowVL["id"];

						$VLStr.="VLE".$VLId_id.";";
					}


					$sqlVR = "
						SELECT id, validate, questions 
						FROM platform__SNA__VID_reviews 
						WHERE (INSTR(questions, '_{$qst_id}_')>0 AND validate=1)";
					$resultVR=mysqli_query($conn, $sqlVR);
					$nVR=mysqli_num_rows($resultVR);

					$VRStr="";
					while ($rowVR=mysqli_fetch_array($resultVR)) { 
						$VRId_id=$rowVR["id"];

						$VRStr.="VRE".$VRId_id.";";
					}


					$sqlTM = "
						SELECT id, validate, questions 
						FROM platform__SNA__tchmaterials 
						WHERE (INSTR(questions, '_{$qst_id}_')>0 AND validate=1)";
					$resultTM=mysqli_query($conn, $sqlTM);
					$nTM=mysqli_num_rows($resultTM);

					$TMStr="";
					while ($rowTM=mysqli_fetch_array($resultTM)) { 
						$TMId_id=$rowTM["id"];

						$TMStr.="TCM".$TMId_id.";";
					}

					$nVideo=$nVL+$nVR+$nTM;
					if ($nVideo==0) $nVideo="<span style=\"font-weight: bold;color: #c00;\">".$nVideo."</span>"


					?>
					<tr>
						<td><?=$qst_code?></td>
						<td><?=$nVideo?></td>
						<td><?=$VLStr?></td>
						<td><?=$VRStr?></td>
						<td><?=$TMStr?></td>
					</tr>
					<?php
				}

				?>
		</tbody>
	</table>
<?php }?>

</body>
</html>
