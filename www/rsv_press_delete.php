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

		$sql = "DELETE FROM `press` WHERE id='".$act_id."'";
		$result=mysqli_query($conn, $sql);


		/* Cancello immagine associata */
		if(file_exists("./data/press/".$act_id.".jpg")) unlink("./data/press/".$act_id.".jpg");

		//Redirect su messaggio
		$strpas11="./rsv_press.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>"; die();


	} else {

		$sql = "SELECT * FROM press WHERE id=".$act_id;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$pict_id=$row["id"];
			$title=stripslashes($row["title"]);
			$text=stripslashes($row["text"]);
			$link=$row["link"];
		}

		$pict="./data/press/".$pict_id.".jpg";
	}
?>

					<hr />

					<?php if ($_SESSION["usr_level"]==5) {  ?>


						<h1>Press Review</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > <a href="./rsv_press.php">Press Review</a> > Delete Press Review</p>
						<br>

						<div class="el_msg">
							<p class="p01">Do you want to delete this Press Review?</p>

							<p class="titpar">Title</p>
							<p class="p03"><?=$title?></p>

							<p class="titpar">Text</p>
							<p class="p03"><?=$text?></p>

							<p class="titpar">Link</p>
							<p class="p03"><?=$link?></p>

							<div style="margin: 35px 0 0 0;">
								<a href="./rsv_press_delete.php?id_act=<?=$act_id?>&act=delete"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
								&nbsp;&nbsp;&nbsp;
								<a href="./rsv_press.php"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
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
