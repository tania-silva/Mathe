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

					<h1>Dissemination</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > Dissemination</p>


					<div style="margin: 5px 0 10px 0;">
						Select Partners' Institution
						<select name="partner" onchange="javascript:document.location.href='./rsv_pm_diss.php?wps=<?=$wps?>&partner='+this.options[this.selectedIndex].value;">
							<option value="">All Partners</option>
							<?php
							sanitize($_GET, $var_get);
							////////////////////////////////////////////////////
							$wps=$_GET["wps"];
							$partner=$_GET["partner"];

							$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
							$result=mysqli_query($conn, $sql);


							while ($row=mysqli_fetch_array($result)) {
								?>
								<option value="<?=$row["id_partner"]?>" <?php if (trim($partner)==trim($row["id_partner"])) echo "selected"?>><?=Pulisci_READ($row["name"])?> (<?=$row["country_sinc"]?>)</option>
								<?php
							}
							?>
						</select>
					</div>
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
						$partner=sanitizeOne($partner,'sql');
						$where="WHERE p.id_partner='".$partner."'";
					} else {
						$where="";
					}

					$sql = "
						SELECT *
						FROM pm__dissemination AS p
						LEFT JOIN countries AS q
						ON p.held_in_country=q.id
						$where
						ORDER BY p.date_event_from DESC";
					$result=mysqli_query($conn, $sql);

					if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;
					?>


					<div style="margin: 25px 0 5px 5px;">
						<p style="float: left;width: 300px;">Found <?=$count_tot?> documents</p>
						<p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="rsv_pm_diss_new.php" class="bt_css1">Insert new Document</a></p>
						<div class="clear"></div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="width:18%;">Date</th>
								<th style="width:25%;">Type of Event</th>
								<th style="width:auto;">Place</th>
								<th style="width:28%;">Partners Institution</th>
								<th style="width:15%;"></th>
								<th style="width:20%;"></th>
							</tr>
						</thead>
						<tbody>
						<?php
						while ($row=mysqli_fetch_array($result)) {
							$lnk="./rsv_pm_diss_report.php?id_act=".$row["id_dis"]."&wps=".$wps."&partner=".$partner;
							$lnk1="./rsv_pm_diss_edit.php?id_act=".$row["id_dis"]."&wps=".$wps."&partner=".$partner;
							$lnk2="./rsv_pm_diss_upload.php?id_act=".$row["id_dis"]."&wps=".$wps."&partner=".$partner;
							$lnk3="./rsv_pm_diss_delete.php?id_act=".$row["id_dis"]."&wps=".$wps."&partner=".$partner;

							$par_permit="off";
							if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
							$adm_permit="off";
							if ($usr_level==5) $adm_permit="on";

							$type_event_scr=substr(Pulisci_READ($row["type_event"]),0,25);
							if (strlen(Pulisci_READ($row["type_event"]))>25) $type_event_scr=$type_event_scr."...";
							if ($row["type_event"]=="Other") $type_event_scr=substr(Pulisci_READ($row["type_event_other"]),0,25);;

							// $held_in_scr=substr(Pulisci_READ($row["held_in"]),0,50);
							// if (strlen(Pulisci_READ($row["held_in"]))>50) $held_in_scr=$held_in_scr."...";

							$held_in_town=Pulisci_READ($row["held_in_town"])." (".strtoupper(Pulisci_READ($row["alpha_2"])).")";

							$period_from=$row["date_event_from"];
							$period_from_gg=substr($period_from, -2);
							$period_from_mm=substr($period_from, 4, 2);
							$period_from_aa=substr($period_from, 0,4);
							$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

							$period_to=$row["date_event_to"];
							$period_to_gg=substr($period_to, -2);
							$period_to_mm=substr($period_to, 4, 2);
							$period_to_aa=substr($period_to, 0,4);
							$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
							$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

							$period="";
							if ($row["date_event_from"]!="0") $period.="".$period_from;

							?>
							<tr>
								<td><a href="<?=$lnk?>"><?=$period?></a></td>
								<td><a href="<?=$lnk?>"><?=$type_event_scr?></a></td>
								<td><a href="<?=$lnk?>"><?=$held_in_town?></a></td>
								<td><a href="<?=$lnk?>"><?=Pulisci_READ($row["partner"])?></a></td>
								<td style="text-align: center;"><?php  if ($adm_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete this report" /></a> <?php  }?><?php  if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit this report" /></a><?php  }?></td>
								<td style="text-align: center;"><?php  if ($par_permit=="on") {  ?><a href="<?=$lnk2?>"><img src="./impianto/img/attachment.gif" height="15" alt="Related documents" title="Related documents" /></a><?php  }?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
