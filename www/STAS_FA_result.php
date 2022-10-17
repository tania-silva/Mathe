<?php
include('./top.php'); // funzioni PHP
?>


<?php

$assId=$_GET["assId"];
$act=$_GET["act"];

if ($act=="reg") {

	$qst01=$_POST["answer1"];
	$qst02=$_POST["answer2"];
	$qst03=$_POST["answer3"];
	$qst04=$_POST["answer4"];
	$qst05=$_POST["answer5"];
	$qst06=$_POST["answer6"];
	$qst07=$_POST["answer7"];
	$qst08=$_POST["answer8"];
	$qst09=$_POST["answer9"];
	$qst10=$_POST["answer10"];
	$qst11=$_POST["answer11"];
	$qst12=$_POST["answer12"];
	$qst13=$_POST["answer13"];
	$qst14=$_POST["answer14"];
	$qst15=$_POST["answer15"];
	$qst16=$_POST["answer16"];
	$qst17=$_POST["answer17"];
	$qst18=$_POST["answer18"];
	$qst19=$_POST["answer19"];
	$qst20=$_POST["answer20"];
		
	$sql = "
		UPDATE `platform__SFA__assanswer` 
		SET 
			qst01='$qst01', 
			qst02='$qst02', 
			qst03='$qst03', 
			qst04='$qst04', 
			qst05='$qst05', 
			qst06='$qst06', 
			qst07='$qst07',  
			qst08='$qst08',  
			qst09='$qst09',  
			qst10='$qst10',  
			qst11='$qst11',  
			qst12='$qst12',  
			qst13='$qst13',  
			qst14='$qst14',  
			qst15='$qst15',  
			qst16='$qst16',  
			qst17='$qst17',  
			qst18='$qst18',  
			qst19='$qst19',  
			qst20='$qst20'  
		WHERE (id_stud=$usrId AND id_ass=$assId)";
	$result=mysqli_query($conn,$sql);


	/* Calcolo il punteggio e proteggo il questionario da ulteriori modifiche */
	$sql = "
		SELECT * 
		FROM platform__SFA__assanswer 
		WHERE id_stud=$usrId AND id_ass=$assId
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$qst01=$row["qst01"];
		$qst02=$row["qst02"];
		$qst03=$row["qst03"];
		$qst04=$row["qst04"];
		$qst05=$row["qst05"];
		$qst06=$row["qst06"];
		$qst07=$row["qst07"];
		$qst08=$row["qst08"];
		$qst09=$row["qst09"];
		$qst10=$row["qst10"];
		$qst11=$row["qst11"];
		$qst12=$row["qst12"];
		$qst13=$row["qst13"];
		$qst14=$row["qst14"];
		$qst15=$row["qst15"];
		$qst16=$row["qst16"];
		$qst17=$row["qst17"];
		$qst18=$row["qst18"];
		$qst19=$row["qst19"];
		$qst20=$row["qst20"];
	}

	$qstAr = array($qst01, $qst02, $qst03, $qst04, $qst05, $qst06, $qst07, $qst08, $qst09, $qst10, $qst11, $qst12, $qst13, $qst14, $qst15, $qst16, $qst17, $qst18, $qst19, $qst20);

	$assResult=0;
	$assTotal=0;
	foreach ($qstAr as $question) {
		$questionSplit=explode("|",$question);
		$qstIdcicl=$questionSplit[0];
		$ansNb=$questionSplit[1];

		$point=0;
		$sql = "
			SELECT * 
			FROM platform__SFA__assquestions 
			WHERE (id=$qstIdcicl AND id_ass=$assId)
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$point=$row["point"];
		}


		if ($qstIdcicl) $qstNb+=1;
		if ($ansNb==1) $assResult+=$point;
		$assTotal+=$point;
	}

	$finalResult=$assResult."/".$assTotal;

	$endTime = date_create(Date("Y-m-d H:i:s"), timezone_open($uniTimezone));
	date_timezone_set($endTime, timezone_open('UTC'));
	$endTimeUTC=$endTime->format('Y-m-d H:i:s');
		
	$sql = "
		UPDATE `platform__SFA__assanswer` 
		SET 
			totpoint='$finalResult', 
			protected=1, 
			endtime='$endTimeUTC'
		WHERE (id_stud=$usrId AND id_ass=$assId)";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./STAS_FA_result1.php?assId=".$assId;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {

	/* Ricavo dati dell'assessment */
	$sql = "
		SELECT *, k.name AS lectName, k.surname AS lectSurname
		FROM platform__SFA__assestment as p 
		LEFT JOIN platform__lecturers as q 
			ON p.id_lect=q.id_lect
		LEFT JOIN platform__user as k 
			ON k.id=q.id_lect
		WHERE (p.id=$assId AND p.status=1) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$titleSFA=$row["title"];
		$description=$row["description"];
		$FA_date=$row["FA_date"];
		$duration=$row["duration"];
		$status=$row["status"];
		$lectName=$row["lectName"];
		$lectSurname=$row["lectSurname"];
	
		$FA_date=Date("Y-m-d H:i:s",strtotime($FA_date));
		$date = date_create($FA_date, timezone_open('UTC'));
		$Dt1=$date->format('Y-m-d H:i:s');
		date_timezone_set($date, timezone_open($uniTimezone));
		$FA_date=$date->format('Y-m-d H:i:s');
		
		if ($FA_date!="" AND $FA_date!="0000-00-00 00:00:00") {
			$ins_data_expl=explode("-",$FA_date);
			$ins_data_aa=$ins_data_expl[0];
			$ins_data_mm=$ins_data_expl[1];
			$ins_data_expl1=explode(" ",$ins_data_expl[2]);
			$ins_data_gg=$ins_data_expl1[0];
			$ins_data_expl2=explode(":",$ins_data_expl1[1]);
			$ins_data_ora=$ins_data_expl2[0];
			$ins_data_min=$ins_data_expl2[1];
			$FA_date="<strong>".$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa."</strong> h. ".$ins_data_ora.":".$ins_data_min;
		} else $FA_date="";
	}

	$sql = "
		SELECT * 
		FROM platform__SFA__assanswer 
		WHERE (id_stud=$usrId AND id_ass=$assId)
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$qst01=$row["qst01"];
		$qst02=$row["qst02"];
		$qst03=$row["qst03"];
		$qst04=$row["qst04"];
		$qst05=$row["qst05"];
		$qst06=$row["qst06"];
		$qst07=$row["qst07"];
		$qst08=$row["qst08"];
		$qst09=$row["qst09"];
		$qst10=$row["qst10"];
		$qst11=$row["qst11"];
		$qst12=$row["qst12"];
		$qst13=$row["qst13"];
		$qst14=$row["qst14"];
		$qst15=$row["qst15"];
		$qst16=$row["qst16"];
		$qst17=$row["qst17"];
		$qst18=$row["qst18"];
		$qst19=$row["qst19"];
		$qst20=$row["qst20"];
		$assProtected=$row["protected"];
	}

	$qstAr = array($qst01, $qst02, $qst03, $qst04, $qst05, $qst06, $qst07, $qst08, $qst09, $qst10, $qst11, $qst12, $qst13, $qst14, $qst15, $qst16, $qst17, $qst18, $qst19, $qst20);

	if ($assProtected) {

		// Redirect
		$redirectUrl="./STAS_FA.php";
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();
	}


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
<style>
div.signup_submit button.abort {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* rosso */
	border-top: 1px solid #ccc;
	background: #d22d39;
	background: -webkit-gradient(linear, left top, left bottom, from(#fb040b), to(#c20338));
	background: -webkit-linear-gradient(top, #fb040b, #c20338);
	background: -moz-linear-gradient(top, #fb040b, #c20338);
	background: -ms-linear-gradient(top, #fb040b, #c20338);
	background: -o-linear-gradient(top, #fb040b, #c20338);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}
div.signup_submit input.proceed {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* verde */
	border-top: 1px solid #ccc;
	background: #1d6d18;
	background: -webkit-gradient(linear, left top, left bottom, from(#69c22e), to(#387016));
	background: -webkit-linear-gradient(top, #69c22e, #387016);
	background: -moz-linear-gradient(top, #69c22e, #387016);
	background: -ms-linear-gradient(top, #69c22e, #387016);
	background: -o-linear-gradient(top, #69c22e, #387016);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

</style>

	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Final Assessment</h1>
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
				
							<!-- <h2 class="single-title">
								This toolkit allows teachers to elaborate Final Assessments for their students on the topics they wish to evaluate. Students can apply when a Final Assessment is available for a course they attend. In order to see the list of the available final assessments, please log in. 
							</h2>
			
							<div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Ask to partecipate
									</span>
								</div>
							</div> -->
				
				<!-- START contenuto pagina -->
				
                                <div id="page_crp">

					<?php if ($_SESSION["guest"]) {?>


						<div style="margin: 0 0;padding: 10px;background-color: #e1f8ff;border-radius: 10px;">
							<p style="padding: 0;font-size: 1.2em;font-weight: 600;"><strong><?=nl2br($titleSFA)?></strong></p>
							<p style="padding: 0 0 10px 0;font-size: 1.0em;font-weight: 200;font-style: italic;line-height: 1.2em;"><em><?=nl2br($description)?></em></p>
							<p><strong>Date and Time:</strong> <?=$FA_date?></p>
							<p><strong>Duration:</strong> <?=$duration?> minutes</p>
						</div>

						<form method="post" action="./STAS_FA_result.php?assId=<?=$assId?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 0;border: solid 1px #00aeef;border-radius: 10px;">

							<p style="padding: 20px 10px 0 10px;font-size: 1.2em;">This is the list of the questions together with the answers you chose. <strong>Please check them and decide to confirm or to change the answer.</strong> The questions you skipped do not indicate the answer; in order to proceed, it is necessary to choose an answer. <!-- If you decide not to answer them, they will be considered as wrong answers. --></p>
					
							<?php
							$k=1;
							foreach ($qstAr as $question) {
								$questionSplit=explode("|",$question);
								$qstId=$questionSplit[0];
								$ansNb=$questionSplit[1];

								if ($qstId) { 

									$sql = "
										SELECT * 
										FROM platform__SFA__assquestions 
										WHERE id=$qstId
										LIMIT 1";
									$result=mysqli_query($conn,$sql);
									
									while ($row=mysqli_fetch_array($result)) { 
										$description=$row["description"];
										$questionX=$row["question"];
										$answer1X=$row["answer1"];
										$answer2X=$row["answer2"];
										$answer3X=$row["answer3"];
										$answer4X=$row["answer4"];
										$fileNameX=$row["file_name"];
										$fileExtX=$row["file_ext"];
									}

									$answersArX = array("1||§§".$answer1X, "2||§§".$answer2X, "3||§§".$answer3X, "4||§§".$answer4X);
									shuffle($answersArX);

									$attachX=0;
									$pictX="./data/mathePlatform/SFA/assAttach/{$qstId}.{$fileExtX}";
									if (file_exists($pictX)) $attachX=1;

									$qstArray=$qstAr[$k-1];
									$ansRegAr=explode("|", $qstArray);
									$ansReg=$ansRegAr[1];

									?>
					
									<p style="padding: 30px 0 0 18px;font-size: 1.3em;font-weight: 400;color: #999;text-align: left;">Question <?=$k?></p>
									<div class="signup_field_ext">
										<div class="data" style="margin: 0 30px 10px 10px;padding: 10px;color: #009;background-color: #edf3fe;border-radius: 5px;">
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
										?>
										<div class="signup_field_ext" style="margin: 0 0 10px 20px;">
											<p style="font-size: 1.0em;font-weight: 400;color: #999;"><input type="radio" name="answer<?=$k?>" value="<?=$qstId."|".$ansNbX?>" style="display: inline;width: 25px;" <?php if ($ansReg==$ansNbX) echo "checked";?> required />Answer <?=$h?>:</p>
											<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
												<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($ansValueX)?></div>
											</div>
										</div>
										<?php
										$h+=1;
									}
									?>
									<div class="signup_field_ext" style="margin-left: 20px;">
										<p style="font-size: 1.0em;font-weight: 400;color: #999;"><input type="radio" name="answer<?=$k?>" value="<?=$qstId."|0"?>" style="display: inline;width: 25px;" <?php if ($ansReg=="0") echo "checked";?> required />Answer <?=$h?>:</p>
										<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
											<div style="font-size: 1.1em;font-weight: 400;color: #900;line-height: 1.3em;">I DON'T KNOW</div>
										</div>
									</div>




									<?php
								}
								$k+=1;
							}
							?>
							<div class="signup_submit" style="padding-left: 20%;">
								<input type="submit" name="confirm" value="CONFIRM AND SUBMIT" class="proceed" style="margin-left: 15px;padding: 5px 10px;font-size: 0.9em;" />
							</div>
						</form>



					<?php } else {?>
						<div class="txt">
							<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Sorry</div>
							<div class="cnt02">This page is protected. Please login.</div>
						</div>
					<?php }?>

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
