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
	$qst12=Pulisci_INS($_POST["qst12"]);
	$qst13=Pulisci_INS($_POST["qst13"]);
	$qst14=Pulisci_INS($_POST["qst14"]);
	$qst15=Pulisci_INS($_POST["qst15"]);
	$qst16=Pulisci_INS($_POST["qst16"]);
	$qst17=Pulisci_INS($_POST["qst17"]);
	$qst18=Pulisci_INS($_POST["qst18"]);
	$qst19=Pulisci_INS($_POST["qst19"]);

	if ($qst00 && $qst01 && $qst02) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM partner WHERE id_partner=".$qst01;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$partner_name=Pulisci_INS($row["name"]);
		}

		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////

			$sql = "INSERT INTO `members_school` (`id_user` , `id_partner` , `partner` ,`sch_name` , `sch_address` , `sch_tel` , `sch_fax` , `sch_web` , `sch_email` , `sch_type` , `sch_type_other` , `sch_n_student` , `sch_student_age` , `sch_dir_name` , `sch_dir_addr` , `sch_dir_tel` , `sch_dir_fax` , `sch_dir_web` , `sch_dir_email` , `sch_st_involved` , `sch_st_age` , `sch_st_fever`)  VALUES ('$qst00', '$qst01', '$partner_name','$qst02', '$qst03', '$qst04', '$qst05', '$qst06', '$qst07', '$qst08', '$qst08_01', '$qst09', '$qst10', '$qst11', '$qst12', '$qst13', '$qst14', '$qst15', '$qst16', '$qst17', '$qst18', '$qst19')";
			$result=mysqli_query($conn, $sql);
			$id_sch=mysqli_insert_id();

			$check= new CheckUpload($_FILES["fupl"]);
			if ($check->isOk() AND $id_sch) {
				// Upload dell'allegato
				$path=ereg_replace("rsv_school_new.php","",$_SERVER["PATH_TRANSLATED"]);

				$upload_dir = $path."./data/schools";
				$file_ext = strtolower(substr($_FILES["fupl"]['name'],-3));
				$file_name = $id_sch.".".$file_ext;

				move_uploaded_file($_FILES["fupl"]["tmp_name"],$upload_dir."/".$file_name);
				chmod($upload_dir."/".$file_name, 0777);
			}




		//Redirect su messaggio
		$strpas11="./rsv_schools_new1.php?id_sch=".$id_sch;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

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
					<h1>Insert new School</h1>
					<p id="crumbs" style="font-size: small"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_schools.php">Schools</a> > Insert New School</p>
					<br>

					<p class="titpar">SCHOOL PRESENTATION FORM 1/2</p>
					<div class="txt">
						Fill in information about the school then press "Send" button.<br />If you want to see all the school yet uploaded <a href="./rsv_schools.php">click here</a>
					</div>



					<form method="post" action="./rsv_schools_new.php?com=reg" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
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

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">SCHOOL INFORMATION</p>

						<p class="titpar"><?=strtoupper("Name of the School *")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst02" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst03" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Telephone")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst04" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Fax")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst05" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst06" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("e-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst07" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Picture of the School (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl" id="fuplo">
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">DESCRIPTION OF THE SCHOOL</p>

						<p class="titpar"><?=strtoupper("Type of school")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl021">
							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Upper Secondary School" />&nbsp;Upper Secondary School</p>
							<p style="float: left;width: 200px;margin-left: 20px;"><input type="radio" name="qst08" value="Vocational School" />&nbsp;Vocational School</p>
							<p style="float: left;width: 200px;margin-left: 25px;"><input type="radio" name="qst08" value="Technical School" />&nbsp;Technical School</p>
							<div class="clear"></div>
						</div>

						<p class="titpar"><?=strtoupper("Number of students")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst09" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Age of students (from ... to)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst10" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">SCHOOL DIRECTOR</p>

						<p class="titpar"><?=strtoupper("Name of the School Director")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst11" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst12" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Telephone")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst13" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Fax")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst14" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst15" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("e-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst16" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">STUDENTS INVOLVED</p>

						<p class="titpar"><?=strtoupper("Total number of students involved")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst17" rows="" cols="" style="width: 350px"></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Students with fewer opportunities*")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst19" rows="" cols="" style="width: 350px"></textarea>
							<p><em>* The students belonging to this category are those who are statistically more at risk of early school leaving as students with low results in education, immigrant students, students with a difficult family background, poor students, students with disabilities, marginalized students. In our project we mostly refer to students with educational difficulties.</em></p>
						</div>

						<p class="titpar"><?=strtoupper("Age Range")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst18" rows="" cols="" style="width: 350px"></textarea>
							<!-- <p><em>* Please try to involve students between 13 and 16 years old.</em></p> -->
						</div>

						<!-- <p class="titpar" style="padding-top: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">PARENTS INVOLVED</p>

						<p class="titpar"><?=strtoupper("Number of parents involved")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<textarea name="qst19" rows="" cols=""></textarea>
						</div> -->



						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>








				</div> <!-- rsv_crp -->



		</div> <!-- cnt1 -->

	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
