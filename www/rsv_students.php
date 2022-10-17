<?php
include('./impianto/inc/function.php'); // funzioni PHP


$partner=$_GET["partner"];
$wtype=$_GET["wtype"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiction</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
	
</head>

<body>

<?php include("header2.php"); ?>

	<div class="container">

		<div id="cnt1">
			<div id="corpo"><div id="rsv">
				<div id="rsv_menu"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp">

					<h1>Manage Students</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > Students</p>

					<div style="margin: 5px 0 10px 0;">
						Select Partners' Institution
						<select name="partner" style="width: 300px;margin: 0 0 0 15px;" onchange="javascript:document.location.href='./rsv_students.php?partner='+this.options[this.selectedIndex].value;">
							<option value="">All Partners</option>
							<?
							$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
							$result=mysqli_query($conn, $sql);


							while ($row=mysqli_fetch_array($result)) {
								?>
								<option value="<?=$row["id_partner"]?>" <?php if ($partner==$row["id_partner"]) echo "selected"?>><?=$row["name"]?> (<?=$row["country_sinc"]?>)</option>
								<?
							}
							?>
						</select>
					</div>

					<table class="for1">
						<thead>
							<tr>
								<td class="tdtit" style="width: 100%;">Name and Surname</td>
								<td class="tdtit"><img src="./wiztr.gif" width="200" height="1" />University</td>
								<td class="tdtit"><img src="./wiztr.gif" width="200" height="1" />Partner Institution</td>
								<td class="tdtit"><img src="./wiztr.gif" width="55" height="1" /></td>
							</tr>
						</thead>
						<tbody>
							<?
							if ($_SESSION["id_user"]) {
								$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
								$result=mysqli_query($conn, $sql);


								while ($row=mysqli_fetch_array($result)) {
									$id_partner=Pulisci_READ($row["id_partner"]);
									$usr_level=Pulisci_READ($row["usr_level"]);
								}
							}

							if ($partner!="") {
								$where="WHERE id_partner='".$partner."'";
							} else {
								$where="";
							}

							$sql = "
								SELECT *
								FROM PRT_student
								".$where."
								ORDER BY qst02";
							$result=mysqli_query($conn, $sql);

							$count_tot=mysqli_num_rows($result);

							while ($row=mysqli_fetch_array($result)) {
								$lnk1="./rsv_students_mod.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];
								$lnk3="./rsv_students_del.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];

								$par_permit="off";
								if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
								$adm_permit="off";
								if ($usr_level==5) $adm_permit="on";

								$school_name=Pulisci_READ($row["qst02"]);
								$school_address=Pulisci_READ($row["qst05"]);
								$partner_name=Pulisci_READ($row["partner"]);

								?>
								<tr>
									<td><?=$school_name?></td>
									<td><?=$school_address?></td>
									<td><?=$partner_name?></td>
									<td style="text-align: right;"><?php if ($adm_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete" /></a> <?php }?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit" /></a><?php }?></td>
								</tr>
								<?
							}
							?>
						</tbody>
					</table>



					<div class="clear"></div>
				</div> <!-- rsv_crp -->
				<div class="clear"></div>
			</div></div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
