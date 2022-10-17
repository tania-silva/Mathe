<?php
include('./top.php'); // funzioni PHP
?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">


<?php 

$msg=$_GET["msg"];
$topicGet=Pulisci_INS($_GET["topic"]);
$subTopicGet=Pulisci_INS($_GET["subtopic"]);
$levelGet=Pulisci_INS($_GET["level"]);

if ($_GET["act"]=="reg" AND $usrId) {

	$topic=Pulisci_INS($_POST["topic"]);
	$subTopic=Pulisci_INS($_POST["subtopic"]);
	$level=Pulisci_INS($_POST["level"]);
	$date=Date("Y-m-d H:i:s");

	$where="WHERE (validate=1 AND ";
	if ($topic) $where.="topic=$topic AND ";
	if ($subTopic) $where.="subtopic=$subTopic AND ";
	if ($level) $where.="level='$level' AND ";
	$where=substr($where,0,-5);
	$where.=")";

	//$where="";

	$sql = "
		SELECT * 
		FROM platform__SNA__questions 
		".$where."  
		ORDER BY rand() 
		LIMIT 7";
	$result=mysqli_query($conn,$sql);
	$totale=mysqli_num_rows($result);

	if ($totale>0) {
		$k=1;
		while ($row=mysqli_fetch_array($result)) { 
			${"qst0".$k}=$row["id"];
			$k+=1;
		}

		$sql = "
			INSERT INTO `platform__SNA__assestment` 
			(`id_stud`, `date`, `topic`, `subtopic`, `level`, `qst01`, `qst02`, `qst03`, `qst04`, `qst05`, `qst06`, `qst07`)  
			VALUES ('$usrId', '$date', '$topic', '$subTopic', '$level', '$qst01', '$qst02', '$qst03', '$qst04', '$qst05', '$qst06', '$qst07')";
		$result=mysqli_query($conn,$sql);
		$assId=mysqli_insert_id($conn);

		// Redirect
		$strpas11="./STAS_SNA_quiz.php?assId=".$assId;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		die();
	} else {

		// Redirect
		$strpas11="./STAS_SNA.php?msg=K0&topic=".$topic."&subtopic=".$subTopic."&level=".$level;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		die();
	}

}
?>

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
								This toolkit allows students to carry out a self-evaluation of their knowledge on selected Math topics.
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

						<?php  
							if ($msg=="K0") {

								$topicName="";
								$sql = "
									SELECT * 
									FROM platform__topic 
									WHERE (id=$topicGet AND hidden=0) 
									LIMIT 1";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$topicName=$row["name"];
								}

								$subtopicName="";
								$sql = "
									SELECT * 
									FROM platform__subtopic 
									WHERE (id=$subTopicGet AND id_top=$topicGet AND hidden=0) 
									LIMIT 1";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$subtopicName=$row["name"];
								}

								$area=$topicName;
								if ($subtopicName) $area.=" / ".$subtopicName;

								?>
									<div style="padding:10px;font-size: 1.3em;font-weight: 400;color: #900;text-align: center;">Sorry, but there are not enough questions for the <?=$levelGet?> level in the <?=$area?> area</div>	
								<?php 

							}
						?>

						<?php  if ($_SESSION["guest"]) {?>

							<form method="post" action="./STAS_SNA.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 10px 20px 10px;border: solid 1px #00aeef;border-radius: 10px;">

								<p style="font-size: 1.3em;text-align: center;">To start the assessment please select the topic and the level.<br />The numbers between brackets indicate the number of available questions.</p>
						
								<div class="signup_field_ext">
									<label style="font-weight: 400;color: #c00;">* Topic</label>
									<div style="width: 95%;padding: 10px 0 10px 10px;border: dotted 1px #00aeef;border-radius: 5px;">
										<div id="topic" style="float: left;margin: 1px 0 0 0;">
											<select name="topic" style="float: left;width: 90%;" onchange="subTopic1(this.options[this.selectedIndex].value);" required>
												<option value=""> Select Topic</option>
												<?php 
												$sql = "
													SELECT * 
													FROM platform__topic 
													WHERE hidden=0 
													ORDER BY name ASC";
												$result=mysqli_query($conn,$sql);

												while ($row=mysqli_fetch_array($result)) { 
													$topicId=($row["id"]);
													$topicName=($row["name"]);

													$sql1 = "
														SELECT * 
														FROM platform__SNA__questions 
														WHERE (topic=$topicId AND validate=1)";
													$result1=mysqli_query($conn,$sql1);
													$qstNb=mysqli_num_rows($result1);


													if ($qstNb>0) {
														?><option value="<?=$topicId?>"><?=$topicName?> (<?=$qstNb?>)</option><?php 
													}
												}
												?>
											</select>
										</div>
										<div id="subtopic" style="display: none;width: 50%;margin: 20px 0 0 0;padding: 20px 0 0 0;">
											<!-- SubTopic Area -->
										</div>
										<div class="clear"></div>
									</div>
								</div>
								
								<div class="signup_field_ext">
									<label style="font-weight: 400;color: #c00;">* Level</label>
									<p><input type="radio" name="level" class="radiobutt" value="Basic" style="width: 30px;" checked /><label class="radiobutt">Basic</label></p>
									<p><input type="radio" name="level" class="radiobutt" value="Advanced" style="width: 30px;margin-left: 6%;" /><label class="radiobutt">Advanced</label></p>
									<div class="clear"></div>
								</div>



								<div class="signup_submit" style="width: 100%;">
									<input type="submit" name="start" value="START ASSESSMENT" class="proceed" style="display: block;width: auto;margin: 50px auto 10px auto;;padding: 10px 25px;" />
								</div>


							</form>


						<?php } else {?>
							<style>
								input.submit {
									padding: 1px 15px;
									font-size: 1em;
									font-weight: 400;
									color: #fff;
									text-align: center;

									/* verde */
									border-top: 1px solid #ccc;
									background: #006600;
									background: -webkit-gradient(linear, left top, left bottom, from(#33cc33), to(#006600));
									background: -webkit-linear-gradient(top, #33cc33, #006600);
									background: -moz-linear-gradient(top, #33cc33, #006600);
									background: -ms-linear-gradient(top, #33cc33, #006600);
									background: -o-linear-gradient(top, #33cc33, #006600);

									-webkit-border-radius: 6px;
									-moz-border-radius: 6px;
									border-radius: 6px;
								}

							</style>

							<div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
								<p>Here you can perform a self-assessment evaluation about diverse math topics.</p>
								<p style>To make a self-assessment test you need to login:</p>
								<form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0 15px 0;">
									<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 8px;" />
									<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 8px;" />
									<input type="submit" class="submit" value="Login" style="display: block;width: 250px;margin: 10px auto;" />
								</form>
								<p>If you do not have username and password, please <a href="./MP_signIn.php">register to the portal</a>.</p>
							</div>
							<hr />
							<div style="float: left;width: 450px;margin-right: 100px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div style="float: left;width: 450px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div class="clear"></div>
							<div style="padding-top: 5px;"><a href="./files/MathE_Guidebook.pdf" class="nw"><img src="./impianto/img/pdf1.png" width="50" height="50" border="0" alt="" /></a> For more information, please consult the <a href="./files/MathE_Guidebook.pdf" class="nw">MathE Guidebook</a></div>
							<hr />
							<p style="padding-top: 15px;font-size: 1.2em;">You can do a self-assessment on the following math topics/subtopics:</p>
							<div>
								<ul>
								<?php 
								$sql = "
									SELECT * 
									FROM platform__topic 
									WHERE (hidden=0) 
									ORDER BY name";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$topicId=($row["id"]);
									$topicName=($row["name"]);

									$sql1 = "
										SELECT * 
										FROM platform__SNA__questions 
										WHERE (topic=$topicId AND validate=1)";
									$result1=mysqli_query($conn,$sql1);
									$qstNb=mysqli_num_rows($result1);

									if ($qstNb>0) {
										?><li style="font-size: 1.2em;font-weight: 600;"><?=$topicName?></li><?php 


										$sql3 = "
											SELECT * 
											FROM platform__subtopic 
											WHERE (id_top=$topicId AND hidden=0)";
										$result3=mysqli_query($conn,$sql3);

										while ($row3=mysqli_fetch_array($result3)) { 
											$qstNb2=0;
											$subtopicName="";
											
											$subtopicId=$row3["id"];
											$subtopicName=$row3["name"];
											
											$sql2 = "
												SELECT * 
												FROM platform__SNA__questions 
												WHERE (topic=$topicId AND subtopic=$subtopicId AND validate=1)";
											$result2=mysqli_query($conn,$sql2);
											$qstNb2=mysqli_num_rows($result2);

											if ($subtopicName AND $qstNb2>0) {
												?><li style="font-size: 1.2em;margin-left: 25px;font-style: italic;"><?=$subtopicName?></li><?php 
											}
										}



									}
								}

								?>
								</ul>
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
