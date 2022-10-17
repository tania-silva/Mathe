<?php
include('./impianto/inc/function.php'); // funzioni PHP

//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
require_once($root."librerie".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
require_once($root."librerie".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."librerie".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."librerie".$DS."upload".$DS."classes".$DS."class.check.php");

//////////////////////////////////   sanitize var get e post /////////////////////
$id_sch=$_GET["id_sch"];
$id_partner=$_GET["id_partner"];

if (isset($_GET["com"]) && $_GET["com"]=="reg") {

	$qst00=Pulisci_INS($_POST["qst00"]);
	$qst01=Pulisci_INS($_POST["qst01"]);
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
	$qst12=Pulisci_INS($_POST["qst12"]);
	$qst13=Pulisci_INS($_POST["qst13"]);
	$qst14=Pulisci_INS($_POST["qst14"]);
	$qst15=Pulisci_INS($_POST["qst15"]);
	$qst16=Pulisci_INS($_POST["qst16"]);
	$qst17=Pulisci_INS($_POST["qst17"]);
	$qst18=Pulisci_INS($_POST["qst18"]);
	$qst19=Pulisci_INS($_POST["qst19"]);

	if ($qst00 AND $qst01 AND $id_sch) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM partner WHERE id_partner=".$qst01;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$partner_name=Pulisci_INS($row["name"]);
		}


		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////

		$sql = "UPDATE `members_school` SET
		id_partner='$qst01',
		partner='$partner_name',
		sch_name='$qst02',
		sch_address='$qst03',
		sch_tel='$qst04',
		sch_fax='$qst05',
		sch_web='$qst06',
		sch_email='$qst07',
		sch_type='$qst08',
		sch_type_other='$qst08_01',
		sch_n_student='$qst09',
		sch_student_age='$qst10',
		sch_dir_name='$qst11',
		sch_dir_addr='$qst12',
		sch_dir_tel='$qst13',
		sch_dir_fax='$qst14',
		sch_dir_web='$qst15',
		sch_dir_email='$qst16',
		sch_st_involved='$qst17',
		sch_st_age='$qst18',
		sch_st_fever='$qst19'
		WHERE id_sch='$id_sch'";
		$result=mysqli_query($conn, $sql);


		$check= new CheckUpload($_FILES["fupl"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			$path=ereg_replace("rsv_school_mod.php","",$_SERVER["PATH_TRANSLATED"]);

			$upload_dir = $path."./data/schools";
			$file_ext = strtolower(substr($_FILES["fupl"]['name'],-3));
			$file_name = $id_sch.".".$file_ext;

			move_uploaded_file($_FILES["fupl"]["tmp_name"],$upload_dir."/".$file_name);
			chmod($upload_dir."/".$file_name, 0777);
		}


		//Redirect su messaggio
		$strpas11="./rsv_schools.php?id_sch=".$id_sch;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	}

} else {

	$sql = "SELECT * FROM members_school WHERE id_sch=".$id_sch;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
//		$qst02=Pulisci_READ($row["id_user"]);
		$id_partner=Pulisci_READ($row["id_partner"]);
		$ptn_name=Pulisci_READ($row["partner"]);
		$qst02=Pulisci_READ($row["sch_name"]);
		$qst03=Pulisci_READ($row["sch_address"]);
		$qst04=Pulisci_READ($row["sch_tel"]);
		$qst05=Pulisci_READ($row["sch_fax"]);
		$qst06=Pulisci_READ($row["sch_web"]);
		$qst07=Pulisci_READ($row["sch_email"]);
		$qst08=Pulisci_READ($row["sch_type"]);
		$qst08_01=Pulisci_READ($row["sch_type_other"]);
		$qst09=Pulisci_READ($row["sch_n_student"]);
		$qst10=Pulisci_READ($row["sch_student_age"]);
		$qst11=Pulisci_READ($row["sch_dir_name"]);
		$qst12=Pulisci_READ($row["sch_dir_addr"]);
		$qst13=Pulisci_READ($row["sch_dir_tel"]);
		$qst14=Pulisci_READ($row["sch_dir_fax"]);
		$qst15=Pulisci_READ($row["sch_dir_web"]);
		$qst16=Pulisci_READ($row["sch_dir_email"]);
		$qst17=Pulisci_READ($row["sch_st_involved"]);
		$qst18=Pulisci_READ($row["sch_st_age"]);
		$qst19=Pulisci_READ($row["sch_st_fever"]);
	}


}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiction</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
	
    <script type="text/javascript" src="./impianto/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="./impianto/addons/ckfinder/ckfinder.js"></script>
</head>

<body>

	<?php include("header.php"); ?>
	<div class="container">
		<div class="row">

				<div id="rsv_menu" class="col-md-3"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp" class="col-md-9">
		<hr>
					<h1>Manage Schools</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_schools.php">Schools</a> > Modify School</p>


					<p class="titpar">SCHOOL PRESENTATION FORM</p>
					<div class="txt">
						Fill in information about the school then press "Send" button.<br />
						If you want to <strong>see all the school</strong> yet uploaded <a href="./rsv_schools.php">click here</a><br />
						If you want to <strong>manage the teachers</strong> of this school <a href="./rsv_schools_teachers.php?id_sch=<?=$id_sch?>">click here</a><br />
						<!-- If you want to <strong>manage the counsellor</strong> of this school <a href="./rsv_schools_counsellor.php?id_sch=<?=$id_sch?>">click here</a> -->
					</div>



					<form method="post" action="./rsv_schools_mod.php?com=reg&id_sch=<?=$id_sch?>" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />
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
											<option value="<?=$row["id_partner"]?>" <?php if ($id_partner==$row["id_partner"]) echo "selected"?>><?=$row["name_corto"]?></option>
											<?php
										}
										?>
									</select>
								</div>

								<?php
							} else {
								// Se partner normale i campi sono preimpostati
								?>
								<input type="hidden" name="qst01" value="<?=$id_partner?>" />
								<?php
							}
						?>

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">SCHOOL INFORMATION</p>

						<p class="titpar"><?=strtoupper("Name of the School")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst02" rows="" cols="" style="width: 500px"><?=$qst02?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst03" rows="" cols="" style="width: 500px"><?=$qst03?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Telephone")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst04" rows="" cols="" style="width: 500px"><?=$qst04?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Fax")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst05" rows="" cols="" style="width: 500px"><?=$qst05?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst06" rows="" cols="" style="width: 500px"><?=$qst06?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("e-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst07" rows="" cols="" style="width: 500px"><?=$qst07?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Picture of the School (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl" id="fuplo">
							<?php if(file_exists("./data/schools/{$id_sch}.jpg")) { ?><p style="float: right;width: 200px;margin: 0 0 0 0;"><img src="./data/schools/<?=$id_sch?>.jpg?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="" /></p><?php }?>
							<div class="clear"></div>
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">DESCRIPTION OF THE SCHOOL</p>

						<p class="titpar"><?=strtoupper("Type of school")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl021">
							<!-- <p style="float: left;width: 200px;margin-left: 25px;"><input type="radio" name="qst08" value="Lyceum" <?php if ($qst08=="Lyceum") echo "checked=\"checked\"";?> />&nbsp;Lyceum</p>
							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Technical" <?php if ($qst08=="Technical") echo "checked=\"checked\"";?> />&nbsp;Technical</p>
							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Vocational" <?php if ($qst08=="Vocational") echo "checked=\"checked\"";?> />&nbsp;Vocational</p>  -->


							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Upper Secondary School" <?php if ($qst08=="Upper Secondary School") echo "checked=\"checked\"";?> />&nbsp;Upper Secondary School</p>
							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Vocational School" <?php if ($qst08=="Vocational School") echo "checked=\"checked\"";?> />&nbsp;Vocational School</p>
							<p style="float: left;width: 200px;margin-left: 25px;"><input type="radio" name="qst08" value="Technical School" <?php if ($qst08=="Technical School") echo "checked=\"checked\"";?> />&nbsp;Technical School</p>

							<div class="clear"></div>
						</div>
						<!-- <div class="lbl021">
							<input type="radio" name="qst08" value="Vocational" <?php if ($qst08=="Vocational") echo "checked=\"checked\"";?> />&nbsp;Vocational
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="qst08" value="Other" <?php if ($qst08=="Other") echo "checked=\"checked\"";?> />&nbsp;Other <input type="text" name="qst08_01" value="<?=$qst08_01?>" style="padding: 2px 5px;width: 290px;border: solid 1px #000;" />
						</div> -->

						<p class="titpar"><?=strtoupper("Number of students")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst09" rows="" cols="" style="width: 500px"><?=$qst09?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Age of students (from ... to)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst10" rows="" cols="" style="width: 500px"><?=$qst10?></textarea>
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">SCHOOL DIRECTOR</p>

						<p class="titpar"><?=strtoupper("Name of the School Director")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst11" rows="" cols="" style="width: 500px"><?=$qst11?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst12" rows="" cols="" style="width: 500px"><?=$qst12?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Telephone")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst13" rows="" cols="" style="width: 500px"><?=$qst13?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Fax")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst14" rows="" cols="" style="width: 500px"><?=$qst14?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst15" rows="" cols="" style="width: 500px"><?=$qst15?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("e-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst16" rows="" cols="" style="width: 500px"><?=$qst16?></textarea>
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">STUDENTS INVOLVED</p>

						<p class="titpar"><?=strtoupper("Total number of students involved")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst17" rows="" cols="" style="width: 500px"><?=$qst17?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Students with fewer opportunities")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst19" rows="" cols="" style="width: 500px"><?=$qst19?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Age Range")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst18" rows="" cols="" style="width: 500px"><?=$qst18?></textarea>
						</div>



						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>



				</div> <!-- rsv_crp -->

		</div> <!-- cnt1 -->

	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
