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
                    <h1>Community of Practice</h1>
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
				<li class="breadcrumb-item">Community of Practice</li>
			    </ul>
			</nav>

			<h2 class="single-title">
			    A virtual place to exchange teaching and learning experiences between teachers and students
      
			</h2>
			
			<!--<div class="info">
			    <div class="entry">
				<span class="categories">
				    <i class="fas fa-tag"></i>Community of Practice
				</span>
			    </div>
			</div>-->
			
			<!-- START contenuto pagina -->
			
                        <div id="page_crp">
			    <div class="txt">
          <ul>
          <li> <a href="http://localhost/mathe/teacher-forum/public" target="_new" style="font-size: 1.3em;">Lecturers' Community</a></li> 
          <li> <a href="http://localhost/mathe/student-forum/public" target="_new" style="font-size: 1.3em;">Students' Community</a></li>
          </ul>                                
                                
				<div style="padding: 25px 0;">
				    <h3>MathE Around the World</h3>
				    See how MathE impacs the world. Drag around the map on click on the countries to see how many people are involved.
                                    <?php include("./mapview/map.php") ?>
                                </div>
				
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
