<?php include('top.php'); ?>
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
		<div id="rsv_crp" class="col-md-9">
			
			<!-- INCOLLA START -->






<?php

//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."librerie".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."librerie".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

if (isset($_GET["com"]) && $_GET["com"]=="reg") {

	$qst00=Pulisci_INS($_POST["qst00"]);
	$qst01=Pulisci_INS($_POST["qst01"]);
	$qst011=Pulisci_INS($_POST["qst011"]);
	$qst02=Pulisci_INS($_POST["qst02"]);
	$qst03=Pulisci_INS($_POST["qst03"]);
	$qst04=Pulisci_INS($_POST["qst04"]);
	$qst05=Pulisci_INS($_POST["qst05"]);
	$qst06=Pulisci_INS($_POST["qst06"]);
	$qst07=Pulisci_INS($_POST["qst07"]);
	$qst08=Pulisci_INS($_POST["qst08"]);
	$qst08_01=Pulisci_INS($_POST["qst08_01"]);
	$qst09=Pulisci_INS($_POST["qst09"]);
	$qst10=Pulisci_INS($_POST["qst10"]);
	$qst11=Pulisci_INS($_POST["qst11"]);

	if ($qst00 && $qst01 && $qst02) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM partner WHERE id_partner=".$qst01;
		$result=mysqli_query($conn, $sql);

		while ($row=mysqli_fetch_array($result)) {
			$partner_name=($row["name"]);
		}

		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////

		$sql = "INSERT INTO `members_apartners`	(`id_user` , `id_partner` , `partner` ,`sch_name` , `sch_type` , `sch_city` , `sch_address` , `sch_country` , `sch_web` , `sch_contact` , `sch_contact_email` , `sch_description` , `sch_contribute`)
		VALUES ('$qst00', '$qst01', '$partner_name','$qst02', '$qst03', '$qst04', '$qst05', '$qst06', '$qst07', '$qst08', '$qst09', '$qst10', '$qst11')";
		$result=mysqli_query($conn, $sql);
		$id_asch=mysqli_insert_id($conn);


		//Redirect su messaggio
		$strpas11="./rsv_asspartners.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	}

}
?>
					<hr />
					<h1>Associated Partners</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_asspartners.php">Associated Partners</a> > Insert New Partner</p>
					<br />
				<p class="titpar">PARTNER PRESENTATION FORM</p>
				<div class="txt">
					Fill in information about the Partner then press "Send" button.<br />If you want to see all the Partners yet uploaded <a href="./rsv_asspartners.php">click here</a>
				</div>



				<form method="post" action="./rsv_asspartners_nuovo.php?com=reg" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
					<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />
					<!-- <input type="hidden" name="qst011" value="<?=$ptn_name?>" /> -->
					<?php

					if ($_SESSION["usr_level"]==5) {
						// Il SUPERADMIN deve poter inserire documenti in vece di altri partner
						// quindi appare la combo di scelta del partner
						?>
						<div style="margin: 15px 0 20px 0;">
							<div style="font: bold 10pt arial;">Select Partners' Institution</div>
							<select name="qst01" style="width: 405px;">
								<option value="">All Partners</option>
								<?php
								$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
								$result=mysqli_query($conn, $sql);

								while ($row=mysqli_fetch_array($result)) {
									?>
									<option value="<?=$row["id_partner"]?>" <?php if ($id_partner_func==$row["id_partner"]) echo "selected"?>><?=$row["name"]?></option>
									<?php
								}
								?>
							</select>
						</div>

						<?php
					} else {
						// Se partner normale i campi sono preimpostati
						?>
						<input type="hidden" name="qst01" value="<?=$id_partner_func?>" />
						<?php
					}
					?>

					<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">ASSOCIATED PARTNER INFORMATION</p>

					<p class="titpar"><?=strtoupper("Name of the organisation")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl023">
						<textarea name="qst02" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Type of Institution")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl024">
						<textarea name="qst03" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("City")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl024">
						<textarea name="qst04" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl024">
						<textarea name="qst05" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Country")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl024">
						<textarea name="qst06" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If you have to insert more web address just insert one for line. Don't use comma or semicolon or any other character after the web address.<br />Please insert the complete Internet address (e.g. http://www.google.it/)</span></p>
					<div class="lbl024">
						<textarea name="qst07" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Name of contact person")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
					<div class="lbl024">
						<textarea name="qst08" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Email of Contact Person")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If you have to insert more emails just insert one for line. Don't use comma or semicolon or any other character after the email address.</span></p>
					<div class="lbl024">
						<textarea name="qst09" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Please provide a brief description of the organisation")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If the text contains an Internet address, please insert the complete Internet address (e.g. http://www.google.it/)</span></p>
					<div class="lbl022" style="margin-left: 25px;">
						<textarea name="qst10" rows="" cols=""></textarea>
					</div>

					<p class="titpar"><?=strtoupper("Please describe how the organisation will contribute to the dissemination and exploitation of the project results")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If the text contains an Internet address, please insert the complete Internet address (e.g. http://www.google.it/)</span></p>
					<div class="lbl022" style="margin-left: 25px;">
						<textarea name="qst11" rows="" cols=""></textarea>
					</div>


					<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

				</form>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>
