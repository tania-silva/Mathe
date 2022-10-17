<?
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
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
</head>

<body>

<div id="container">
	<? include('./impianto/cappello.php'); //PIEDE?>
	<? include('./impianto/testa.php'); //PIEDE?>
	<div id="cnt1">
		<div id="corpo"><div id="rsv">
			<div id="rsv_menu"><? include('./impianto/spallaSx_ADMIN.php'); //Menu?></div>
			<div id="rsv_crp">

				











				<br /><br /><br />
			</div>
			<div class="clear"></div>
		</div></div> <!-- corpo -->
		<div class="clear"></div>
	</div> <!-- cnt1 -->
	<div id="cnt2"></div>
</div> <!-- container -->
<? include('./impianto/piede.php'); //PIEDE?>

</body>
</html>
