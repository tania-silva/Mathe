<?php
include('./impianto/inc/function.php'); // funzioni PHP

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
</head>

<body>

<?php include("header2.php"); ?>

	<div class="container">
		<div id="cnt1">
			<div id="corpo"><div id="rsv">
				<div id="rsv_menu"><?php include('./impianto/rsv_menu.php'); //Menu?></div>
				<div id="rsv_crp">

					<h1>Manage Schools</h1>
					<p id="crumbs"><a href="./reserved.php">Reserved Area</a> > Schools</p>












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
