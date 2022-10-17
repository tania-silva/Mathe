<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

$partner=$_GET["partner"];
$wtype=$_GET["wtype"];
?>
					<hr />
					<h1>Manage Lecturers</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > Lecturers</p>

					<div style="margin: 5px 0 10px 0;">
						Select Partners' Institution
						<select name="partner" style="width: 300px;margin: 0 0 0 15px;" onchange="javascript:document.location.href='./rsv_lecturers.php?partner='+this.options[this.selectedIndex].value;">
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

						<table class="for1 table" style="margin-top: 0;">
						<thead>
							<tr>
								<th>Name and Surname</th>
								<th>Name of the university</th>
								<th>Partner Institution</th>
								<th></th>
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

							$sql = "
								SELECT *
								FROM PRT_lecturer
								".$where."
								ORDER BY qst02";
							$result=mysqli_query($conn, $sql);

							$count_tot=0;
							if ($result) $count_tot=mysqli_num_rows($result);

							while ($row=mysqli_fetch_array($result)) {
								$lnk1="./rsv_lecturers_mod.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];
								$lnk3="./rsv_lecturers_del.php?id_asch=".$row["id_asch"]."&amp;id_partner=".$row["id_partner"];

								$par_permit="off";
								if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
								$adm_permit="off";
								if ($usr_level==5) $adm_permit="on";

								$school_name=Pulisci_READ($row["qst02"]);
								$school_address=Pulisci_READ($row["qst09"]);
								$partner_name=Pulisci_READ($row["partner"]);

								?>
								<tr>
									<td><?=$school_name?></td>
									<td><?=$school_address?></td>
									<td><?=$partner_name?></td>
									<td style="text-align: right;"><?php if ($adm_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete" /></a> <?php }?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit" /></a><?php }?></td>
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