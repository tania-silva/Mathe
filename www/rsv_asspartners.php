<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

$partner=isset($_GET["partner"]) ? $_GET["partner"] : '';
$wtype=isset($_GET["wtype"]) ? $_GET["wtype"] : '';
?>
					<hr />
					<h1>Associated Partners</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > Associated Partners</p>
					<br>

					<div style="margin: 5px 0 10px 0;">
						Select Partners' Institution
						<select name="partner" style="width: 300px;margin: 0 0 0 15px;" onchange="javascript:document.location.href='./rsv_asspartners.php?partner='+this.options[this.selectedIndex].value;">
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
								<th style="width:25%;">Name of the Partner</th>
								<th style="width:35%;">Address</th>
								<th style="width:auto;">Partner Institution</th>
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
								$where="WHERE id_partner='".$partner."'";
							} else {
								$where="";
							}

							$sql = "SELECT * FROM members_apartners ".$where." ORDER BY sch_name";
							$result=mysqli_query($conn, $sql);

							$count_tot=mysqli_num_rows($result);

							while ($row=mysqli_fetch_array($result)) {
								$lnk="./school_report.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];
								$lnk1="./rsv_asspartners_mod.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];
								$lnk3="./rsv_asspartners_del.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];
								$lnk4="./school_stampa.php?id_asch=".$row["id_asch"];

								$par_permit="off";
								if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
								$adm_permit="off";
								if ($usr_level==5) $adm_permit="on";

								$school_name=Pulisci_READ($row["sch_name"]);
								$school_address=substr(Pulisci_READ($row["sch_address"]),0,50);
								if (strlen(Pulisci_READ($row["sch_address"]))>50) $held_in_scr=$held_in_scr."...";
								$partner_name=Pulisci_READ($row["partner"]);

								?>
								<tr>
									<td><?=$school_name?></td>
									<td><?=$school_address?></td>
									<td><?=$partner_name?></td>
									<td style="text-align: right;"><?php if ($adm_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete this Partner" /></a> <?php }?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit this Partner" /></a><?php }?></td>
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
