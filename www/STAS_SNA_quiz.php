<?php
include('./top.php'); // funzioni PHP
?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">


<?php 

$assId=$_GET["assId"];
$step=$_GET["step"];
if (!$step) $step=1;

if (
	$_GET["act"]=="reg" AND 
	$step>0 AND 
	$assId AND 
	$usrId) {

	$answer=Pulisci_INS($_POST["answer"]);

	if ($answer) {
		$sql = "
			UPDATE `platform__SNA__assestment` 
			SET 
				qst0{$step}='$answer'
			WHERE id=$assId";
		$result=mysqli_query($conn,$sql);
	}

	$stepNext=$step+1;

	// Redirect
	$strpas11="./STAS_SNA_quiz.php?assId=".$assId."&step=".$stepNext;
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
	die();

} else {

	$sql = "
		SELECT * 
		FROM platform__SNA__assestment 
		WHERE id_stud=$usrId AND id=$assId
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$qstNb="qst0".$step;
		$qstId=$row[$qstNb];
	}

	$QstAr=explode("|",$qstId);
	$qstId=$QstAr[0];
	$ansNb=$QstAr[1];

	if ($qstId) { 

		$sql = "
			SELECT * 
			FROM platform__SNA__questions 
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
			$date=$row["date"];
		}

		$answersAr = array("1||§§".$answer1, "2||§§".$answer2, "3||§§".$answer3, "4||§§".$answer4);
		shuffle($answersAr);

		$attach=0;
		$pict="./data/mathePlatform/SNA/attach/{$qstId}.{$fileExt}";
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
		if ($step==1) $redirectUrl="STAS_SNA.php?msg=K0";
		else $redirectUrl="STAS_SNA_result.php?assId=".$assId;
		
		print "<script language=\"JavaScript\">window.location = '".$redirectUrl."';</script>";
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

							<form method="post" action="./STAS_SNA_quiz.php?assId=<?=$assId?>&step=<?=$step?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 0;border: solid 1px #00aeef;border-radius: 10px;">

								<div>
									<p style="float: left;width: 200px;padding-left: 18px;font-size: 2.6em;font-weight: 400;color: #999;text-align: left;">Question <?=$step?></p>
									<div style="float: right;width: 400px;padding-right: 18px;font-size: 1.0em;color: #999;text-align: right;">
										<p>Topic: <?=$topicName?></p>
										<?php  if ($subtopicName) {?><p>Subtopic: <?=$subtopicName?></p><?php }?>
										<p>Level: <?=$level?></p>
									</div>
								</div>
								<div class="clear"></div>
						
								<div class="signup_field_ext">
									<div class="data" style="margin: 0 30px 0 0;padding: 10px;color: #009;background-color: #edf3fe;border-radius: 5px;">
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
										<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
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


								<div class="signup_submit" style="width: 350px;margin: 50px auto 10px auto;">
									<a href="./STAS_SNA_quiz.php?assId=<?=$assId?>&step=<?=$step?>&act=reg"><button type="button" class="abort" style="width: 150px;padding: 5px;font-size: 12pt;line-height: 1.2;" />skip</button></a>
									<input type="submit" name="confirm" value="CONFIRM" class="proceed" style="width: 150px;margin-left: 15px;padding: 5px;font-size: 12pt;line-height: 1.2;" />
								</div>


							</form>


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
