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


$id_asch=$_GET["id_asch"];
$id_partner=$_GET["id_partner"];

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

	if ($qst00 AND $qst01 && $qst02 AND $id_asch) $chk_status=1;

	if ($chk_status==1) {

		$sql = "SELECT * FROM partner WHERE id_partner=".$qst01;
		$result=mysqli_query($conn, $sql);


		while ($row=mysqli_fetch_array($result)) {
			$partner_name=($row["name"]);
		}


		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////

		$sql = "UPDATE `PRT_student` SET
		id_partner='$qst01',
		partner='$partner_name',
		qst02='$qst02',
		qst03='$qst03',
		qst04='$qst04',
		qst05='$qst05',
		qst06='$qst06',
		qst07='$qst07',
		qst08='$qst08',
		qst09='$qst09',
		qst10='$qst10',
		qst11='$qst11',
		qst12='$qst12',
		qst13='$qst13',
		qst14='$qst14',
		qst15='$qst15',
		qst16='$qst16',
		qst17='$qst17'
		WHERE id_asch='$id_asch'";
		$result=mysqli_query($conn, $sql);


		$check= new CheckUpload($_FILES["fupl"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			$path=ereg_replace("rsv_students_nuovo.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = $path."./data/partnership/students";
			$file_ext = strtolower(substr($_FILES["fupl"]['name'],-3));
			$file_name = $id_asch.".".$file_ext;

			move_uploaded_file($_FILES["fupl"]["tmp_name"],$upload_dir."/".$file_name);
			chmod($upload_dir."/".$file_name, 0777);
		}

		$check= new CheckUpload($_FILES["fupl1"]);
		if ($check->isOk()) {
			// Upload dell'allegato
			$path=ereg_replace("rsv_students_nuovo.php","",$_SERVER["PATH_TRANSLATED"]);
			$upload_dir = $path."./data/partnership/students";
			$file_ext = strtolower(substr($_FILES["fupl1"]['name'],-3));
			$file_name = $id_asch."_uni.".$file_ext;

			move_uploaded_file($_FILES["fupl1"]["tmp_name"],$upload_dir."/".$file_name);
			chmod($upload_dir."/".$file_name, 0777);
		}


		//Redirect su messaggio
		$strpas11="./rsv_students.php?id_asch=".$id_asch;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

	}

	//Redirect su messaggio
	$strpas11="./rsv_students.php?id_asch=".$id_asch;
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";

} else {

	$sql = "SELECT * FROM PRT_student WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);

	while ($row=mysqli_fetch_array($result)) {
//		$qst02=Pulisci_READ($row["id_user"]);
		$id_partner=Pulisci_READ($row["id_partner"]);
		$ptn_name=Pulisci_READ($row["partner"]);
		$qst02=Pulisci_READ($row["qst02"]);
		$qst03=Pulisci_READ($row["qst03"]);
		$qst04=Pulisci_READ($row["qst04"]);
		$qst05=Pulisci_READ($row["qst05"]);
		$qst06=Pulisci_READ($row["qst06"]);
		$qst07=Pulisci_READ($row["qst07"]);
		$qst08=Pulisci_READ($row["qst08"]);
		$qst09=Pulisci_READ($row["qst09"]);
		$qst10=Pulisci_READ($row["qst10"]);
		$qst11=Pulisci_READ($row["qst11"]);
		$qst12=Pulisci_READ($row["qst12"]);
		$qst13=Pulisci_READ($row["qst13"]);
		$qst14=Pulisci_READ($row["qst14"]);
		$qst15=Pulisci_READ($row["qst15"]);
		$qst16=Pulisci_READ($row["qst16"]);
		$qst17=Pulisci_READ($row["qst17"]);
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

<?php include("header2.php"); ?>

	<div class="container">

		<div id="cnt1">
			<div id="corpo"><div id="rsv">
				<div id="rsv_menu"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp">

					<h1>Manage Student</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_students.php">Student</a> > Modify Student</p>


					<p class="titpar">STUDENT PRESENTATION FORM</p>
					<div class="txt">
						Fill in information about the Student then press "Send" button.<br />
						If you want to see all the Student yet uploaded <a href="./rsv_students.php">click here</a><br />
					</div>



					<form method="post" action="./rsv_students_mod.php?com=reg&id_asch=<?=$id_asch?>" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />
						<?

							if ($_SESSION["usr_level"]==5) {
								// Il SUPERADMIN deve poter inserire documenti in vece di altri partner
								// quindi appare la combo di scelta del partner
								?>
								<div style="margin: 15px 0 20px 0;">
									<div style="font: bold 10pt arial;">Select Partners' Institution</div>
									<select name="qst01" style="width: 405px;">
										<option value="">All Partners</option>
										<?
										$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
										$result=mysqli_query($conn, $sql);


										while ($row=mysqli_fetch_array($result)) {
											?>
											<option value="<?=$row["id_partner"]?>" <?php if ($id_partner==$row["id_partner"]) echo "selected"?>><?=$row["name"]?></option>
											<?
										}
										?>
									</select>
								</div>

								<?
							} else {
								// Se partner normale i campi sono preimpostati
								?>
								<input type="hidden" name="qst01" value="<?=$id_partner?>" />
								<?
							}
						?>

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">STUDENT INFORMATION</p>

						<p class="titpar"><?=strtoupper("Name and Surname")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst02" rows="" cols=""><?=$qst02?></textarea></div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">If you have to insert more web address just insert one for line. Don't use comma or semicolon or any other character after the web address.<br />Please insert the complete Internet address (e.g. http://www.google.it/)</span></p>
						<div class="lbl024"><textarea name="qst03" rows="" cols=""><?=$qst03?></textarea></div>

						<p class="titpar"><?=strtoupper("E-mail ")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst04" rows="" cols=""><?=$qst04?></textarea></div>

						<p class="titpar"><?=strtoupper("Profile")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please briefly describe the academic experience</span></p>
						<div class="lbl022" style="margin-left: 25px;"><textarea name="qst05" rows="" cols=""><?=$qst05?></textarea></div>

						<p class="titpar"><?=strtoupper("Picture of the student (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please enclose a jpg picture of the student</span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl" id="fuplo">
							<?php if(file_exists("./data/partnership/students/{$id_asch}.jpg")) { ?><p style="float: right;width: 200px;margin: 0 0 0 0;"><img src="./data/partnership/students/<?=$id_asch?>.jpg?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="" /></p><?php }?>
							<div class="clear"></div>
						</div>

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">UNIVERSITY</p>

						<p class="titpar"><?=strtoupper("Name of the university")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst06" rows="" cols=""><?=$qst06?></textarea></div>

						<p class="titpar"><?=strtoupper("Faculty / Department")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst07" rows="" cols=""><?=$qst07?></textarea></div>

						<p class="titpar"><?=strtoupper("Number of Students")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst08" rows="" cols=""><?=$qst08?></textarea></div>

						<p class="titpar"><?=strtoupper("Country")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst09" rows="" cols=""><?=$qst09?></textarea></div>

						<p class="titpar"><?=strtoupper("City")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst10" rows="" cols=""><?=$qst10?></textarea></div>

						<p class="titpar"><?=strtoupper("Address")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst11" rows="" cols=""><?=$qst11?></textarea></div>

						<p class="titpar"><?=strtoupper("Tel")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst12" rows="" cols=""><?=$qst12?></textarea></div>

						<p class="titpar"><?=strtoupper("E-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst13" rows="" cols=""><?=$qst13?></textarea></div>

						<p class="titpar"><?=strtoupper("Web site ")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024"><textarea name="qst14" rows="" cols=""><?=$qst14?></textarea></div>

						<p class="titpar"><?=strtoupper("Picture of the university (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;">Please enclose a jpg picture of the university</span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl1" id="fuplo">
							<?php if(file_exists("./data/partnership/students/{$id_asch}_uni.jpg")) { ?><p style="float: right;width: 200px;margin: 0 0 0 0;"><img src="./data/partnership/students/<?=$id_asch?>_uni.jpg?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="" /></p><?php }?>
							<div class="clear"></div>
						</div>



						<div class="lbl04"><input type="submit" value="Send" /> <input type="reset" value="Reset" /></div>

					</form>









					<div class="clear"></div>
				</div> <!-- rsv_crp -->
				<div class="clear"></div>
			</div></div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<?php include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
