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

<?php include('top.php'); ?>

<!-- INCOLLA START -->







	<div class="container">
		<div id="cnt1" class="row">

			<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
			<div id="rsv_crp" class="col-md-9">

				<hr />
				<h1>Work in Progress</h1>
				<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Project Management > Work in Progress</p>
				<br>

				<div>
					<span style="padding-right: 7px;">Select Activity concerned</span>
					<select name="wps" style="margin: 0 0 0 0;" onchange='javascript:document.location.href="./rsv_pm_wip.php?wps="+this.options[this.selectedIndex].value+"&partner=<?=$partner?>";'>
						<option value="">All Activities</option>
							<option value="IO1" <?php if ($wps=="IO1") echo "selected"?>>IO1 - Student Assessment Toolkit</option>
							<option value="IO2" <?php if ($wps=="IO2") echo "selected"?>>IO2 - Math Library</option>
							<option value="IO3" <?php if  ($wps=="IO3") echo "selected"?>>IO3 - Community of Practice </option>
						<option value="ME" <?php if ($wps=="ME") echo "selected"?>>ME - Multiplier Events</option>
						<option value="PM" <?php if ($wps=="PM") echo "selected"?>>PM - Project Management</option>
					</select>
				</div>

				<div style="margin: 5px 0 10px 0;">
					Select Partners' Institution
					<select name="partner" onchange='javascript:document.location.href="./rsv_pm_wip.php?wps=<?=$wps?>&partner="+this.options[this.selectedIndex].value;'>
						<option value="">All Partners</option>
						<?php

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

				if ($wps!="" || $partner!="") {
					//echo("<script> alert('".sanitizeOne($wps,'sql')."')</script>");
					$wps=sanitizeOne($wps,'sql');
					$partner=sanitizeOne($partner,'sql');

					if ($wps!="" && $partner!="") {
						$where="WHERE (wps='".$wps."' AND id_partner='".$partner."')";
					} elseif ($wps!="") {
						$where="WHERE wps='".$wps."'";
					} elseif ($partner!="") {
						$where="WHERE id_partner='".$partner."'";
					}
				} else {
					$where="";
				}

				$sql = "SELECT * FROM pm__workinprogress ".$where." ORDER BY wps,period_from,period_to,id_act";
				$result=mysqli_query($conn, $sql);
				if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;
				?>


				<div style="margin: 25px 0 5px 5px;">
					<p style="float: left;width: 300px;">Found <?=$count_tot?> documents</p>
					<p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="rsv_pm_wip_new.php" class="bt_css1">Insert new Document</a></p>
					<div class="clear"></div>
				</div>
				
				<table class="table table-bordered">
					<thead>
						<tr>
							<!-- <th style="width:10%;color:#fff">#</th> -->
							<th>Activity</th>
							<th style="width:40%">Project period</th>
							<th style="width:40%;">Partners Institution</th>
							<th style="width:20%;color:#fff">#</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($row=mysqli_fetch_array($result)) {
							$lnk="./rsv_pm_wip_report.php?id_act=".$row["id_act"]."&wps=".$wps."&partner=".$partner;
							$lnk1="./rsv_pm_wip_edit.php?id_act=".$row["id_act"]."&wps=".$wps."&partner=".$partner;
							$lnk2="./rsv_pm_wip_delete.php?id_act=".$row["id_act"]."&wps=".$wps."&partner=".$partner;
							$lnk3="./rsv_pm_wip_stampa.php?id_act=".$row["id_act"];

							$par_permit="off";
							if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
							$adm_permit="off";
							if ($usr_level==5) $adm_permit="on";

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

							?>
							<tr>
								<!-- <td><a href="<?=$lnk3?>" onclick="javascript=this.target='blank';"><img src="./impianto/img/print.png" alt="" border="0" /></a></td> -->
								<td class="td01"><a href="<?=$lnk?>"><?=Pulisci_READ($row["wps"])?></a></td>
								<td><a href="<?=$lnk?>"><?=$period?></a></td>
								<td><a href="<?=$lnk?>"><?=Pulisci_READ($row["partner"])?></a></td>
								<td style="text-align: right;"><?php if ($adm_permit=="on") {  ?><a href="<?=$lnk2?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete this report" /></a> <?php } ?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit this report" /></a><?php }?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>



				<div class="clear"></div>
			</div> <!-- rsv_crp -->

		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->






<!-- INCOLLA END -->
<?php include('bottom.php'); ?>
