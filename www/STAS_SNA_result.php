<?php
include('./top.php'); // funzioni PHP
?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">


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
		
	$sql = "
		UPDATE `platform__SNA__assestment` 
		SET 
			qst01='$qst01', 
			qst02='$qst02', 
			qst03='$qst03', 
			qst04='$qst04', 
			qst05='$qst05', 
			qst06='$qst06', 
			qst07='$qst07' 
		WHERE id=$assId";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$strpas11="./STAS_SNA_result1.php?assId=".$assId;
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

							<form method="post" action="./STAS_SNA_result.php?assId=<?=$assId?>&act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 0;border: solid 1px #00aeef;border-radius: 10px;">


								<div>
									<div style="float: right;width: 400px;padding-right: 18px;font-size: 1.0em;color: #999;text-align: right;">
										<p>Topic: <?=$topicName?></p>
										<?php  if ($subtopicName) {?><p>Subtopic: <?=$subtopicName?></p><?php }?>
										<p>Level: <?=$level?></p>
									</div>
								</div>
								<div class="clear"></div>

								<p style="padding: 20px 20px 0 20px;font-size: 1.2em;">This is the list of the questions together with the answers you chose. <strong>Please check them and decide to confirm or to change the answer.</strong> The questions you skipped do not indicate the answer; in order to proceed, it is necessary to choose an answer. <!-- If you decide not to answer them, they will be considered as wrong answers. --></p>
						
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

										?>
						
										<p style="padding: 30px 0 0 18px;font-size: 1.3em;font-weight: 400;color: #999;text-align: left;">Question <?=$k?></p>
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
											?>
											<div class="signup_field_ext" style="margin-left: 50px;">
												<p style="font-size: 1.0em;font-weight: 400;color: #999;"><input type="radio" name="answer<?=$k?>" value="<?=$qstId."|".$ansNbX?>" style="display: inline;width: 25px;" <?php  if ($ansReg==$ansNbX) echo "checked";?> required />Answer <?=$h?>:</p>
												<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
													<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($ansValueX)?></div>
												</div>
											</div>
											<?php 
											$h+=1;
										}
										?>
										<div class="signup_field_ext" style="margin-left: 50px;">
											<p style="font-size: 1.0em;font-weight: 400;color: #999;"><input type="radio" name="answer<?=$k?>" value="<?=$qstId."|0"?>" style="display: inline;width: 25px;" <?php  if ($ansReg=="0") echo "checked";?> required />Answer <?=$h?>:</p>
											<div class="data" style="margin: 5px 30px 0 25px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;">
												<div style="font-size: 1.1em;font-weight: 400;color: #900;line-height: 1.3em;">I DON'T KNOW</div>
											</div>
										</div>




										<?php 
									}
									$k+=1;
								}
								?>
								<div class="signup_submit" style="width: 100%;">
									<input type="submit" name="confirm" value="CONFIRM AND PROCEED" class="proceed" style="display: block;width: auto;margin: 50px auto 10px auto;padding: 10px 25px;font-size: 1.0em;" />
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
