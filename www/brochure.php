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
                        <h1>Brochure</h1>
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
									<li class="breadcrumb-item">Information & Contacts</li>
								</ul>
							</nav>

                            <article class="item">
                                <h1 class="single-title">
                                     The MathE brochure was made in several language.
                                </h1>

							<br /><br />
				
                                <!-- <div class="info">
                                    <div class="entry">
                                        <span class="categories">
                                            <i class="fas fa-tag"></i>Brochure
                                        </span>
                                    </div>
                                </div> -->
				
                                <div class="blog-content">
                                    <p>
										<a href="./files/brochure/ENG_MathE_FlyerA5.pdf" class="nw"><img src="./impianto/img/brochure.jpg" alt="Brochure MathE" width="400px"></a><br>
                                        <ul style="float: left;width: 400px;margin-top: 75px;font-size: 1.1em;list-style-type: none;">
											<li style="background-position: 0 5px;"><a href="./files/brochure/ENG_MathE_FlyerA5.pdf" class="nw">English Version</a></li>
											<li style="background-position: 0 5px;"><a href="./files/brochure/IT_MathE_FlyerA5.pdf" class="nw">Italian Version</a></li>
											<li style="background-position: 0 5px;"><a href="./files/brochure/LT_MathE_FlyerA5.pdf" class="nw">Lithuanian Version</a></li>
											<li style="background-position: 0 5px;"><a href="./files/brochure/PT_MathE_FlyerA5.pdf" class="nw">Portuguese Version</a></li>
											<li style="background-position: 0 5px;"><a href="./files/brochure/RO_MathE_FlyerA5.pdf" class="nw">Romanian Version</a></li>
										</ul>
                                    </p>
                                </div>
                            </article>
						</div>
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