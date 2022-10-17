<?
include('./impianto/inc/function.php'); // funzioni PHP

////////////////////////////////////////Sanitize Vars ////////////////////
$DS=DIRECTORY_SEPARATOR;
$root="./";
require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");
$var_post=array(
			'art_id'=>'int',
			'par'=>'int',
			'id_asch'=>'int'
	);
$var_get=array(
			'part_id'=>'int',
			'par'=>'int',	
			'id_sch'=>'int'
	);
sanitize($_GET,$var_get);
sanitize($_POST,$var_post);
//////////////////////////////////////////////////////////////////////////////

$part_id=$_GET["part_id"];
$par=$_GET["par"];
$id_asch=$_GET["id_sch"];

$sql = "SELECT * FROM PRT_student WHERE id_asch=".$id_asch;
$result=mysql_query($sql,$conn);

while ($row=mysql_fetch_array($result)) { 
	$id_partner=Pulisci_READ_lnk($row["id_partner"]);
	$ptn_name=Pulisci_READ_lnk($row["partner"]);
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
	$qst18=Pulisci_READ($row["qst18"]);
	$qst20=Pulisci_READ($row["qst20"]);
}

$pict="./wiztr.gif";
if (file_exists("./data/partnership/students/{$id_asch}.jpg")) $pict="./data/partnership/students/{$id_asch}.jpg"; 
$pict1="./wiztr.gif";
if (file_exists("./data/partnership/students/{$id_asch}_uni.jpg")) $pict1="./data/partnership/students/{$id_asch}_uni.jpg"; 

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
			<div id="corpo">

			
				<h1><?=strip_tags($lnk05f)?></h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > <?=strip_tags($lnk05)?> > <?=strip_tags($lnk05f)?></p>

				<div id="page_sx">
					<!-- <p class="tit">Testimonials</p> -->
					<img src="./impianto/img/sx_PRTN_student.jpg" width="190" alt="" class="ntr" />
					<div class="intro"><?=$main_txt?></div>
				</div>

				<div id="page_crp" style="padding-top: 0px;">

					<p style="margin-bottom: 20px;padding: 2px 10px;text-align: right;background-color: #0085c8;border-radius: 5px;"><a href="./PRTN_students.php" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">Back to the Students</a></p>

					<div class="doc_sch">

						<p style="float: left;width: 150px;margin: 0 25px 0 0;"><img src="<?=$pict?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst02?>" /></p>
							
						<div style="float: left;width: 550px;">
							<?if($qst02) {?>
								<div class="doc_blk1">
									<span>NAME AND SURNAME</span> 
									<div class="data"><?=$qst02?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst03) {?>
								<div class="doc_blk1">
									<span>WEB SITE</span> 
									<div class="data"><?=replaceLinks($qst03)?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst04) {?>
								<div class="doc_blk1">
									<span>E-MAIL</span> 
									<div class="data"><?=replaceEmails($qst04)?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst05) {?>
								<div class="doc_blk1">
									<span>PROFILE</span> 
									<div class="data"><?=replaceLinks(nl2br($qst05))?></div>
									<div class="clear"></div>
								</div>
							<?}?>
						</div>
						<div class="clear"></div>
						
						<p class="titpar">UNIVERSITY</p>
						<p style="float: left;width: 150px;margin: 0 25px 0 0;"><img src="<?=$pict1?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst09?>" /></p>
							
						<div style="float: left;width: 550px;">
							<?if($qst06) {?>
								<div class="doc_blk1">
									<span>NAME OF THE UNIVERSITY</span> 
									<div class="data"><?=$qst06?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst07) {?>
								<div class="doc_blk1">
									<span>FACULTY / DEPARTMENT</span> 
									<div class="data"><?=$qst07?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst18) {?>
								<div class="doc_blk1">
									<span>DEGREE</span> 
									<div class="data"><?=$qst18?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst08) {?>
								<div class="doc_blk1">
									<span>STUDY PROGRAMME</span> 
									<div class="data"><?=$qst08?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst09) {?>
								<div class="doc_blk1">
									<span>COUNTRY</span> 
									<div class="data"><?=$qst20?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst10) {?>
								<div class="doc_blk1">
									<span>CITY</span> 
									<div class="data"><?=$qst10?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst11) {?>
								<div class="doc_blk1">
									<span>ADDRESS</span> 
									<div class="data"><?=$qst11?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst12) {?>
								<div class="doc_blk1">
									<span>TEL</span> 
									<div class="data"><?=$qst12?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst13) {?>
								<div class="doc_blk1">
									<span>E-MAIL</span> 
									<div class="data"><?=replaceEmails($qst13)?></div>
									<div class="clear"></div>
								</div>
							<?}?>
							
							<?if($qst14) {?>
								<div class="doc_blk1">
									<span>WEB SITE</span> 
									<div class="data"><?=replaceLinks($qst14)?></div>
									<div class="clear"></div>
								</div>
							<?}?>
						</div>
					</div> <!-- doc_sch -->

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
