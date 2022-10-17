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
                                

        <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
        <script src="https://surveyjs.azureedge.net/1.1.32/survey.ko.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
        <!-- Uncomment to enable Select2 <script src="https://unpkg.com/jquery"></script> <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
        <link href="https://surveyjs.azureedge.net/1.1.32/survey-creator.css" type="text/css" rel="stylesheet"/>
        <script src="https://surveyjs.azureedge.net/1.1.32/survey-creator.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@3.3.7/dist/css/bootstrap.min.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		
		<link href="https://surveyjs.azureedge.net/1.1.32/survey.css" type="text/css" rel="stylesheet" />
		<link href="./css/survey.css" type="text/css" rel="stylesheet"/>


						<div id="surveyContainer"></div>

				
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


	<script src="https://surveyjs.azureedge.net/1.1.32/survey.jquery.min.js"></script>

	<script>

		var surveyJSON = { surveyId: '57cfc054-eac9-4bcd-81cb-64c02472692b'}

		function sendDataToServer(survey) {
			survey.sendResult('0d3b9928-18b9-4255-88ac-a5c65f557498');
		}

		var survey = new Survey.Model(surveyJSON);
		$("#surveyContainer").Survey({
			model: survey,
			onComplete: sendDataToServer
		});
	</script>


</body>
</html>
