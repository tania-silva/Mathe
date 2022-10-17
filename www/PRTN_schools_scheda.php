<?
include('./impianto/inc/function.php'); // funzioni PHP

$part_id=$_GET["part_id"];
$par=$_GET["par"];
$id_sch=$_GET["id_sch"];

$sql = "SELECT * FROM members_school WHERE id_sch=".$id_sch;
$result=mysql_query($sql,$conn);

while ($row=mysql_fetch_array($result)) { 
	$id_partner=Pulisci_READ($row["id_partner"]);
	$ptn_name=Pulisci_READ($row["partner"]);
	$qst02=Pulisci_READ($row["sch_name"]);
	$qst03=Pulisci_READ($row["sch_address"]);
	$qst04=Pulisci_READ($row["sch_tel"]);
	$qst05=Pulisci_READ($row["sch_fax"]);
	$qst06=nl2br(replaceLinks(Pulisci_READ($row["sch_web"])));
	$qst07=Pulisci_READ($row["sch_email"]);
	$qst08=Pulisci_READ($row["sch_type"]);
	$qst08_01=Pulisci_READ($row["sch_type_other"]);
	$qst09=Pulisci_READ($row["sch_n_student"]);
	$qst10=Pulisci_READ($row["sch_student_age"]);
	$qst11=Pulisci_READ($row["sch_dir_name"]);
	$qst12=Pulisci_READ($row["sch_dir_addr"]);
	$qst13=Pulisci_READ($row["sch_dir_tel"]);
	$qst14=Pulisci_READ($row["sch_dir_fax"]);
	$qst15=nl2br(replaceLinks(Pulisci_READ($row["sch_dir_web"])));
	$qst16=Pulisci_READ($row["sch_dir_email"]);
	$qst17=Pulisci_READ($row["sch_st_involved"]);
	$qst18=Pulisci_READ($row["sch_st_age"]);
	$qst19=Pulisci_READ($row["sch_st_fever"]);
}

$sql33 = "SELECT * FROM partner WHERE id_partner=".$id_partner;
$result33=mysql_query($sql33,$conn);

while ($row33=mysql_fetch_array($result33)) { 
	$prt_name=$row33["name"];
	$prt_country=$row33["country"];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
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
    
    <?php include("header.php"); ?>
    
	<div id="container">
		<? include('./impianto/cappello.php'); //PIEDE?>
		<? include('./impianto/testa.php'); //PIEDE?>
		<div id="cnt1">
			<div id="corpo">
			
				<h1><?=strip_tags($lnk05d)?></h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > <?=strip_tags($lnk05)?> > <?=strip_tags($lnk05d)?></p>

				<div id="page_sx">
					<!-- <p class="tit">Testimonials</p> -->
					<img src="./impianto/img/sx_PRTN_schools.jpg" width="190" alt="" class="ntr" />
					<div class="intro"><?=$main_txt?></div>
				</div>
				
				<div id="page_crp" style="padding-top: 0;">

					<? if ($_SESSION["usr_level"]>0) {  ?>
					
					
					<!-- <h2>Partnership > Schools</h2> -->
			
						<p style="margin-bottom: 20px;padding: 2px 10px;text-align: right;background-color: #446170;border-radius: 5px;"><a href="./PRTN_schools.php" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">Back to the Schools List</a></p>

						<div class="doc_sch">


							
							<?if($qst02) {?>
								<? if(file_exists("./data/schools/{$id_sch}.jpg")) { ?><p style="float: left;width: 250px;margin: 0 25px 0 0;"><img src="./data/schools/<?=$id_sch?>.jpg?rnd=<?=$rand_n?>" style="width: 250px;border: solid 1px #999;" alt="<?=$qst02?>" /></p><?}?>
							<?}?>

							<div style="float: left;width: 450px;">
								<div class="doc_blk1" style="margin-bottom: 20px;">
									<p class="name" style="font-size: 1.9em;font-weight: 400;"><?=$qst02?></p>
									<p class="name" style="padding: 2px 0 0 0;font-size: 1.5em;"><em><?=$qst03?> - <?=$prt_country?></em></p>
								</div>
								<?if($qst04) {?>
									<div class="doc_blk1">
										<span>TELEPHONE</span> <?=$qst04?>
									</div>
								<?}?>

								<?if($qst05) {?>
									<div class="doc_blk1">
										<span>FAX</span> <?=$qst05?>
									</div>
								<?}?>

								<?if($qst06) {?>
									<div class="doc_blk1">
										<span>WEB SITE</span> <?=$qst06?>
									</div>
								<?}?>

								<?if($qst07) {?>
									<div class="doc_blk1">
										<span>E-MAIL</span> <a href="mailto:<?=$qst07?>"><?=$qst07?></a>
									</div>
								<?}?>
							</div>

						</div>
						<div class="clear"></div>
			
						<div class="doc_sch">
							
							<?if($qst08 OR $qst09 OR $qst10) {?>
								<p class="titpar">DESCRIPTION OF THE SCHOOL</p>
							<?}?>

							<?if($qst08 OR $qst08_01) {?>
								<div class="doc_blk1">
									<span>TYPE OF SCHOOL</span> 
									<?
										if ($qst08!="Other") echo $qst08; else echo $qst08_01;
									?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst09) {?>
								<div class="doc_blk1">
									<span>NUMBER OF STUDENTS</span> <?=$qst09?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst10) {?>
								<div class="doc_blk1">
									<span>AGE OF STUDENTS</span> <?=$qst10?>
								</div>
								<div class="clear"></div>
							<?}?>

						</div>
			
						<div class="doc_sch">
							<?if($qst11 OR $qst12 OR $qst13 OR $qst14 OR $qst15 OR $qst16) {?>
								<p class="titpar">SCHOOL DIRECTOR</p>
							<?}?>

							<?if($qst11) {?>
								<div class="doc_blk1">
									<span>NAME</span> <?=$qst11?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst12) {?>
								<div class="doc_blk1">
									<span>ADDRESS</span> <?=$qst12?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst13) {?>
								<div class="doc_blk1">
									<span>TELEPHONE</span> <?=$qst13?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst14) {?>
								<div class="doc_blk1">
									<span>FAX</span> <?=$qst14?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst15) {?>
								<div class="doc_blk1">
									<span>WEB SITE</span> <?=$qst15?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst16) {?>
								<div class="doc_blk1">
									<span>E-MAIL</span> <a href="mailto:<?=$qst16?>"><?=$qst16?></a>
								</div>
								<div class="clear"></div>
							<?}?>

						</div>
			
						<?
						$sql = "SELECT * FROM members_school_teacher WHERE id_sch=".$id_sch;
						$result=mysql_query($sql,$conn);
						$n_tch=0;

						while ($row=mysql_fetch_array($result)) { 
							$id_tch=$row["id_tch"];
							$teach_name=Pulisci_READ($row["teach_name"]);
							$teach_web=nl2br(replaceLinks(Pulisci_READ($row["teach_web"])));
							$teach_email=$row["teach_email"];
							$teach_subject=Pulisci_READ($row["teach_subject"]);
							$teach_subject_spec=Pulisci_READ($row["teach_subject_spec"]);
							$teach_experience=Pulisci_READ($row["teach_experience"]);
							$teach_prev_exp=Pulisci_READ($row["teach_prev_exp"]);
							if (file_exists("./data/schools/teacher/{$id_sch}_{$id_tch}.jpg")) 
								$teach_img="./data/schools/teacher/{$id_sch}_{$id_tch}.jpg"; 
							else 
								$teach_img="./impianto/img/nouserpict.jpg"; 
							?>
							<div class="doc_sch">
								<? if ($n_tch==0) {
									?><p class="titpar">TEACHERS INVOLVED</p><?
								}?>
								

								<? if($n_tch>0) {?>
									<div style="margin: 5px 0;height: 1px;line-height: 1px;font-size: 1px;border-top: solid 1px #446170;">&nbsp;</div>
								<?}?>

								<p style="float: left;width: 150px;margin: 0 25px 0 0;"><img src="<?=$teach_img?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst02?>" /></p>

								<div style="float: left;width: 550px;">
									<?if($teach_name) {?>
										<div class="doc_blk1">
											<span>NAME</span> <?=$teach_name?>
										</div>
									<?}?>

									<?if($teach_web) {?>
										<div class="doc_blk1">
											<span>WEB SITE</span> <?=$teach_web?>
										</div>
									<?}?>

									<?if($teach_email) {?>
										<div class="doc_blk1">
											<span>E-MAIL</span> <a href="mailto:<?=$teach_email?>"><?=$teach_email?></a>
										</div>
									<?}?>

									<?if($teach_subject) {?>
										<div class="doc_blk1">
											<span>SUBJECT TAUGHT</span> <?=$teach_subject?>
										</div>
									<?}?>

									<?if($teach_subject_spec) {?>
										<div class="doc_blk1">
											<span>SPECIFIC SUBJECT</span> <?=$teach_subject_spec?>
										</div>
									<?}?>

									<?if($teach_experience) {?>
										<div class="doc_blk1">
											<span>YEARS OF EXPERIENCE</span> <?=$teach_experience?>
										</div>
									<?}?>

									<!-- <?if($teach_prev_exp) {?>
										<div class="doc_blk1">
											<span>PREVIOUS EXPERIENCES ON THE PROJECT THEMATIC AREA </span> <?=$teach_prev_exp?>
										</div>
									<?}?> -->
							</div>
							<div class="clear"></div>

							<?
								$n_tch+=1;
						}
						?>
			
						<!-- <?
						$sql = "SELECT * FROM members_school_counsellor WHERE id_sch=".$id_sch;
						$result=mysql_query($sql,$conn);
						$n_tch=0;

						while ($row=mysql_fetch_array($result)) { 
							$id_tch=$row["id_tch"];
							$couns_name=Pulisci_READ($row["couns_name"]);
							$couns_web=nl2br(replaceLinks(Pulisci_READ($row["couns_web"])));
							$couns_email=$row["couns_email"];
							$couns_specialization=Pulisci_READ($row["couns_specialization"]);
							$couns_experience=Pulisci_READ($row["couns_experience"]);
							if (file_exists("./data/schools/counsellor/{$id_sch}_{$id_tch}.jpg")) 
								$couns_img="./data/schools/counsellor/{$id_sch}_{$id_tch}.jpg"; 
							else 
								$couns_img="./impianto/img/nouserpict.jpg"; 
							?>
							<div class="doc_sch">
								<? if ($n_tch==0) {
									?><p class="titpar">SCHOOL COUNSELLORS INVOLVED</p><?
								}?>

								<? if($n_tch>0) {?>
									<div style="margin: 5px 0;height: 1px;line-height: 1px;font-size: 1px;border-top: solid 1px #446170;">&nbsp;</div>
								<?}?>

								<p style="float: left;width: 150px;margin: 0 25px 0 0;"><img src="<?=$couns_img?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst02?>" /></p>

								<?if($couns_name) {?>
									<div class="doc_blk1">
										<span>NAME</span> <?=$couns_name?>
									</div>
								<?}?>

								<?if($couns_web) {?>
									<div class="doc_blk1">
										<span>WEB SITE</span> <?=$couns_web?>
									</div>
								<?}?>

								<?if($couns_email) {?>
									<div class="doc_blk1">
										<span>E-MAIL</span> <a href="mailto:<?=$couns_email?>"><?=$couns_email?></a>
									</div>
								<?}?>

								<?if($couns_specialization) {?>
									<div class="doc_blk1">
										<span>SPECIALIZATION</span> <?=$couns_specialization?>
									</div>
								<?}?>

								<?if($couns_experience) {?>
									<div class="doc_blk1">
										<span>YEARS OF EXPERIENCE</span> <?=$couns_experience?>
									</div>
								<?}?>

							</div>
							<div class="clear"></div>

							<?
								$n_tch+=1;
						}
						?> -->

						<div class="doc_sch">
							<?if($qst17 OR $qst19 OR $qst18) {?>
								<p class="titpar">STUDENTS INVOLVED</p>
							<?}?>

							<?if($qst17) {?>
								<div class="doc_blk1">
									<span style="width: 250px;">Total number of students involved</span> <?=$qst17?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst19) {?>
								<div class="doc_blk1">
									<span style="width: 250px;">Students with fewer opportunities</span> <?=$qst19?>
								</div>
								<div class="clear"></div>
							<?}?>

							<?if($qst18) {?>
								<div class="doc_blk1">
									<span style="width: 250px;">Age Range</span> <?=$qst18?>
								</div>
								<div class="clear"></div>
							<?}?>

						</div>

					<? } else { ?>
						<? include('./impianto/inc/sorry.php'); //PIEDE?>
					<? } ?>








				</div>

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
