<?php
include('./top.php'); // funzioni PHP
?>


<?php

$assId=$_GET["assId"];

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
						
						<div style="padding: 50px 0 0 20px;font-size: 1.2em;text-align: center;">
							<p style="font-size: 2.0em;color: #090;">You have completed the assessment</strong></p>
							<p>Tomorrow you can view the result in your reserved area</p>
							<div class="clear"></div>
						</div>


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
