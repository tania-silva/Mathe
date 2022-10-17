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
			'wps'=>'sql',
			'partner'=>'sql'
	);

	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

	$act_id=$_GET["id_act"];
	$wps1=$_GET["wps"];
	$partner1=$_GET["partner"];

	$sql = "SELECT * FROM pm__dissemination WHERE id_dis=".$act_id;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$act_id=$row["id_dis"];
		$id_user=$row["id_user"];
		$data=$row["data"];
		$partner=Pulisci_READ($row["partner"]);
		$contact=Pulisci_READ($row["contact"]);
		$date_event=Pulisci_READ($row["date_event"]);
		$type_event=Pulisci_READ($row["type_event"]);
		$type_event_other=Pulisci_READ($row["type_event_other"]);
		$description=Pulisci_READ($row["description"]);
		$target=Pulisci_READ($row["target"]);
		$n_people=Pulisci_READ($row["n_people"]);
			$held_in_town=Pulisci_READ($row["held_in_town"]);
			$held_in_country=Pulisci_READ($row["held_in_country"]);
		$outcomes=Pulisci_READ($row["outcomes"]);
		$documents=Pulisci_READ($row["documents"]);

		if ($type_event=="Other") $type_event=$type_event_other;

		$period_from=$row["date_event_from"];
		$period_from_gg=substr($period_from, -2);
		$period_from_mm=substr($period_from, 4, 2);
		$period_from_aa=substr($period_from, 0,4);
		//$period_from=$period_from_gg.".".$period_from_mm.".".$period_from_aa;
		$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

		$period_to=$row["date_event_to"];
		$period_to_gg=substr($period_to, -2);
		$period_to_mm=substr($period_to, 4, 2);
		$period_to_aa=substr($period_to, 0,4);
		$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
		$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

		$period="";
		if ($row["date_event_from"]!="0") $period.=$period_from;
		if ($row["date_event_to"]!="0") $period.=" - ".$period_to;


	}

	$sql = "SELECT * FROM countries WHERE id=".$held_in_country;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$held_in_country_name=Pulisci_READ($row["name"]);
	}


	// Target Group
	$target_str="";
	$sql = "SELECT * FROM db_TGR_app ORDER BY id_key";
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$id_key=$row["id_key"];
		$nome=$row["nome"];

		if (strrpos($target,"_".$id_key."_")) $target_str.=$nome."<br />";
	}
	$target_str=substr($target_str,0,-6);

?>

					<hr />
					<h1>Dissemination</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_pm_diss.php">Dissemination</a> > Document Preview</p>

					<p class="titpar">DISSEMINATION REPORT</p>
					<div class="txt">

						<?php if ($partner) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Partners' Institution:</div>
						<div class="p04"><?=$partner?></div><?php }?>

						<?php if ($contact) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Name of the person involved in the event:</div>
						<div class="p04"><?=$contact?></div><?php } ?>

						<?php if ($period) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Date of the event:</div>
						<div class="p04"><?=$period?></div><?php } ?>

						<?php if ($type_event) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Type of Dissemination event:</div>
						<div class="p04"><?=$type_event?></div><?php } ?>

						<?php if ($description) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Description of Dissemination Event:</div>
						<div class="p04"><?=$description?></div><?php } ?>

						<?php if ($target_str) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Target group:</div>
						<div class="p04"><?=$target_str?></div><?php } ?>

						<?php if ($n_people) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Number of people reached by event:</div>
						<div class="p04"><?=$n_people?></div><?php } ?>

						<?php if ($held_in_town OR $held_in_country) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Held in:</div>
						<div class="p04"><?=$held_in_town?> (<?=$held_in_country_name?>)</div><?php } ?>

						<?php if ($outcomes) { ?><div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Outcomes, Results and Evaluation:</div>
						<div class="p04"><?=nl2br($outcomes)?></div><?php } ?>

						<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Supporting Documents:</div>
						<div class="p04"><?php dir_list_GE("./data/dissemination",$act_id); ?></div>
					</div>


					<br /><br />

					<div class="insrt" style="text-align: left;margin-left: 15px;"><a href="./rsv_pm_diss.php?wps=<?=$wps1?>&amp;partner=<?=$partner1?>">back to result</a></div>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
