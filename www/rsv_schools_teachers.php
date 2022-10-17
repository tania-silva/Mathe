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

if ($_GET["com"]=="reg") {

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
		sch_par_numb='$qst19'
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
		$qst19=Pulisci_READ($row["sch_par_numb"]);
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
						Here you can modify information about teachers of this school.<br />
						If you want to <strong>add a teacher</strong> in this school <a href="./rsv_schools_new1.php?id_sch=<?=$id_sch?>&opz=1">click here</a>
						<br /><br />
						If you want to <strong>see all the school</strong> yet uploaded <a href="./rsv_schools.php">click here</a><br />
						<!-- If you want to <strong>manage the counsellors</strong> of this school <a href="./rsv_schools_counsellor.php?id_sch=<?=$id_sch?>">click here</a> -->
					</div>






					<table class="for1" style="margin-top: 25px;">
						<thead>
							<tr>
								<!-- <?php if ($_SESSION["usr_level"]>=2) {?><td class="tdtit">&nbsp;</td><?php }?> -->
								<td class="tdtit">Teacher name</td>
								<td class="tdtit" style="width: 200px;">Name of<br />the school</td>
								<td class="tdtit"><img src="./wiztr.gif" width="55" height="1" /></td>
							</tr>
						</thead>
						<tbody>
							<?
							if ($_SESSION["id_user"]) {
								$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
								$result=mysqli_query($conn, $sql);


								while ($row=mysqli_fetch_array($result)) {
									$id_partner=Pulisci_READ($row["id_partner"]);
									$usr_level=Pulisci_READ($row["usr_level"]);
								}
							}

				//			$par_permit="off";
				//			if ($usr_level==5) $par_permit="on";



							if ($partner!="") {
								$where="WHERE id_sch=".$id_sch;
							} else {
								$where="";
							}

//							$sql = "SELECT * FROM members_school_teacher
//							WHERE id_sch=".$id_sch."
//							ORDER BY teach_name";

							$sql = "
							SELECT * FROM members_school_teacher as o
							LEFT JOIN members_school as c
							ON o.id_sch = c.id_sch
							WHERE o.id_sch=".$id_sch."
							ORDER BY teach_name";

							$result=mysqli_query($conn, $sql);

							$count_tot=mysqli_num_rows($result);

							while ($row=mysqli_fetch_array($result)) {
								$lnk1="./rsv_schools_teachers_mod.php?id_sch=".$row["id_sch"]."&id_tch=".$row["id_tch"];
								//$lnk1="./rsv_schools_mod.php?id_sch=".$row["id_sch"];
								$lnk3="./rsv_schools_teachers_del.php?id_sch=".$row["id_sch"]."&id_tch=".$row["id_tch"];
								//$lnk4="./school_stampa.php?id_sch=".$row["id_sch"];

								$par_permit="off";
								if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
								$adm_permit="off";
								if ($usr_level==5) $adm_permit="on";

								$school_name=Pulisci_READ($row["sch_name"]);
								$teacher_name=Pulisci_READ($row["teach_name"]);

								?>
								<tr>
									<!-- <td><a href="<?=$lnk?>"><img class="freccia" src="./impianto/img/freccia01.gif" alt="" /></a></td> -->
									<!-- <?php if ($_SESSION["usr_level"]>=2) {?><td><a href="<?=$lnk4?>" onclick="javascript=this.target='blank';"><img src="./impianto/img/print.png" alt="" border="0" /></a></td><?php }?> -->
									<td><?=$teacher_name?></td>
									<td><?=$school_name?></td>
									<td style="text-align: right;"><?php if ($par_permit=="on") {  ?><a href="<?=$lnk3?>"><img src="./impianto/img/delete.png" width="24" height="15" alt="Delete this teacher" /></a> <?php }?><?php if ($par_permit=="on") {  ?><a href="<?=$lnk1?>"><img src="./impianto/img/edit.png" width="27" height="15" alt="Edit this teacher" /></a><?php }?></td>
								</tr>
								<?
							}
							?>
						</tbody>
					</table>







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
