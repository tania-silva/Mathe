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

		$sql = "DELETE FROM `news` WHERE id='".$act_id."'";
		$result=mysqli_query($conn, $sql);

		/* Cancello immagine associata */
		if(file_exists("./data/news/".$act_id."_ico.jpg")) unlink("./data/news/".$act_id."_ico.jpg");
		if(file_exists("./data/news/".$act_id."_big.jpg")) unlink("./data/news/".$act_id."_big.jpg");

		//Redirect su messaggio
		$strpas11="./rsv_news.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();


	} else {

		$sql = "SELECT * FROM news WHERE id=".$act_id;
		$result=mysqli_query($conn, $sql);

		while ($row=mysqli_fetch_array($result)) {
			$pict_id=$row["id"];
			$title=stripslashes($row["title"]);
			$text=stripslashes($row["text"]);
			$date=$row["date"];
		}

		if ($date!="" AND $date!="0000-00-00 00:00:00") {
			$fatt_data_expl=explode("-",$date);
			$fatt_data_aa=$fatt_data_expl[0];
			$fatt_data_mm=$fatt_data_expl[1];
			$fatt_data_expl1=explode(" ",$fatt_data_expl[2]);
			$fatt_data_gg=$fatt_data_expl1[0];
			$fatt_data_expl2=explode(":",$fatt_data_expl1[1]);
			$fatt_data_ora=$fatt_data_expl2[0];
			$fatt_data_min=$fatt_data_expl2[1];
			$date=$fatt_data_gg."/".$fatt_data_mm."/".$fatt_data_aa." ".$fatt_data_ora.":".$fatt_data_min;
		} else $date="";


		$pict="./data/news/".$pict_id.".jpg";
	}
?>

					<hr />

					<?php if ($_SESSION["usr_level"]==5) {  ?>


						<h1>News</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_news.php">News</a> > Delete News</p>
						<br>

						<div class="el_msg">
							<p class="p01">Do you want to delete this news</p>

							<p class="titpar">Date</p>
							<p class="p03"><?=$date?></p>

							<p class="titpar">Title</p>
							<p class="p03"><?=$title?></p>

							<p class="titpar">Text</p>
							<p class="p03"><?=$text?></p>

							<div style="margin: 35px 0 0 0;">
								<a href="./rsv_news_delete.php?id_act=<?=$act_id?>&act=delete"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
								&nbsp;&nbsp;&nbsp;
								<a href="./rsv_news.php"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
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
