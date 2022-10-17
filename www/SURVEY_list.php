<?php
include('./top.php'); // funzioni PHP
?>


<main>

    <!-- Heading Page -->
    <section class="heading-page">
        <img src="images/bloggrid-heading-bg.jpg" alt="">
        <div class="container">
            <div class="heading-page-content">
                <div class="au-page-title">
                    <h1>Online Evaluation Questionnaires</h1>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- Blog detail -->
    <section class="single section-padding-large">
        <div class="container">
            <div class="row">
		<div class="col-2"></div>
		
                <div class="col-8">
                    <div class="single-content">
			
			<nav aria-label="breadcrumb">
			    <ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item">Online Evaluation Questionnaires</li>
			    </ul>
			</nav>
			
			<!-- START contenuto pagina -->
			
                        <div id="page_crp">
			    <div class="txt">
                                


								<?php if ($_SESSION["usr_level"]>1) {  ?>



<?php

//$check1=$_POST["chk01"];
//
//if (!$check1) {
//
//		//Redirect su messaggio
//		$strpas11="./SURVEY_index.php?msg=KO";
//		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
//
//}

?>

<style>

/* Buttons */

a.bt_css1 {
	width: auto;
	font-size: 1em;
	font-weight: 400;
	color: #fff;
	padding: 5px 15px;
	text-align: center;

	/* rosso
	border-top: 1px solid #c90a0a;
	background: #5b2222;
	background: -webkit-gradient(linear, left top, left bottom, from(#9f2b2b), to(#5b2222));
	background: -webkit-linear-gradient(top, #9f2b2b, #5b2222);
	background: -moz-linear-gradient(top, #9f2b2b, #5b2222);
	background: -ms-linear-gradient(top, #9f2b2b, #5b2222);
	background: -o-linear-gradient(top, #9f2b2b, #5b2222); */

	/* blu
	border-top: 1px solid #0a22c9;
	background: #20215e;
	background: -webkit-gradient(linear, left top, left bottom, from(#2944a0), to(#20215e));
	background: -webkit-linear-gradient(top, #2944a0, #20215e);
	background: -moz-linear-gradient(top, #2944a0, #20215e);
	background: -ms-linear-gradient(top, #2944a0, #20215e);
	background: -o-linear-gradient(top, #2944a0, #20215e); */

	/* verde */
	border-top: 1px solid #ccc;
	background: #095323;
	background: -webkit-gradient(linear, left top, left bottom, from(#10963f), to(#095323));
	background: -webkit-linear-gradient(top, #10963f, #095323);
	background: -moz-linear-gradient(top, #10963f, #095323);
	background: -ms-linear-gradient(top, #10963f, #095323);
	background: -o-linear-gradient(top, #10963f, #095323);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

</style>

<p>
<h4></h4>
<br /><br />
 
<ul>
    <li><strong>Evaluation of the Final Partners' Meeting (online)</strong><br /> <a href="./SURVEY_eval05.php" class="bt_css1">START</a></li><br />
    <li><strong>Evaluation of the Project</strong><br /> <a href="./SURVEY_eval06.php" class="bt_css1">START</a></li><br />
        
</ul>






								<?php } else { ?>
									<?php include('./impianto/inc/sorry.php'); //PIEDE?>
								<?php } ?>

				
			    </div>
			</div> <!-- page_crp -->
			
			<!-- END contenuto pagina -->
			
			
		    </div> <!-- single-content -->
		</div>
		
		<div class="col-2"></div>
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
