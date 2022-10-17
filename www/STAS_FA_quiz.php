<?php
include('./top.php'); // funzioni PHP
?>


<?php

$assId=$_GET["assId"];
$step=$_GET["step"];
$rqstId=$_GET["rqstId"];
if (!$step) $step=1;

if (
	$_GET["act"]=="reg" AND 
	$step>0 AND 
	$assId AND 
	$usrId) {

	$answer=Pulisci_INS($_POST["answer"]);
	if (strlen($step)==1) $qstNb="0".$step; else $qstNb=$step;

	if ($answer) {
		$sql = "
			UPDATE `platform__SFA__assanswer` 
			SET 
				qst{$qstNb}='$answer'
			WHERE (id_ass=$assId AND id_stud=$usrId)";
		$result=mysqli_query($conn,$sql);
	}

	$stepNext=$step+1;

		// Redirect
		$redirectUrl="./STAS_FA_quiz.php?assId=".$assId."&step=".$stepNext;
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

} elseif (
	$_GET["act"]=="skip" AND 
	$step>0 AND 
	$assId AND 
	$rqstId AND 
	$usrId) {

	$answer=$rqstId;
	if (strlen($step)==1) $qstNb="0".$step; else $qstNb=$step;

	if ($answer) {
		$sql = "
			UPDATE `platform__SFA__assanswer` 
			SET 
				qst{$qstNb}='$answer'
			WHERE (id_ass=$assId AND id_stud=$usrId)";
		$result=mysqli_query($conn,$sql);
	}

	$stepNext=$step+1;

		// Redirect
		$redirectUrl="./STAS_FA_quiz.php?assId=".$assId."&step=".$stepNext;
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

} else {

	/* Creo il nuovo questionario per questo studente se non già presente */
	$sql = "
		SELECT *
		FROM platform__SFA__assanswer
		WHERE (id_ass=$assId AND id_stud=$usrId)
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	$assCheck=mysqli_num_rows($result);

	if (!$assCheck) {
		$sql = "
		INSERT INTO `platform__SFA__assanswer` 
		(`id_ass`, `id_stud`)  
		VALUES ('$assId', '$usrId')";
		$result=mysqli_query($conn,$sql);
	} else {
		while ($row=mysqli_fetch_array($result)) { 
			$assProtected=$row["protected"];
		}

		if ($assProtected) {

			// Redirect
			$redirectUrl="./STAS_FA.php";
			echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
			die();

		}

	}


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


	/* Ricavo dati del questionario */
	$sql = "
		SELECT * 
		FROM platform__SFA__assestment 
		WHERE id=$assId
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		if (strlen($step)==1) $qstNb="0".$step; else $qstNb=$step;
		$qstNb="qst".$qstNb;
		$qstId=$row[$qstNb];
	}

	$QstAr=explode("|",$qstId);
	$qstId=$QstAr[0];
	$ansNb=$QstAr[1];

	if ($qstId) { 

		$sql = "
			SELECT * 
			FROM platform__SFA__assquestions 
			WHERE id=$qstId
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		
		while ($row=mysqli_fetch_array($result)) { 
			$description=$row["description"];
			$topic=$row["topic"];
			$subtopic=$row["subtopic"];
			$question=$row["question"];
			$level=$row["level"];
			$answer1=$row["answer1"];
			$answer2=$row["answer2"];
			$answer3=$row["answer3"];
			$answer4=$row["answer4"];
			$fileName=$row["file_name"];
			$fileExt=$row["file_ext"];
		}

		$answersAr = array("1||§§".$answer1, "2||§§".$answer2, "3||§§".$answer3, "4||§§".$answer4);
		shuffle($answersAr);

		$attach=0;
		$pict="./data/mathePlatform/SFA/assAttach/{$qstId}.{$fileExt}";
		if (file_exists($pict)) $attach=1;

		$topicName="";
		$sql = "
			SELECT * 
			FROM platform__topic 
			WHERE (id=$topic AND hidden=0) 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$topicName=($row["name"]);
		}

		$subtopicName="";
		$sql = "
			SELECT * 
			FROM platform__subtopic 
			WHERE (id=$subtopic AND id_top=$topic AND hidden=0) 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$subtopicName=($row["name"]);
		}

	} else {
		if ($step==1) $redirectUrl="STAS_FA.php?msg=K0";
		else $redirectUrl="STAS_FA_result.php?assId=".$assId;

		echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
		echo "document.location.href='".$redirectUrl."';";
		echo "</SCRIPT>";

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
							<p><strong>Lecturer:</strong> <?=$lectName?> <?=$lectSurname?></p>
						</div>



						<form method="post" action="./STAS_FA_quiz.php?assId=<?=$assId?>&step=<?=$step?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 0;border: solid 1px #00aeef;border-radius: 10px;">

							<div>
								<p style="float: left;width: 200px;padding-left: 18px;font-size: 2.6em;font-weight: 400;color: #999;text-align: left;">Question <?=$step?></p>
								<div style="float: right;width: 400px;padding-right: 18px;font-size: 1.0em;color: #999;text-align: right;">
									<p style="padding: 0;font-size: 0.9em;line-height: 1.2em;">Topic: <?=$topicName?></p>
									<?php if ($subtopicName) {?><p style="padding: 0;font-size: 0.9em;line-height: 1.2em;">Subtopic: <?=$subtopicName?></p><?php }?>
									<p style="padding: 0;font-size: 0.9em;line-height: 1.2em;">Level: <?=$level?></p>
								</div>
							</div>
							<div class="clear"></div>
					
							<div class="signup_field_ext">
								<div class="data" style="margin: 20px 30px 0 10px;padding: 10px;color: #009;background-color: #edf3fe;border-radius: 5px;">
									<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($question)?></div>
									<?php if ($attach) {?><p style="padding: 10px 0 10px 0;">Attachment: <a href="<?=$pict?>" target="_blank" style="font-size: 1.0em;color: #900;"><?=$fileName?></a></p><?php }?>
								</div>
							</div>

							<div style="margin: 30px 30px 0 18px;padding: 0 0 5px 0;font-size: 1.3em;">
								<p>Choose the right answer or skip to the next question.</p>
							</div>

							<?php
							$k=1;
							foreach ($answersAr as $answer) {
								$AnswerSplit=explode("||§§",$answer);
								$ansNb=$AnswerSplit[0];
								$ansValue=$AnswerSplit[1];
								?>
								<div class="signup_field_ext">
									<p style="font-size: 1.0em;font-weight: 400;"><input type="radio" name="answer" value="<?=$qstId."|".$ansNb?>" style="display: inline;width: 25px;" required />Answer <?=$k?>:</p>
									<div class="data" style="margin: 5px 30px 10px 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
										<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($ansValue)?></div>
									</div>
								</div>
								<?php
								$k+=1;
							}
							?>
							<div class="signup_field_ext">
								<p style="font-size: 1.0em;font-weight: 400;"><input type="radio" name="answer" value="<?=$qstId."|0"?>" style="display: inline;width: 25px;" required />Answer <?=$k?>:</p>
								<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
									<div style="font-size: 1.1em;font-weight: 400;color: #900;line-height: 1.3em;">I DON'T KNOW</div>
								</div>
							</div>


							<div class="signup_submit" style="padding-left: 20%;">
								<a href="./STAS_FA_quiz.php?assId=<?=$assId?>&rqstId=<?=$qstId?>&step=<?=$step?>&act=skip"><button type="button" class="abort" style="padding: 5px 25px;font-size: 1.0em;" />SKIP</button></a>
								<input type="submit" name="confirm" value="CONFIRM" class="proceed" style="margin-left: 15px;padding: 5px 10px;font-size: 1.0em;" />
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
