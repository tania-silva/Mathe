<?php
//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
?>
<?php include('top.php'); ?>

<!-- INCOLLA START -->







	<?php
	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."librerie".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'id_act'=>'int',
			'wps'=>'sql',
			'partner'=>'sql'
	);

	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////
	$act_id=$_GET["id_act"];
	$wps1=$_GET["wps"];
	$partner1=$_GET["partner"];

	$sql = "SELECT * FROM pm__workinprogress WHERE id_act=".$act_id;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$act_id=$row["id_act"];
		$data=$row["data"];
		$id_user=$row["id_user"];
		$partner=Pulisci_READ($row["partner"]);
		$wps=Pulisci_READ($row["wps"]);
		$objectives=Pulisci_READ($row["objectives"]);
		$time=Pulisci_READ($row["time"]);
		$description=Pulisci_READ($row["description"]);
		$outcomes=Pulisci_READ($row["outcomes"]);
		$evaluation=Pulisci_READ($row["evaluation"]);

		$period_from=$row["period_from"];
		$period_from_gg=substr($period_from, -2);
		$period_from_mm=substr($period_from, 4, 2);
		$period_from_aa=substr($period_from, 0,4);
		//$period_from=$period_from_gg.".".$period_from_mm.".".$period_from_aa;
		$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

		$period_to=$row["period_to"];
		$period_to_gg=substr($period_to, -2);
		$period_to_mm=substr($period_to, 4, 2);
		$period_to_aa=substr($period_to, 0,4);
		$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
		$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

		$period="";
		if ($row["period_from"]!="0") $period.=$period_from;
		if ($row["period_to"]!="0") $period.=" - ".$period_to;
	}

	 switch ($wps) {
		case "IO1":   $wps_name="IO1 - Student Assessment Toolkit";
		break;
		case "IO2":   $wps_name="IO2 - Math Library";
		break;
		case "IO3":   $wps_name="IO3 - Community of Practice";
		break;
		case "ME":   $wps_name="ME - Multiplier Events";
		break;
		case "PM":   $wps_name="PM - Project Management";
		break;
	}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alcmaeon</title>

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

	<div class="container">
		<div class="row">

				<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp" class="col-md-9">
		<hr>

					<h1>Work in Progress</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_wip.php">Work in Progress</a> > Document Preview</p>

					<p class="titpar">ACTIVITIES REPORT</p>
					<div class="txt">
						<a href="./rsv_pm_wip_stampa.php?id_act=<?=$act_id?>" style="color: #444;" onclick="this.target='_blank';">click here for the <strong style="color: #0000bb;">printable version</strong></a>

						<?php if ($partner) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Partners' Institution:</div>
						<div class="p04"><?=$partner?></div><?php }?>

						<?php if ($period) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Project's period (from/to):</div>
						<div class="p04"><?=$period?></div><?php }?>

						<?php if ($wps_name) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />WP  concerned:</div>
						<div class="p04"><?=$wps_name?></div><?php }?>

						<?php if ($objectives) { ?>
						<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Objectives of activities carried out:</div>
						<div class="p04"><?=nl2br($objectives)?></div><?php }?>

						<?php if ($description) { ?>
						<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Description of activities carried out:</div>
						<div class="p04"><?=nl2br($description)?></div><?php }?>

						<?php if ($outcomes) { ?>
						<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Results Achieved:</div>
						<div class="p04"><?=nl2br($outcomes)?></div><?php }?>

						<!-- <?php if ($evaluation) { ?>
						<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Evaluation of the work undertaken:</div>
						<div class="p04"><?=nl2br($evaluation)?></div><?php }?> -->
					</div>


					<br /><br />

					<div class="insrt" style="text-align: left;margin-left: 15px;"><a href="./rsv_pm_wip.php?wps=<?=$wps1?>&amp;partner=<?=$partner1?>">back to result</a></div>

				</div> <!-- rsv_crp -->
				<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->






<!-- INCOLLA END -->
<?php include('bottom.php'); ?>
