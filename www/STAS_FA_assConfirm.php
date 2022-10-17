<?php
include('./top.php'); // funzioni PHP
?>


<?php

$assId=$_GET["assId"];

$act=$_GET["act"];

if ($act=="subscribe" AND $assId AND $usrId) {
	
	$sql = "
		INSERT INTO `platform__SFA__subscription` 
		(`id_ass`, `id_stud`)  
		VALUES ('$assId', '$usrId')";
	$result=mysqli_query($conn,$sql);
	$assId=mysqli_insert_id($conn);

	if ($assId) {

		// Redirect
		$redirectUrl="./STAS_FA_assConfirm.php?msg=OK";
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

	} else {

		// Redirect
		$redirectUrl="./STAS_FA_assConfirm.php?msg=KO";
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

	}

} else {

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
		$dateCrf=Date("Y-m-d",strtotime($FA_date));
		
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
}
?>
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
div.signup_submit button.proceed {
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
							</h2> -->
			
							<div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Ask to partecipate
									</span>
								</div>
							</div>
				
				<!-- START contenuto pagina -->
				
                                <div id="page_crp">

					<?php if ($_SESSION["guest"]) {?>


						<?php if ($_GET["msg"]=="KO") {?>
							<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
								<p>Sorry but something went wrong. Please repeat the operation.</p>
							</div>
						<?php } elseif ($_GET["msg"]=="OK") {?>
							<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #090;text-align: center;border: solid 1px #090;border-radius: 5px;">
								<p>Thank you, <?=$usr_name?>.</p>
								<p>The lecturer will take care of your request</p>
							</div>

						<?php } else {?>

							<div class="el_msg" style="padding: 10px;border: solid 1px #00AEEF;border-radius: 5px;">
								<p class="p01" style="margin: 0;padding: 0;text-align: center;">Do you want to subscribe to this assessment?</p>

								<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Lecturer:</p>
								<p style="font-size: 1.3em;font-weight: 200;"><?=$lectName?> <?=$lectSurname?></p>

								<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Title:</p>
								<p style="font-size: 1.3em;font-weight: 200;"><?=nl2br($titleSFA)?></p>

								<?php if ($description) {?>
									<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Description:</p>
									<p style="font-size: 0.9em;font-weight: 200;"><?=nl2br($description)?></p>
								<?php }?>

								<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Date:</p>
								<p style="font-size: 1.2em;font-weight: 200;"><?=$FA_date?></p>

								<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Duration:</p>
								<p style="font-size: 1.2em;font-weight: 200;"><?=$duration?> minutes</p>


								<div class="signup_submit" style="padding-left: 20%;">
									<a href="./STAS_FA.php"><button type="button" class="abort" style="padding: 5px 25px;" />Exit</button></a>
									<a href="./STAS_FA_assConfirm.php?assId=<?=$assId?>&act=subscribe"><button type="button" class="proceed" style="margin-left: 10px;padding: 5px;" />Confirm</button></a>
								</div>
							</div>

						<?php }?>

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
