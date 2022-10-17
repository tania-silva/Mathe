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
	<p class="tit">SNA VideoLesson2Questions</p>
	<br />
	<table>
		<thead>
			<tr>
				<td>VideoLESCode</td>
				<td>n.</td>
				<td>Questions</td>
			</tr>
		</thead>
		<tbody>
				<?php

				$sqlP = "
					SELECT *  
					FROM platform__SNA__VID_lessons 
					WHERE validate=1 
					ORDER BY id ASC";
				$resultP=mysqli_query($conn,$sqlP);
				if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

				while ($rowP=mysqli_fetch_array($resultP)) { 
					
					$qst_id=$rowP["id"];
					$qst_code="VLE".$qst_id;
					$qst_str=$rowP["questions"];

					$qst_str=str_replace("key_","",$qst_str);
					$QstAr=explode("_",$qst_str);

					$QstStr="";
					$QstNum=0;
					foreach( $QstAr as $valore) {
					   if ($valore) {
						   $QstStr.="SNA".$valore.";";
						   $QstNum+=1;
					   }
					}

					if ($QstNum==0) $QstNum="<span style=\"font-weight: bold;color: #c00;\">".$QstNum."</span>"




					?>
					<tr>
						<td><?=$qst_code?></td>
						<td><?=$QstNum?></td>
						<td><?=$QstStr?></td>
					</tr>
					<?php
				}

				?>
		</tbody>
	</table>
<?php }?>

</body>
</html>
