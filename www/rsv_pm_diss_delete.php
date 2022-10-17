<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






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

		$sql = "DELETE FROM `pm__dissemination` WHERE id_dis='".$act_id."'";
		$result=mysqli_query($conn, $sql);


		cancella_foto_GE("./data/dissemination",$act_id);

		//Redirect su messaggio
		$strpas11="./rsv_pm_diss.php?wps=".$wps1."&partner=".$partner1;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();


	} else {

		$sql = "SELECT * FROM pm__dissemination WHERE id_dis=".$act_id;
		$result=mysqli_query($conn, $sql);

		while ($row=mysqli_fetch_array($result)) {
			$act_id=$row["id_dis"];
			$id_user=$row["id_user"];
			$data=$row["data"];
			$partner=Pulisci_READ($row["partner"]);
			$contact=Pulisci_READ($row["contact"]);
			//$date_event=Pulisci_READ($row["date_event"]);
			$type_event=Pulisci_READ($row["type_event"]);
			$description=Pulisci_READ($row["description"]);
			$target=Pulisci_READ($row["target"]);
			$n_people=Pulisci_READ($row["n_people"]);
			$held_in=Pulisci_READ($row["held_in"]);
			$outcomes=Pulisci_READ($row["outcomes"]);
			$documents=Pulisci_READ($row["documents"]);

			$period_from=$row["date_event_from"];
			$period_from_gg=substr($period_from, -2);
			$period_from_mm=substr($period_from, 4, 2);
			$period_from_aa=substr($period_from, 0,4);
			$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);
		}
	}
?>

					<hr />
					<h1>Dissemination</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_diss.php">Dissemination</a> > Delete Document</p>
					<br>


					<?php if ($_SESSION["usr_level"]=5) {  ?>


						<div class="el_msg">
							<p class="p01">Do you want to delete this report?</p>

							<p class="titpar">Partners' Institution</p>
							<p class="p03"><?=$partner?></p>

							<p class="titpar">Name of the person involved in the event</p>
							<p class="p03"><?=$contact?></p>

							<p class="titpar">Date of the event</p>
							<p class="p03"><?=$period_from?></p>

							<div style="margin: 35px 0 0 0;">
								<a href="./rsv_pm_diss_delete.php?id_act=<?=$act_id?>&partner=<?=$partner1?>&act=delete"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
								&nbsp;&nbsp;&nbsp;
								<a href="./rsv_pm_diss.php?&partner=<?=$partner1?>"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
							</div>
						</div>


					<?php } else { ?>
						<?php include('./impianto/inc/sorry.php'); //PIEDE?>
					<?php } ?>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
