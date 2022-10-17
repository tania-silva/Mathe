<?
include('./impianto/inc/function.php'); // funzioni PHP

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
	<link type="text/css" rel="stylesheet" href="./css/style.css" />
	
	<!-- jQuery library (served from Google) -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<!-- bxSlider Javascript file -->
	<script src="./impianto/addons/content_slider/jquery.bxslider.js"></script>
	<!-- bxSlider CSS file -->
	<link href="./impianto/addons/content_slider/jquery.bxslider.css" rel="stylesheet" />

	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
</head>

<body>
    
    <?php include("header.php"); ?>

<div id="container">
	<? include('./impianto/cappello.php'); //PIEDE?>
	<? include('./impianto/testa.php'); //PIEDE?>
	<div id="cnt1">
		<div id="corpo">

			<div id="hm01">
				
				<div id="scroller">
					<ul class="bxslider">
						<li>
							<a href="./MNG-prjdescription.php">
								<img src="./impianto/img/cs/pic01.jpg" />
								<p id="cstext">Main information about the Fiction Project</p>
							</a>
						</li>
					</ul>
				</div>
				<div id="welcome">
					<p class="wel01"><?=$hm01?></p>
					<p class="wel02"><?=$hm02?></p>
					<p class="wel03"><?=$hm03?></p>
					<p class="wel04"><?=$hm03a?></p>
				</div>
				<div class="clear"></div>

				<div id="hm02">
					<div class="hm_blk01 h01">
						<strong class="tit"><?=$hm04?></strong>
						<em class="incipit"><?=$hm041?></em>
						<ul class="skill">
							<li style="padding: 5px;font-size: 1.3em;color: #ccc;">Cooming Soon</li>
							<!-- <li><a href="./TG01.php"><?=$lnk03b?></a></li>
							<li><a href="./TG02.php"><?=$lnk03d?></a></li>
							<li><a href="./TG03.php"><?=$lnk03f?></a></li>
							<li><a href="./TG04.php"><?=$lnk03h?></a></li> -->
						</ul>
					</div>
					<div class="hm_blk01 h02" style="float: right;margin-right: 10px;">
						<strong class="tit"><?=$hm05?></strong>
						<em class="incipit"><?=$hm051?></em>
						<ul class="skill">
							<li style="padding: 5px;font-size: 1.3em;color: #ccc;">Cooming Soon</li>
							<!-- <li><a href="./path_MAP01.php">&#187; <?=$lnk04b?></a></li> -->
						</ul>
					</div>
					<div class="clear"></div>
					<!-- <div class="hm_blk01 h03">
						<strong class="tit"><?=$hm06?></strong>
						<em class="incipit"><?=$hm061?></em>
						<ul class="skill">
							<li style="padding: 5px;font-size: 1.3em;color: #ccc;">Cooming Soon</li>
						</ul>
					</div>
					<div class="hm_blk01 h04" style="float: right;margin-right: 10px;">
						<strong class="tit"><?=$hm09?></strong>
						<ul id="testimonials">
							<li style="padding: 5px;font-size: 1.3em;color: #ccc;">Cooming Soon</li>
						</ul>
					</div>
					<div class="clear"></div> -->
				</div>
				<div class="clear"></div>
				
			
			</div> <!-- hm01 -->

			<div class="clear"></div>
		</div> <!-- corpo -->
		<div class="clear"></div>
	</div> <!-- cnt1 -->
	<div id="cnt2"></div>
</div> <!-- container -->
<? include('./impianto/piede.php'); //PIEDE?>

</body>
</html>
