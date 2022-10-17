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
	<?php

	function Date2ITA_short($dateENG) {
		$date_expl=explode("-",$dateENG);
		$date_aa=$date_expl[0];
		$date_mm=$date_expl[1];
		$date_expl1=explode(" ",$date_expl[2]);
		$date_gg=$date_expl1[0];
		$date_expl2=explode(":",$date_expl1[1]);
		$date_ora=$date_expl2[0];
		$date_min=$date_expl2[1];
		$dateITA=$date_gg.".".$date_mm.".".$date_aa;

		if ($dateITA=="00.00.0000 00:00" OR $dateITA==".. :") $dateITA="";

		return $dateITA;
	}

	?>


<?php if ($partnerPT) { ?> 
	<br />
	<p class="tit">SNA Video Lessons</p>
	<br />
	<table>
		<thead>
			<tr>
				<td>Code</td>
				<td>Lecturer</td>
				<td>Institution</td>
				<td>Date</td>
				<td>Status</td>
			</tr>
		</thead>
		<tbody>
				<?php

				$sql = "
					SELECT 
						p.*, q.*, k.*, 
						p.id AS qst_id,
						p.subtopic AS qst_subtopic,
						p.date AS qst_date,
						p.validate AS qst_validate,
						q.name AS lect_name,
						q.surname AS lect_surname,
						y.name AS uni_name, 
						r.name AS qst_topic, 
						j.name AS qst_subtopic_name
					FROM platform__SNA__VID_lessons as p 
					LEFT JOIN platform__user as q 
					ON p.id_lect=q.id 
					LEFT JOIN platform__lecturers as k 
					ON p.id_lect=k.id_lect 
					LEFT JOIN platform__university as y 
					ON k.uni_name=y.id 
					LEFT JOIN platform__topic as r 
					ON p.topic=r.id 
					LEFT JOIN platform__subtopic as j 
					ON p.subtopic=j.id 
					#WHERE p.validate=4
					ORDER BY p.date DESC";
				$result=mysqli_query($conn,$sql);

				while ($row=mysqli_fetch_array($result)) { 
					
					$qst_id=Pulisci_READ($row["qst_id"]);
					$qst_code="VRE".$qst_id;
					$qst_topic=Pulisci_READ($row["qst_topic"]);
					$qst_subtopic=Pulisci_READ($row["qst_subtopic"]);
					$qst_subtopic_name=Pulisci_READ($row["qst_subtopic_name"]);
					$lect_name=Pulisci_READ($row["lect_name"]);
					$lect_surname=Pulisci_READ($row["lect_surname"]);
					$qst_institution=Pulisci_READ($row["uni_name"]);
					$qst_date=Pulisci_READ($row["qst_date"]);
					$qst_validate=Pulisci_READ($row["qst_validate"]);

					if ($qst_validate==0) $qst_validate_tr="In Progress";
					elseif ($qst_validate==1) $qst_validate_tr="Approved";
					elseif ($qst_validate==2) $qst_validate_tr="Not Approved";
					//elseif ($qst_validate==3) $qst_validate_tr="Approved";
					elseif ($qst_validate==4) $qst_validate_tr="To Be Evaluated";

					if ($qst_subtopic==0) $qst_subtopic="";

					$qst_date=Date2ITA_short($qst_date);

					?>
					<tr>
						<td><?=$qst_code?></td>
						<td><?=$lect_name?> <?=$lect_surname?></td>
						<td><?=$qst_institution?></td>
						<td><?=$qst_date?></td>
						<td><?=$qst_validate_tr?></td>
					</tr>
					<?php
				}

				?>
		</tbody>
	</table>
<?}?>

</body>
</html>
