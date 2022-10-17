<?php include('top.php'); ?>
<!-- INCOLLA START -->






	<div class="container" id="sottomenu">
		<div id="cnt1" class="row">

			<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
			<div id="rsv_crp" class="col-md-9">
				
<?php

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."librerie".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'id_act'=>'int',
			'act'=>'str',
			'wps'=>'sql',
			'partner'=>'sql'
	);

	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

	$act=$_GET["act"];
	$act_id=$_GET["id_act"];
	$wps1=$_GET["wps"];
	$partner1=$_GET["partner"];

	if ($act=="delete" AND $act_id) {

		$sql = "DELETE FROM `pm__workinprogress` WHERE id_act='".$act_id."'";
		$result=mysqli_query($conn, $sql);

		//Redirect su messaggio
		$strpas11="./rsv_pm_wip.php?wps=".$wps1."&partner=".$partner1;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();

	} else {

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

		 switch ($wps)
		{
			case "IO1":   $wps_name="IO1 - Student Assessment Toolkit";
			break;
			case "IO2":   $wps_name="IO2 - Math Library";
			break;
			case "IO3":   $wps_name="IO3 - Community of Practice ";
			break;
			case "ME":   $wps_name="ME - Multiplier Events";
			break;
			case "PM":   $wps_name="PM - Project Management";
			break;
		}
	}
?>
					<hr />
					<h1>Work in Progress</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_wip.php">Work in Progress</a> > Delete Document</p>
					<br>


					<?php if ($_SESSION["usr_level"]=5) {  ?>


						<div class="el_msg">
							<p class="p01">Do you want to delete this report?</p>

							<p class="titpar">Partners' Institution</p>
							<p class="p03"><?=$partner?></p>

							<p class="titpar">Project's period (from/to)</p>
							<p class="p03"><?=$period?></p>

							<p class="titpar">Activities concerned:</p>
							<p class="p03"><?=$wps_name?></p>

							<div style="margin: 35px 0 0 0;">
								<a href="./rsv_pm_wip_delete.php?id_act=<?=$act_id?>&wps=<?=$wps1?>&partner=<?=$partner1?>&act=delete"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
								&nbsp;&nbsp;&nbsp;
								<a href="./rsv_pm_wip.php?wps=<?=$wps1?>&partner=<?=$partner1?>"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
							</div>
						</div>


					<?php } else { ?>
						<?php include('./impianto/inc/sorry.php'); //PIEDE?>
					<?php } ?>

			</div>
		</div> <!-- cnt1 -->
	</div> <!-- container -->






<!-- INCOLLA END -->
<?php include('bottom.php'); ?>
