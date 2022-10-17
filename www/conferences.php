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
                        <h1>Conferences</h1>
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
                                    The MathE project was presented in a number of events in order to report about the activities carried out and the results achieved.
                                </h1>

							<br />
				
                                <!-- <div class="info">
                                    <div class="entry">
                                        <span class="categories">
                                            <i class="fas fa-tag"></i>Conferences
                                        </span>
                                    </div>
                                </div> -->

				



								<!-- START contenuto pagina -->
								
								<div id="page_crp">
									<div class="txt">



										<table class="table table-hover" style="margin-top: 45px;">
											<thead>
												<tr style="font-size: 0.9em;background-color: #eee">
													<th class="tdtit" style="width: 60%;">Title of the conference</th>
													<th class="tdtit" style="width: 20%;">Place of the conference</th>
													<th class="tdtit" style="width: 20%;">Date of the conference</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td style="font-size: 1.0em;line-height: 1.1em;"><a href="./CNF_scheda01.php">The 16th International Scientific Conference eLearning and Software for Education</a></td>
													<td>Bucharest, Romania</td>
													<td>30 April – 1 May  2020</td>
												</tr>
												<tr>
													<td style="font-size: 1.0em;line-height: 1.1em;"><a href="./CNF_scheda02.php">BragançaMat 2021 - XXIV Encontro Regional de Educadores e Professores de Matemática (Bragança Conference of Teachers of Mathematics)</a></td>
													<td>Bragança, Portugal (online)</td>
													<td>12 June 2021</td>
												</tr>
												<tr>
													<td style="font-size: 1.0em;line-height: 1.1em;"><a href="./CNF_scheda03.php">OL2A 2021 - International Conference on Optimization, Learning Algorithms and Applications</a></td>
													<td>Bragança, Portugal and online</td>
													<td>20 July 2021</td>
												</tr>
												<tr>
													<td style="font-size: 1.0em;line-height: 1.1em;"><a href="./CNF_scheda04.php">MathE – teaching and learning is attractive! MathE tools and instruments for Math teaching and learning, sharing of good practise</a></td>
													<td>Kaunas, Lithuania</td>
													<td>1 July 2021</td>
												</tr>
												<tr>
													<td style="font-size: 1.0em;line-height: 1.1em;"><a href="./CNF_scheda05.php">MathE Multiplier Event - European Projects in Academia</a></td>
													<td>Iasi, Romania</td>
													<td>15 July 2021</td>
												</tr>
											</tbody>
										</table>
										
										<!-- <div style="padding: 25px 0;font-size: 1.4em;text-align: center;">Sorry<br />No conferences are yet available</div> -->
									
									
									</div>
								</div> <!-- page_crp -->
								
								<!-- END contenuto pagina -->






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