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
                        <h1>Project Description</h1>
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
									<li class="breadcrumb-item">Project Management</li>
								</ul>
							</nav>

							<h1 class="single-title">
								  This section presents the main information about the MathE project
							</h1>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Project Description
									</span>
								</div>
							</div> -->
			
							<div class="blog-content">

								<div id="page_crp">
									<div class="txt">

										<div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Context</div>
										<div class="cnt02">Students of scientific and economics subjects at higher education level often lack the basic math skills to effectively follow their lectures</div>
                    <br />

										<div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Objectives</div>
										<div class="cnt02">
											Enhance the quality of teaching and improve pedagogies and assessment methods by:
											<ul>
												<li>Facilitating the identification of students’ gaps in Math</li>
												<li>Providing Math teachers with appropriate digital sources</li>
												<li>Enhancing transnational sharing of innovative teaching sources</li>
											</ul>
										</div>

										<div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Target Groups</div>
										<div class="cnt02">
											The main target groups of the project are:
											<ul>
												<li>Math Lecturers</li>
												<li>Math Students at university level</li>
												<li>Policy Makers in the Field of Education</li>
											</ul>
										</div>

										<div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Activities</div>
										<div class="cnt02">
											The project activities will be organized in the following phases:
											<ul>
												<li><strong>Phase 1 – Students’ Assessment Toolkit</strong></li>
												<li class="indent">This phase is devoted to to identify the areas where the students' maths entry skills need to be improved. It foresees a section for the students to self-assess their knowledge and a section to provide teachers with final tests to assess students’ knowledge</li>
												
												<li><strong>Phase 2 – Online Math Library</strong></li>
												<li class="indent">This phase is dedicated to the creation of a section to offer students and teachers of higher education institutions video based teaching and learning sources to reinforce specific mathematical topics</li>
												
												<li><strong>Phase 3 - Community of Practice</strong></li>
												<li class="indent">This phase is dedicated to the creation of a community of practice allowing Math teachers in higher education institutions to share and compare teaching sources, tools and strategies</li>

												<li><strong>Phase 4 - Testing</strong></li>
												<li class="indent">Each of the deliverables produced will be tested with the representatives of the target groups. The testing phase allows the collection of relevant feedbacks from the end users in order to further improve the deliverables produced and create results that are fully consistent with their needs and expectations.</li>

												<li><strong>Phase 5 - Multiplier events</strong></li>
												<li class="indent">A number of multiplier events will be organized to disseminate the results reached, the methodology implemented and output produced in the MathE project. The participants in the multiplier events will be higher education lecturers and students.</li>
											</ul>
										</div>

										<div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Expected Results</div>
										<div class="cnt02">
											The main project deliverables include:
											<ul>
												<li>Students’ Assessment Toolkit</li>
												<li>Online Math Library of Video Lessons and Educational Material</li>
												<li>Teachers’ and Students’ Community of Practices</li>
											</ul>
										</div>

                    <div style="color: #00aeef; font-size: large"><i class="fas fa-play-circle"></i> Guidebook</div>
                    <div class="cnt02">A <a href="./files/MathE_Guidebook.pdf" class="nw">guidebook to the MathE platform</a> is available in PDF format and presents the entire platform providing the users with
                    <ul>
												<li>YouTube links to tutorial on the use of the different sections of the platform</li>
												<li>Examples of good practices described by lecturers after having used the MathE platform</li>
                    </ul>     
                    

									</div> <!-- txt -->
								</div> <!-- page_crp -->
							</div> <!-- blog-content -->
						</div> <!-- single-content -->
					</div> <!-- col-8 -->
					<div class="col-2"></div>
				
				</div> <!-- row -->
			</div> <!-- container -->
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
