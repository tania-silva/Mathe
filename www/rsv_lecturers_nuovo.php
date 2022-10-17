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
require_once($root."lib".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
require_once($root."lib".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

if ($_GET["com"]=="reg") {
	
	$qst00=($_POST["qst00"]);
	$qst01=($_POST["qst01"]);
	$qst011=($_POST["qst011"]);
	$qst02=($_POST["qst02"]);
	$qst03=($_POST["qst03"]);
	$qst04=($_POST["qst04"]);
	$qst05=($_POST["qst05"]);
	$qst06=($_POST["qst06"]);
	$qst07=($_POST["qst07"]);
	$qst08=($_POST["qst08"]);
	$qst09=($_POST["qst09"]);
	$qst10=($_POST["qst10"]);
	$qst11=($_POST["qst11"]);
	$qst12=($_POST["qst12"]);
	$qst13=($_POST["qst13"]);
	$qst14=($_POST["qst14"]);
	$qst15=($_POST["qst15"]);
	$qst16=($_POST["qst16"]);
	$qst17=($_POST["qst17"]);
	$qst20=($_POST["qst20"]);

	if (
		$qst00 AND 
		$qst01 AND 
		$qst02
	) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM partner WHERE id_partner=".$qst01;
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$partner_name=($row["name"]);
		}

		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////

		$sql = "
			INSERT INTO `PRT_lecturer` 
			(`id_user`, `id_partner`, `partner`, `qst02`, `qst03`, `qst04`, `qst05`, `qst06`, `qst07`, `qst08`, `qst09`, `qst10`, `qst11`, `qst12`, `qst13`, `qst14`, `qst15`, `qst16`, `qst17`, `qst20`) 
			VALUES ('$qst00', '$qst01', '$partner_name','$qst02', '$qst03', '$qst04', '$qst05', '$qst06', '$qst07', '$qst08', '$qst09', '$qst10', '$qst11', '$qst12', '$qst13', '$qst14', '$qst15', '$qst16', '$qst17', '$qst20')";
		$result=mysqli_query($conn,$sql);
		$id_asch=mysqli_insert_id($conn);

		$check= new CheckUpload($_FILES["fupl"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			//$path=ereg_replace("rsv_lecturers_nuovo.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = "./data/partnership/lecturers"; 
			$file_ext = strtolower(substr($_FILES["fupl"]['name'],-3)); 
			$file_name = $id_asch.".".$file_ext;

			move_uploaded_file($_FILES["fupl"]["tmp_name"],$upload_dir."/".$file_name); 
			chmod($upload_dir."/".$file_name, 0777);
		}

		$check= new CheckUpload($_FILES["fupl1"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			//$path=ereg_replace("rsv_lecturers_nuovo.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = "./data/partnership/lecturers"; 
			$file_ext = strtolower(substr($_FILES["fupl1"]['name'],-3)); 
			$file_name = $id_asch."_uni.".$file_ext;

			move_uploaded_file($_FILES["fupl1"]["tmp_name"],$upload_dir."/".$file_name); 
			chmod($upload_dir."/".$file_name, 0777);
		}



		//Redirect su messaggio
		$strpas11="./rsv_lecturers.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	} else {

		//Redirect su messaggio
		$strpas11="./rsv_lecturers_nuovo.php?ok=ko";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	}

}
?>
					<hr />
					<h1>Insert new Lecturer</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_lecturers.php">Lecturer</a> > Insert New Lecturer</p>

					<p class="titpar">LECTURER PRESENTATION FORM</p>
					<div class="txt">
						Fill in information about the Lecturer then press "Send" button.<br />If you want to see all the Lecturers yet uploaded <a href="./rsv_lecturers.php">click here</a>
					</div>



					<form method="post" action="./rsv_lecturers_nuovo.php?com=reg" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />
						<!-- <input type="hidden" name="qst011" value="<?=$ptn_name?>" /> -->
						<?php

							if ($_SESSION["usr_level"]==5) {
								// Il SUPERADMIN deve poter inserire documenti in vece di altri partner
								// quindi appare la combo di scelta del partner
								?>
								<div style="margin: 15px 0 20px 0;">
									<div style="font: Arial 10pt;">Select Partners' Institution</div>
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

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">LECTURER INFORMATION</p>

						<p class="titpar"><?=strtoupper("Name and Surname")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst02" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("E-mail ")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst03" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If you have to insert more web address just insert one for line. Don't use comma or semicolon or any other character after the web address.<br />Please insert the complete Internet address (e.g. http://www.google.it/)</span></p>
						<div class="lbl024"><textarea name="qst04" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Field of research")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst05" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Subject taught")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst06" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Years of experience")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst07" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Profile")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please briefly describe the academic experience</span></p>
						<div class="lbl022" style="margin-left: 25px;"><textarea name="qst08" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Picture of the lecturer (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please enclose a jpg picture of the lecturer</span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl" id="fuplo">
						</div>

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">UNIVERSITY</p>

						<p class="titpar"><?=strtoupper("Name of the university")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst09" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Faculty / Department")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst10" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Number of Students")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst11" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Country")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst12" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("City")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst13" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst14" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Tel")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst15" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("E-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst16" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Web site ")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst17" rows="" cols=""></textarea></div>

						<p class="titpar"><?=strtoupper("Picture of the university (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please enclose a jpg picture of the university</span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl1" id="fuplo">
						</div>


						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>