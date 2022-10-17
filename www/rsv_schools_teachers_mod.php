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
$id_tch=$_GET["id_tch"];
$id_sch=$_GET["id_sch"];

if ($_GET["com"]=="reg" AND $id_sch AND $id_tch) {

	$qst00=Pulisci_INS($_POST["qst00"]);
	$qst11=Pulisci_INS($_POST["qst11"]);
	$qst02=Pulisci_INS($_POST["qst02"]);
	$qst03=Pulisci_INS($_POST["qst03"]);
	$qst04=Pulisci_INS($_POST["qst04"]);
	$qst05=Pulisci_INS($_POST["qst05"]);
	$qst06=Pulisci_INS($_POST["qst06"]);
	$qst07=Pulisci_INS($_POST["qst07"]);

	$sql = "UPDATE `members_school_teacher` SET
	teach_name='$qst02',
	teach_web='$qst03',
	teach_email='$qst04',
	teach_subject='$qst05',
	teach_experience='$qst06',
	teach_prev_exp='$qst07'
	WHERE id_tch='$id_tch'";
	$result=mysqli_query($conn, $sql);

	$check= new CheckUpload($_FILES["fupl"]);
	if ($check->isOk()) {
		// Upload dell'allegato
		$path=ereg_replace("rsv_school_teachers_mod.php","",$_SERVER["PATH_TRANSLATED"]);

		$upload_dir = $path."./data/schools/teacher";
		$file_ext = strtolower(substr($_FILES["fupl"]['name'],-3));
		$file_name = $id_sch."_".$id_tch.".".$file_ext;

		move_uploaded_file($_FILES["fupl"]["tmp_name"],$upload_dir."/".$file_name);
		chmod($upload_dir."/".$file_name, 0777);
	}


	//Redirect su messaggio
	$strpas11="./rsv_schools_teachers.php?id_sch=".$id_sch;
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";


} else {
	$sql = "SELECT * FROM members_school WHERE id_sch=".$id_sch;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$sch_name=Pulisci_READ($row["sch_name"]);
	}

	$sql = "SELECT * FROM members_school_teacher WHERE (id_tch=".$id_tch." AND id_sch=".$id_sch.")";
$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$teach_name=Pulisci_READ($row["teach_name"]);
		$teach_web=Pulisci_READ($row["teach_web"]);
		$teach_email=Pulisci_READ($row["teach_email"]);
		$teach_subject=Pulisci_READ($row["teach_subject"]);
		$teach_experience=Pulisci_READ($row["teach_experience"]);
		$teach_prev_exp=Pulisci_READ($row["teach_prev_exp"]);
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

					<h1>Manage Schools</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > <a href="./rsv_schools.php">Schools</a> > Modify School</p>



					<p class="titpar">SCHOOL PRESENTATION FORM</p>
					<div class="txt">
						Fill in information about the teacher then press "Send" button.</a>
						<br /><br />
						If you want to <strong>see all the school</strong> yet uploaded <a href="./rsv_schools.php">click here</a><br />
						If you want to <strong>manage the teachers</strong> of this school <a href="./rsv_schools_teachers.php?id_sch=<?=$id_sch?>">click here</a><br />
						<!-- If you want to <strong>manage the counsellors</strong> of this school <a href="./rsv_schools_counsellor.php?id_sch=<?=$id_sch?>">click here</a> -->
					</div>



					<form method="post" action="./rsv_schools_teachers_mod.php?com=reg&id_sch=<?=$id_sch?>&id_tch=<?=$id_tch?>" onreset="return confirm('Are you sure you want to reset the document?')" enctype="multipart/form-data">
						<input type="hidden" name="qst00" value="<?=$_SESSION["id_user"]?>" />

						<br />
						<p class="label">Name of the school: <?=strtoupper($sch_name)?></p>

						<p class="titpar" style="padding-right: 25px;text-align: center;background: none;border-bottom: solid 2px #666;color: #666">TEACHERS INVOLVED</p>

						<p class="titpar"><?=strtoupper("Name of the contact teacher")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst02" rows="" cols=""><?=$teach_name?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("Web site")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst03" rows="" cols=""><?=$teach_web?></textarea>
						</div>

						<p class="titpar"><?=strtoupper("E-mail")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst04" rows="" cols=""><?=$teach_email?></textarea>
						</div>

						<!-- <p class="titpar"><?=strtoupper("Subject taught")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl021">
							<p style="float: left;width: 120px;margin-left: 25px;"><input type="radio" name="qst05" value="Humanistic Subjects" <?php if ($teach_subject=="Humanistic Subjects") echo "checked=\"checked\"";?> />&nbsp;Humanistic Subjects</p>
							<p style="float: left;width: 120px;margin-left: 20px;"><input type="radio" name="qst05" value="English" <?php if ($teach_subject=="English") echo "checked=\"checked\"";?> />&nbsp;English</p>
							<p style="float: left;width: 120px;margin-left: 20px;"><input type="radio" name="qst05" value="Other" <?php if ($teach_subject=="Other") echo "checked=\"checked\"";?> />&nbsp;Other</p>
							<div class="clear"></div>
						</div> -->
						<!-- <div class="lbl023">
							<textarea name="qst05" rows="" cols=""><?=$teach_subject?></textarea>
						</div> -->

						<p class="titpar"><?=strtoupper("Years of experience")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst06" rows="" cols=""><?=$teach_experience?></textarea>
						</div>

						<!-- <p class="titpar"><?=strtoupper("Previous experiences on the project thematic area (other projects, training courses, …)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl023">
							<textarea name="qst07" rows="" cols=""><?=$teach_prev_exp?></textarea>
						</div> -->

						<p class="titpar"><?=strtoupper("Picture of the contact teacher (JPG)")?><br /><span style="font-size: 8pt;font-weight: normal;line-height: 1em;"></span></p>
						<div class="lbl024">
							<input type="hidden" name="MAX_FILE_SIZE" value="10240000"><input type="file" size="10" name="fupl" id="fuplo">
						</div>



						<br /><br />
						<div class="lbl04"><input type="submit" name="Send" value="Send" /> <input type="reset" value="Reset" /></div>

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
