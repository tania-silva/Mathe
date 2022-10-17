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
			'wps'=>'str',
			'partner'=>'str'
	);
	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

	$wps=isset($_GET["wps"]) ? $_GET["wps"] : '';
	$partner=isset($_GET["partner"]) ? $_GET["partner"] : '';

?>

					<hr />

					<?php if ($_SESSION["usr_level"]==5) {  ?>

						<h1>News</h1>
						<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > News</p>
						<br>

						<?php
						$sql = "SELECT * FROM news ORDER BY date DESC";
						$result=mysqli_query($conn, $sql);

 						if ($result) $count_tot = mysqli_num_rows($result); else $count_tot=0;
						?>


						<div style="margin: 25px 0 5px 5px;">
							<p style="float: left;width: 300px;">Found <?=$count_tot?> documents</p>
							<p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./rsv_news_new.php" class="bt_css1">Insert new Document</a></p>
							<div class="clear"></div>
						</div>
						<table class="for1 table" style="margin-top: 0;">
							<thead>
								<tr>
									<td class="tdtit" style="width: 100px;"><img src="./wiztr.gif" style="width: 100px;height: 1px;" /></td>
									<td class="tdtit">News</td>
									<td class="tdtit" style="width: 55px;"><img src="./wiztr.gif" style="width: 55px;height: 1px;" /></td>
								</tr>
							</thead>
							<tbody>
							<?php
							$count=1;
							while ($row=mysqli_fetch_array($result)) {

								$pict_id=$row["id"];
								$title=stripslashes($row["title"]);
								$text=stripslashes($row["text"]);
								$date=$row["date"];

								$lnk1="./rsv_news_edit.php?id_act=".$row["id"];
								$lnk3="./rsv_news_delete.php?id_act=".$row["id"];

								if ($date!="" AND $date!="0000-00-00 00:00:00") {
									$fatt_data_expl=explode("-",$date);
									$fatt_data_aa=$fatt_data_expl[0];
									$fatt_data_mm=$fatt_data_expl[1];
									$fatt_data_expl1=explode(" ",$fatt_data_expl[2]);
									$fatt_data_gg=$fatt_data_expl1[0];
									$fatt_data_expl2=explode(":",$fatt_data_expl1[1]);
									$fatt_data_ora=$fatt_data_expl2[0];
									$fatt_data_min=$fatt_data_expl2[1];
									$date=$fatt_data_gg."/".$fatt_data_mm."/".$fatt_data_aa;
								} else $date="";


								$pict="./data/news/".$pict_id."_ico.jpg";
								if (!file_exists($pict)) $pict="./wiztr.gif";

								?>
								<tr>
									<td><img src="<?=$pict?>?rnd=<?=$rand_n?>" width="100" alt="" style="width: 100px;border: solid 1px #ccc;" /></td>
									<td>
										<strong style="display: block;margin: 0 0 5px 0;font-size: 1.0em;"><?=$date?></strong>
										<strong style="display: block;margin: 0 0 5px 0;font-size: 1.2em;"><?=$title?></strong>
										<em style="display: block;margin: 0 0 5px 0;font-size: 0.9em;font-style: normal;"><?=$text?></em>
									</td>
									<td style="text-align: right;">
										<a href="<?=$lnk1?>">edit</a><br />
										<a href="<?=$lnk3?>">delete</a>
									</td>
								</tr>
								<?php
								$count+=1;
							}
							?>
							</tbody>
						</table>

					<?php } else { ?>
						<?php include('./impianto/inc/sorry.php'); //PIEDE?>
					<?php } ?>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
