<?php
include('./top.php'); // funzioni PHP
?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">


<?php 

$assId=$_GET["assId"];

$sql = "
	SELECT * 
	FROM platform__SNA__assestment 
	WHERE id_stud=$usrId AND id=$assId
	LIMIT 1";
$result=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_array($result)) { 
	$topic=$row["topic"];
	$subtopic=$row["subtopic"];
	$level=$row["level"];
	$qst01=$row["qst01"];
	$qst02=$row["qst02"];
	$qst03=$row["qst03"];
	$qst04=$row["qst04"];
	$qst05=$row["qst05"];
	$qst06=$row["qst06"];
	$qst07=$row["qst07"];
}

$qstAr = array($qst01, $qst02, $qst03, $qst04, $qst05, $qst06, $qst07);

$assResult=0;
foreach ($qstAr as $question) {
	$questionSplit=explode("|",$question);
	$qstIdcicl=$questionSplit[0];
	$ansNb=$questionSplit[1];
	if ($qstIdcicl) $qstNb+=1;
	if ($ansNb==1) $assResult+=1;
}
$assResultPerc=$assResult/$qstNb*100;
if ($assResultPerc>=0 AND $assResultPerc<55) {
	$assResultTr="<strong>Your performance is not good</strong> and it would be advisable to go back to the theory";
	$assResultPictUrl="./impianto/img/SNA_notgood.png";
} elseif ($assResultPerc>=55 AND $assResultPerc<80) {
	$assResultTr="<strong>Your performance is good</strong> but you still have room for improvement";
	$assResultPictUrl="./impianto/img/SNA_good.png";
} elseif ($assResultPerc>=80) {
	$assResultTr="<strong>Congratulation, your performance is excellent</strong>";
	$assResultPictUrl="./impianto/img/SNA_excellent.png";
}
$topicName="";
$sql = "
	SELECT * 
	FROM platform__topic 
	WHERE (id=$topic AND hidden=0) 
	LIMIT 1";
$result=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_array($result)) { 
	$topicName=$row["name"];
}

$subtopicName="";
$sql = "
	SELECT * 
	FROM platform__subtopic 
	WHERE (id=$subtopic AND id_top=$topic AND hidden=0) 
	LIMIT 1";
$result=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_array($result)) { 
	$subtopicName=$row["name"];
}

?>
<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
	tex2jax: {
	  inlineMath: [ ['$','$'], ["\\(","\\)"] ],
	  processEscapes: true
	}
  });
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>


	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Self Need Assessment</h1>
                    </div>
                </div>
            </div>
        </section>
	
	
        <!-- Blog detail -->
        <section class="single section-padding-large">
            <div class="container">
                <div class="row">
					<div class="col-1"></div>
			
                    <div class="col-10">
                        <div class="single-content">

							<nav aria-label="breadcrumb">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item">Student's Assessment</li>
								</ul>
							</nav>
				
							<h2 class="single-title">
								This toolkit allows students to carry out a self-evaluation of their knowledge on 10 selected Math topics.
							</h2>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Self Need Assesment
									</span>
								</div>
							</div> -->
				
				<!-- START contenuto pagina -->
				
				<div id="page_crp">
					<div class="txt">

						<?php  if ($_SESSION["guest"]) {?>

							<!-- <form method="post" action="./STAS_SNA_result.php?assId=<?=$assId?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;"> -->


								<div>
									<div style="float: right;width: 400px;padding-right: 18px;font-size: 1.0em;color: #999;text-align: right;">
										<p>Topic: <?=$topicName?></p>
										<?php  if ($subtopicName) {?><p>Subtopic: <?=$subtopicName?></p><?php }?>
										<p>Level: <?=$level?></p>
									</div>
								</div>
								<div class="clear"></div>

								<!-- <p style="padding: 20px 0 0 20px;font-size: 1.2em;">Correct answers <?=$assResult?>/7 (<?=number_format($assResultPerc, 2)?>% - <?=$assResultTr?>)</p> -->
								
								<div style="padding: 30px 0 0 20px;font-size: 1.2em;">
									<img src="<?=$assResultPictUrl?>" width="100" alt="" style="float: left;margin-top: -20px;" />
									<p>The number of correct answers is <?=$assResult?> on a total number of <?=$qstNb?> questions.</p>
									<p><?=$assResultTr?></p>
									<div class="clear"></div>
								</div>
						
								<?php 
								$k=1;
								foreach ($qstAr as $question) {
									$questionSplit=explode("|",$question);
									$qstId=$questionSplit[0];
									$ansNb=$questionSplit[1];

									if ($qstId) { 

										$sql = "
											SELECT * 
											FROM platform__SNA__questions 
											WHERE id=$qstId
											LIMIT 1";
										$result=mysqli_query($conn,$sql);
										
										while ($row=mysqli_fetch_array($result)) { 
											$idLectX=$row["id_lect"];
											$description=$row["description"];
											$questionX=$row["question"];
											$answer1X=$row["answer1"];
											$answer2X=$row["answer2"];
											$answer3X=$row["answer3"];
											$answer4X=$row["answer4"];
											$fileNameX=$row["file_name"];
											$fileExtX=$row["file_ext"];
											$dateX=$row["date"];
										}

										$answersArX = array("1||§§".$answer1X, "2||§§".$answer2X, "3||§§".$answer3X, "4||§§".$answer4X);
										shuffle($answersArX);

										$attachX=0;
										$pictX="./data/mathePlatform/SNA/attach/{$qstId}.{$fileExtX}";
										if (file_exists($pictX)) $attachX=1;

										$qstArray=$qstAr[$k-1];
										$ansRegAr=explode("|", $qstArray);
										$ansReg=$ansRegAr[1];

										// Ricavo l'email dell'autore della domanda
										$sqlL = "
											SELECT * 
											FROM platform__lecturers 
											WHERE id_lect=$idLectX 
											LIMIT 1";
										$resultL=mysqli_query($conn,$sqlL);

										while ($rowL=mysqli_fetch_array($resultL)) { 
											$authQstEmail=$rowL["email"];
										}

										?>
						
										<p style="padding: 30px 0 5px 18px;font-size: 1.8em;font-weight: 400;color: #999;text-align: center;border-bottom: solid 1px #444;">Question <?=$k?></p>
										<div class="signup_field_ext">
											<div class="data" style="margin: 0 30px 0 0;padding: 10px;color: #009;background-color: #edf3fe;border-radius: 5px;">
												<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($questionX)?></div>
												<?php if ($attachX) {?><p style="padding: 10px 0 10px 0;">Attachment: <a href="<?=$pictX?>" target="_blank" style="font-size: 1.0em;color: #900;"><?=$fileNameX?></a></p><?php }?>
											</div>
										</div>
										<?php 
										$h=1;
										foreach ($answersArX as $answerX) {
											$AnswerSplitX=explode("||§§",$answerX);
											$ansNbX=$AnswerSplitX[0];
											$ansValueX=$AnswerSplitX[1];

											$ansChoose=0;
											$bgColor="transparent";
											if ($ansReg==$ansNbX) {
												if ($ansNbX==1) {
													$bgColor="#d6f5da";
													$ansTr="CORRECT";
													$ansPict="./impianto/img/qstExact.png";
												} else {
													$bgColor="#fcbaba";
													$ansTr="WRONG";
													$ansPict="./impianto/img/qstWrong.png";
												}
												?>
													<div class="signup_field_ext" style="margin-left: 20px;">
														<p style="font-size: 1.0em;font-weight: 400;color: #999;">Your answer is <?=$ansTr?>:</p>
														<div class="data" style="margin: 5px 30px 0 0px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;background-color: <?=$bgColor?>;border-radius: 5px;border-width: 0 0 1px 1px;">
															<img src="<?=$ansPict?>" alt="" width="50" height="50" style="float: left;margin: 0 10px 0 0;" /><div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($ansValueX)?></div><div class="clear"></div>
														</div>
													</div>
												<?php 
											}
											$h+=1;
										}

										if ($ansReg=="0") {
											?>
												<div class="signup_field_ext" style="margin-left: 20px;">
													<p style="font-size: 1.0em;font-weight: 400;color: #999;">Your answer is WRONG:</p>
													<div class="data" style="margin: 5px 30px 0 0px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;background-color: #fcbaba;border-radius: 5px;border-width: 0 0 1px 1px;">
														<img src="./impianto/img/qstWrong.png" alt="" width="50" height="50" style="float: left;margin: 0 10px 0 0;" /><div style="font-size: 1.1em;line-height: 1.3em;">I DON'T KNOW</div><div class="clear"></div>
													</div>
												</div>
											<?php 
										}
										?>
										<p style="padding: 5px 50px 0 0;text-align: right;"><a href="mailto:mathe@ipb.pt,<?=$authQstEmail?>?subject=Report an error for question SNA<?=$qstId?>">Report an error</a></p>
										<?php 
										// Visualizzo la risposta corretta se la risposta data è sbagliata
										if ($ansReg!=1) {
											?>
												<div class="signup_field_ext" style="margin-left: 20px;">
													<p style="font-size: 1.0em;font-weight: 400;color: #999;">The correct answer is:</p>
													<div class="data" style="margin: 5px 30px 0 0px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;background-color: #d6f5da;border-radius: 5px;border-width: 0 0 1px 1px;">
														<img src="./impianto/img/qstExact.png" alt="" width="50" height="50" style="float: left;margin: 0 10px 0 0;" /><div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($answer1X)?></div><div class="clear"></div>
													</div>
												</div>
											<?php 
										}
										?>



										<?php
										if ($ansReg!=1) {
											$sql = "
												SELECT id, title, author, description, link, date, validate, languages, questions, 'vdLessons' as path 
												FROM platform__SNA__VID_lessons
												WHERE (INSTR(questions, '_{$qstId}_')>0 AND validate=1) 
												UNION
												SELECT id, title, author, description, link, date, validate, languages, questions, 'vdReviews' as path  
												FROM platform__SNA__VID_reviews
												WHERE (INSTR(questions, '_{$qstId}_')>0 AND validate=1) 
												ORDER BY date DESC";
											$result=mysqli_query($conn, $sql);
											$nSugg=mysqli_num_rows($result);

											if ($nSugg>0) {
												?>
												<p style="margin: 50px 30px 0 20px;padding: 5px 20px;font-size: 1.2em;color: #fff;background-color: #aaa;border-radius: 5px 5px 0 0;">You might want to have a look at</p>
												<div style="padding: 0 30px 30px 20px;">
													<table class="table table-bordered">
														<tbody>
																<?php
																while ($row=mysqli_fetch_array($result)) { 
																	$vidId=$row["id"];
																	$videoTitle=$row["title"];
																	$videoAuthor=$row["author"];
																	$videoDescription=$row["description"];
																	$videoLink=$row["link"];
																	$videoLang=$row["languages"];
																	$fileExt=$row["file_ext"];
																	$date=$row["date"];
																	$validate=$row["validate"];
																	$validate_date=$row["validate_date"];
																	$validate_by=$row["validate_by"];
																	$path=$row["path"];

								
																	// Languages
																	$sql17 = "SELECT * FROM VID_lang ORDER BY ord";
																	$result17=mysqli_query($conn,$sql17);

																	$langNameStr="";
																	while ($row17=mysqli_fetch_array($result17)) { 
																		$id_key17=$row17["id_key"];
																		$langName17=$row17["nome"];
																		if (strrpos($videoLang,"_".$id_key17."_")) {
																			$langNameStr.=$langName17.", ";
																		}
																	}
																	$langNameStr=substr($langNameStr,0,-2);


																	$videoPreview="";
																	if (strpos($videoLink, "/")===False AND strlen($videoLink)==11) {
																		// E' stato inserito il codice di 11 caratteri di YouTube
																		$youtubeCode=$videoLink;
																		$videoPreview="<iframe width='200' height='113' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
																	} elseif (strpos($videoLink, "youtu.be")>0) {
																		// E' stato inserito il link per la condivisione di Youtube
																		$youtubeCode=substr($videoLink,-11);
																		$videoPreview="<iframe width='200' height='113' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
																	} else {
																		$icon="./impianto/img/notAvailable.jpg";
																		if (file_exists("./data/mathePlatform/SNA/".$path."/".$vidId.".jpg")) $icon="./data/mathePlatform/SNA/".$path."/".$vidId.".jpg";
																		$videoPreview="<a href=\"".$videoLink."\" target=\"_blank\"><div style=\"display: block;width: 200px;height: 113px;background: url(".$icon.") #fff no-repeat 0 0;background-size: 200px auto;\"></div></a>";
																	}
																	?>
																		<tr>
																			<td style="padding-top: 5px"><?=$videoPreview?></td>
																			<td>
																				<div style="font-size: 1.1em;font-weight: 500;line-height: 1.3em;"><?=nl2br($videoTitle)?></div>
																				<div style="padding-top: 2px;font-size: 0.9em;line-height: 1.3em;"><em><?=$videoAuthor?></em></div>
																				<div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;"><?=$videoDescription?></div>
																				<div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;">Languages: <?=$langNameStr?></div>
																			</td>
																		</tr>
																	<?php
																}
															?>
														</tbody>
													</table>
												</div>
												<?php
											}


											/* TEACHING MATERIAL */
											$sql = "
												SELECT * 
												FROM platform__SNA__tchmaterials
												WHERE (INSTR(questions, '_{$qstId}_')>0 AND validate=1) 
												ORDER BY date DESC";
											$result=mysqli_query($conn, $sql);
											$nSugg=mysqli_num_rows($result);

											if ($nSugg>0) {
												?>
												<p style="margin: 20px 30px 0 20px;padding: 5px 20px;font-size: 1.2em;color: #fff;background-color: #aaa;border-radius: 5px 5px 0 0;">Teaching Material</p>
												<div style="padding: 0 30px 30px 20px;">
													<table class="table table-bordered">
														<tbody>
																<?php
																while ($row=mysqli_fetch_array($result)) { 
																	$vidId=$row["id"];
																	$videoTitle=$row["title"];
																	$videoAuthor=$row["author"];
																	$videoDescription=$row["description"];
																	$videoType=$row["type"];
																	$videoLink=$row["link"];
																	$videoLang=$row["languages"];
																	$fileName=$row["file_name"];
																	$fileExt=$row["file_ext"];
																	$date=$row["date"];
																	$validate=$row["validate"];
																	$validate_date=$row["validate_date"];
																	$validate_by=$row["validate_by"];

																	$puntini="";
																	if (strlen($videoDescription)>250) $puntini="...";
																	$videoDescription=substr($videoDescription,0,250).$puntini;

																	if ($date!="" AND $date!="0000-00-00 00:00:00") {
																		$ins_data_expl=explode("-",$date);
																		$ins_data_aa=$ins_data_expl[0];
																		$ins_data_mm=$ins_data_expl[1];
																		$ins_data_expl1=explode(" ",$ins_data_expl[2]);
																		$ins_data_gg=$ins_data_expl1[0];
																		$ins_data_expl2=explode(":",$ins_data_expl1[1]);
																		$ins_data_ora=$ins_data_expl2[0];
																		$ins_data_min=$ins_data_expl2[1];
																		$date=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa;
																	} else $date="";

																	// Type of Product
																	$sql7 = "SELECT * FROM db_tch_app ORDER BY nome";
																	$result7=mysqli_query($conn, $sql7);

																	$typeNameStr="";
																	while ($row7=mysqli_fetch_array($result7)) {
																		$id_key = $row7["id_key"];
																		$typeName = $row7["nome"];
																		if (strrpos($videoType,"_".$id_key."_")) {
																			$typeNameStr.=$typeName.", ";
																		}
																	}
																	$typeNameStr=substr($typeNameStr,0,-2);
														
														
																	// Languages
																	$sql7 = "SELECT * FROM VID_lang ORDER BY ord";
																	$result7=mysqli_query($conn,$sql7);

																	$langNameStr="";
																	while ($row7=mysqli_fetch_array($result7)) { 
																		$id_key=$row7["id_key"];
																		$langName=$row7["nome"];
																		if (strrpos($videoLang,"_".$id_key."_")) {
																			$langNameStr.=$langName.", ";
																		}
																	}
																	$langNameStr=substr($langNameStr,0,-2);
																	?>
																		<tr>
																			<td style="width: 225px;font-size: 0.9em;line-height: 1.0em;">
																				<div style="font-size: 1.1em;font-weight: 600;line-height: 1.3em;"><?=nl2br($videoTitle)?></div>
																				<div style="padding-top: 2px;font-size: 0.9em;line-height: 1.3em;"><em><?=$videoAuthor?></em></div>
																				<?php if ($typeNameStr) {?><div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;">Type of Product: <?=$typeNameStr?></div><?php }?>
																				<?php if ($langNameStr) {?><div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;">Languages: <?=$langNameStr?></div><?php }?>
																			</td>
																			<td style="width: 250px;font-size: 0.8em;line-height: 1.0em;">
																				<?php if (file_exists("./data/mathePlatform/SNA/tchMaterials/".$vidId.".".$fileExt)) {?>
																					<em style="display: block;font-style: normal;padding: 0 0 2px 0;">Files:</em>
																					<a href="./data/mathePlatform/SNA/tchMaterials/<?=$vidId?>.<?=$fileExt?>" target="_blank"><?=$fileName?></a><br />
																				<?php }?>
																				<?php if ($videoLink) {?>
																					<em style="display: block;font-style: normal;padding: 5px 0 2px 0;">Useful Links:</em>
																					<?=nl2br(replaceLinks($videoLink))?>
																				<?php }?>
																			</td>
																			<td style="font-size: 0.9em;line-height: 1.0em;">
																				<div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;"><?=$videoDescription?></div>
																			</td>
																		</tr>
																	<?php
																}
															?>
														</tbody>
													</table>
												</div>
												<?php
											}


										}
										?>


										<?php 
									}
									$k+=1;
								}
								?>
								<!-- <div class="signup_submit" style="padding-left: 170px;">
									<input type="submit" name="confirm" value="CONFIRM AND REQUEST EVALUATION" class="proceed" style="width: 350px;margin-left: 15px;padding: 5px;" />
								</div>
							</form> -->



						<?php } else {?>
							<div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
								<p>Here you can perform a self-assessment evaluation about diverse math topics.</p>
								<p style>To make a self-assessment test you need to login:</p>
								<form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0 15px 0;">
									<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 3px;" />
									<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 3px;" />
									<input type="submit" class="submit" value="" style="width: 27px;height: 22px;margin: 0 12px 0 5px;padding: 2px 5px;cursor: pointer;border: solid 1px #777;border-radius: 7;background: url('./impianto/img/icone/ra_submit.png') #f4d19d no-repeat 5px 4px;" />
								</form>
								<p>If you do not have username and password, please <a href="./MP_signIn.php">register to the portal</a>.</p>
							</div>
						<?php }?>

					</div>			
				</div> <!-- page_crp -->
				
				<!-- END contenuto pagina -->
				
				
			</div> <!-- single-content -->
		    </div>
			
			<div class="col-1"></div>
		</div>
	    </div>
	</section>
	</main>
			    
			    
    <!-- Footer page -->
	<?php include('./impianto/piede.php'); //PIEDE?>

    <!-- Back to top -->
    <div id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- JS -->

    <!-- Jquery and Boostrap library -->
    <script src="vendor/bootstrap/js/popper.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="js/theme-map.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.js"></script>
    <script src="js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="vendor/slick/slick.min.js"></script>
    <script src='vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="js/validate-form.js"></script>
    <script src="js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script> 
</body>
</html>
