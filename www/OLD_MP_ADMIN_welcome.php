<?
session_start();

include('./impianto/inc/function.php'); // funzioni PHP
include('./impianto/inc/protected.php'); //Se non loggato esci...

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
<head>
	<title><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="Generator" content="AmeeIV" />
	<meta name="Author" content="Ing. Francesco Pinzani" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/struttura.css" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/mathePortal.css" />
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
</head>

<body>
	<div id="container">
		<? include('./impianto/cappello.php'); //PIEDE?>
		<? include('./impianto/testa.php'); //PIEDE?>
		<div id="cnt1">
			<div id="corpo">

			
				<h1>Admin Reserved Area</h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > MathE Platform > Admin Reserved Area</p>

				<div id="page_sx" style="font-size: 1.1em;">
					<? include('./impianto/spallaSx_ADMIN.php'); // funzioni PHP ?>
				</div>
				<div id="page_crp">


					
					
					
				</div> <!-- page_crp -->


				<div class="clear"></div>
			</div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<? include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
