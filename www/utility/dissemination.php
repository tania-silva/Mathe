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
	<p class="tit">Dissemination</p>
	<br />
	<table>
		<thead>
			<tr>
				<td>ID</td>
				<td>Name of the partner</td>
				<td>Date of the event</td>
				<td>Type of Dissemination event</td>
				<td>Other Type</td>
				<td>Description of Dissemination Event</td>
				<td>Target group</td>
				<td>Number of people reached by event</td>
				<td>Country</td>
			</tr>
		</thead>
		<tbody>
				<?php

				$sql = "
					SELECT * 
					FROM pm__dissemination 
					ORDER BY date_event_from DESC,partner ASC";
				$result=mysqli_query($conn,$sql);

				while ($row=mysqli_fetch_array($result)) { 
					$diss_type_event="";
					
					$diss_id=Pulisci_READ($row["id_dis"]);
					$partner_name=Pulisci_READ($row["partner"]);
					$diss_date_event_from=Pulisci_READ($row["date_event_from"]);
					$diss_type_event=Pulisci_READ($row["type_event"]);
					$diss_type_event_other=Pulisci_READ($row["type_event_other"]);
					$diss_description=Pulisci_READ($row["description"]);
					$diss_target=Pulisci_READ($row["target"]);
					$diss_n_people=Pulisci_READ($row["n_people"]);
					$diss_held_in_country=Pulisci_READ($row["held_in_country"]);

					/* Dissemination Date */
					$diss_date_event_from_gg=substr($diss_date_event_from, -2);
					$diss_date_event_from_mm=substr($diss_date_event_from, 4, 2);
					$diss_date_event_from_aa=substr($diss_date_event_from, 0,4);
					$diss_date_event_from=$diss_date_event_from_gg.".".$diss_date_event_from_mm.".".$diss_date_event_from_aa;


					/* Country */
					$diss_held_in_country_name="";
					$sql0 = "SELECT * FROM countries WHERE id=".$diss_held_in_country;
					$result0=mysqli_query($conn,$sql0);

					while ($row0=mysqli_fetch_array($result0)) { 
						$diss_held_in_country_name=Pulisci_READ($row0["name"]);
					}

					/* Target Group */
					$diss_target_str="";
					$sql1 = "SELECT * FROM db_TGR_app ORDER BY id_key";
					$result1=mysqli_query($conn,$sql1);

					while ($row1=mysqli_fetch_array($result1)) { 
						$id_key=$row1["id_key"];
						$nome=$row1["nome"];

						if (strrpos($diss_target,"_".$id_key."_")) $diss_target_str.=$nome.", ";
					}
					$diss_target_str=substr($diss_target_str,0,-2);

					?>
					<tr>
						<td><?=$diss_id?></td>
						<td><?=$partner_name?></td>
						<td><?=$diss_date_event_from?></td>
						<td><?=$diss_type_event?></td>
						<td><?=$diss_type_event_other?></td>
						<td><?=$diss_description?></td>
						<td><?=$diss_target_str?></td>
						<td><?=$diss_n_people?></td>
						<td><?=$diss_held_in_country_name?></td>
					</tr>
					<?php
				}

				?>
		</tbody>
	</table>
<?}?>

</body>
</html>
