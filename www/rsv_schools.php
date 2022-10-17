<?php
include('./impianto/inc/function.php'); // funzioni PHP


$partner=isset($_GET["partner"]) ? $_GET["partner"] : '';
$wtype=isset($_GET["wtype"]) ? $_GET["wtype"] : '';
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
	
    <script type="text/javascript" src="./impianto/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="./impianto/addons/ckfinder/ckfinder.js"></script>
</head>

<body>

	<?php include("header.php"); ?>
	<div class="container">
		<div class="row">

				<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp" class="col-md-9">
		<hr>
					<h1>Manage Schools</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Schools</p>

					<div style="margin: 5px 0 10px 0;">
						Select Partners' Institution
						<select name="partner" style="width: 300px;margin: 0 0 0 15px;" onchange="javascript:document.location.href='./rsv_schools.php?partner='+this.options[this.selectedIndex].value;">
							<option value="">All Partners</option>
							<?php
							$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
							$result=mysqli_query($conn, $sql);


							while ($row=mysqli_fetch_array($result)) {
								?>
								<option value="<?=$row["id_partner"]?>" <?php if ($partner==$row["id_partner"]) echo "selected"?>><?=$row["name"]?> (<?=$row["country_sinc"]?>)</option>
								<?php
							}
							?>
						</select>
					</div>

						
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="width:25%;">Name of the school</th>
								<th style="width:35%;">Address</th>
								<th style="width:auto;">School Typology</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($_SESSION["id_user"]) {
								$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
								$result=mysqli_query($conn, $sql);

								while ($row=mysqli_fetch_array($result)) {
									$id_partner=Pulisci_READ($row["id_partner"]);
									$usr_level=Pulisci_READ($row["usr_level"]);
								}
							}

							if ($partner!="") {
								$where="WHERE id_partner=".$partner;
							} else {
								$where="";
							}

							$sql = "SELECT * FROM members_school ".$where." ORDER BY sch_name";
							$result=mysqli_query($conn, $sql);

							$count_tot=mysqli_num_rows($result);

							while ($row=mysqli_fetch_array($result)) {
								$lnk="./school_report.php?id_sch=".$row["id_sch"]."&amp;id_partner=".$row["id_partner"];
								$lnk1="./rsv_schools_mod.php?id_sch=".$row["id_sch"]."&amp;id_partner=".$row["id_partner"];
								$lnk3="./rsv_schools_del.php?id_sch=".$row["id_sch"]."&amp;id_partner=".$row["id_partner"];
								$lnk4="./school_stampa.php?id_sch=".$row["id_sch"];

								$par_permit="off";
								if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
								$adm_permit="off";
								if ($usr_level==5) $adm_permit="on";

								$school_name=Pulisci_READ($row["sch_name"]);
								$school_address=Pulisci_READ($row["sch_address"]);
								$partner_name=Pulisci_READ($row["partner"]);
								$school_type=Pulisci_READ($row["sch_type"]);

								?>
								<tr>
									<td><?=$school_name?></td>
									<td><?=$school_address?></td>
									<td><?=$school_type?></td>
									<td style="text-align: right;"><?php if ($adm_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete this school" /></a> <?php }?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit this school" /></a><?php }?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>




				</div> <!-- rsv_crp -->

		</div> <!-- cnt1 -->

	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
