<?php
include('./impianto/inc/function.php'); // funzioni PHP


$id_asch=$_GET["id_asch"];
$id_partner=$_GET["id_partner"];

if ($_GET["com"]=="reg" AND $id_asch AND $id_partner) {

	$sql = "DELETE FROM `PRT_student` WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);


	$file_del="./data/partnership/students/{$id_asch}.jpg";
	if (file_exists($file_del)) unlink($file_del);
	$file_del="./data/partnership/students/{$id_asch}_uni.jpg";
	if (file_exists($file_del)) unlink($file_del);

	//Redirect su messaggio
	$strpas11="./rsv_students.php";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";



} else {
	$sql = "
		SELECT *
		FROM PRT_student
		WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);


	while ($row=mysqli_fetch_array($result)) {
		$sch_name=Pulisci_READ($row["qst02"]);
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

					<div class="el_msg">
						<p class="p01">Do you want to delete this Student?</p>

						<p class="titpar">NAME OF THE STUDENT</p>
						<p class="p03"><?=$sch_name?></p>

						<div style="margin: 35px 0 0 0;">
							<a href="./rsv_students_del.php?com=reg&id_asch=<?=$id_asch?>&id_partner=<?=$id_partner?>"><img src="./impianto/img/confirm.png" width="122" height="37" alt="" border="0" /></a>
							&nbsp;&nbsp;&nbsp;
							<a href="./rsv_students.php"><img src="./impianto/img/abort.png" width="122" height="37" alt="" border="0" /></a>
						</div>
					</div>


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
