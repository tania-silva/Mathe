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
                        <h1>Download Area</h1>
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
								 This section provides the access to all the documents for the project management and for the carrying out of the activities.
							</h1>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Download Area
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">
					
								<?php  if ($_SESSION["usr_level"]>1 OR $_SESSION["id_partner"]==9 OR $usrId==586 OR $usrId==26) {  ?>

						
<style>
.p01c {
	margin: 0 0 10px 0;
	padding: 15px 0 0 0;
	font-size: 1.2em;
	font-weight: 600;
	border-bottom: solid 1px #00aeef;
}
</style>

									<div class="txt">
										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('wp1');">Templates and tools for carrying out the project activities</a></strong></div>
										<div id="wp1" style="margin-left: 20px;display: none;">
											
											<p><strong>IO1 Student Assessment Toolkit</strong></p>
											<ul>
												<li>IO1.A – Assessment Tools [<a href="./files/download/templates/IO1.A - Assessment Tools.docx" class="nw">DOC</a>]</li>
												<li>IO1.B Guideline Final Assessement.docx  [<a href="./files/download/templates/IO1.B Guideline Final Assessement.docx" class="nw">DOCX</a>]</li>
											</ul>
											
											<p><strong>IO2 Math Library</strong></p>
											<ul>
												<li>IO2.A – Existing Video Review [<a href="./files/download/templates/IO2.A - Review of Existing Video Lessons.docx" class="nw">DOCX</a>]</li>
												<li>IO2.B – Video Lessons [<a href="./files/download/templates/IO2.B - Video lessons.docx" class="nw">DOCX</a>]</li>
												<li>IO2.C - Video_Begin [<a href="./files/download/templates/IO2.C - Video_Begin.mp4" class="nw">MP4</a>]</li>
												<li>IO2.D - Video_End [<a href="./files/download/templates/IO2.D - Video_End.mp4" class="nw">MP4</a>]</li>
												<li>IO2.E – Guidelines for YouTube Channel [<a href="./files/download/templates/IO2.E – Guidelines for YouTube Channel.docx" class="nw">DOCX</a>]</li>
												<li>IO2.F – Teaching Material [<a href="./files/download/templates/IO2.F - Teaching Material.docx" class="nw">DOCX</a>]</li>
												<!-- <li>IO2.G – Teaching material review [<a href="./files/download/templates/xxx.docx" class="nw">DOC</a>]</li> -->
											</ul>
											
											<p><strong>IO3 Community of Practice</strong></p>
											<ul>
												<li>IO3.A - Community of Practice Guideline [<a href="./files/download/templates/IO3.A - Community of Practice Guideline.docx" class="nw">DOC</a>]</li> 
												<li>IO3.B - Admins Community of Practice Guideline.docx  [<a href="./files/download/templates/IO3.B - Admins Community of Practice Guideline.docx" class="nw">DOC</a>]</li> 
												<!-- <li>IO3.C – Good Practice Form [<a href="./files/download/templates/xxx.docx" class="nw">DOC</a>]</li> -->
											</ul>

											<p><strong>PM1 - Project Management</strong></p>
											<ul>
												<li>PM1.A – Student Information  [<a href="./files/download/templates/PM1.A – Student Information.docx" class="nw">DOC</a>]</li>
												<li>PM1.B – Lecturer Information [<a href="./files/download/templates/PM1.B – Lecturer Information.docx" class="nw">DOC</a>]</li>
												<li>PM1.C – Role of the target groups [<a href="./files/download/templates/PM1.C - Role of the Target Groups.docx" class="nw">DOC</a>]</li>
												<li>PM1.D – In progress activities reports     [<a href="./rsv_pm_wip.php">LINK</a>]</li>
												<li>PM1.E – Financial Manual [<a href="./files/download/templates/PM1.E – Financial Manual.pdf" class="nw">PDF</a>]</li>
												<li>PM1.F – Financial Forms [<a href="./files/download/templates/PM1.F – Financial Forms.rar" class="nw">RAR</a>]</li>
												<li>PM1.G – Template of Mobility Declaration [<a href="./files/download/templates/PM1.G - Template of Mobility Declaration.docx" class="nw">DOC</a>]</li>
											</ul>
											
											<p><strong>PM2 - Dissemination</strong></p>
											<ul>
												<li>PM2.A – In Progress Dissemination Reports   [<a href="./rsv_pm_diss.php">LINK</a>]</li>
												<li>PM2.B – How to Write the Best Practice Dissemination Report  [<a href="./files/download/templates/PM2.B - How to Write the Best Practice Dissemination Report.docx" class="nw">DOC</a>]</li>
											</ul>
											
											<p><strong>PM3 - Exploitation</strong></p>
											<ul>
												<li>PM3.A – Associated Partner Letter  [<a href="./files/download/templates/PM3.A - Associated Partner Letter.docx" class="nw">DOC</a>]</li>
												<li>PM3.B – Associated Partner Information [<a href="./files/download/templates/PM3.B - Associated Partner Information.docx" class="nw">DOC</a>]</li>
												<li>PM3.C – Exploitation Links  [<a href="./files/download/templates/PM3.C - Exploitation Links.docx" class="nw">DOC</a>]</li>
											</ul>
											
											<p><strong>PM4 Quality and Monitoring Plan</strong></p>
											<ul>
												<li>PM4.A – Quality Plan  [<a href="./files/download/templates/PM4.A - Quality Plan.docx" class="nw">DOC</a>]</li>
												<!-- <li>PM4.B – Meeting Evaluation Questionnaire  [<a href="./files/download/templates/xxx.docx" class="nw">DOC</a>]</li> -->
												<li>PM4.D – Project Evaluation Questionnaire  [<a href="./files/download/templates/PM4.D – End Users’ Evaluation Questionnaires.docx" class="nw">DOC</a>]</li>
												<!-- <li>PM4.D – Evaluation Questionnaires for Intellectual Outputs   [<a href="./files/download/templates/xxx.docx" class="nw">DOC</a>]</li> -->
												<li>PM4.E – Tool for questionnaires analysis  [<a href="./files/download/templates/PM4.E – Tool for questionnaires analysis.xlsx" class="nw">XLS</a>]</li>
												<li>PM4.F – Guidelines for the evaluation report on testing activity   [<a href="./files/download/templates/PM4.F – Guidelines for the evaluation report on testing activity.docx" class="nw">DOC</a>]</li>
											</ul>
											
											<p><strong>Multiplier Events</strong></p>
											<ul>
												<li>ME.1 – Multiplier Event Description  [<a href="./files/download/templates/ME.1 – Multiplier Event Description.docx" class="nw">DOC</a>]</li>
												<li>ME.2 – Multiplier Event Programme  [<a href="./files/download/templates/ME.2 – Multiplier Event Programme.docx" class="nw">DOC</a>]</li>
												<li>ME.3 – Multiplier Event List of Participants  [<a href="./files/download/templates/ME.3 – Multiplier Event List of Participants.docx" class="nw">DOC</a>]</li>
												<li>ME.4 – Multiplier Event Minutes  [<a href="./files/download/templates/ME.4 – Multiplier Event Minutes.docx" class="nw">DOC</a>]</li>
                        <li>ME.5 – Virtual Multiplier Event Declaration  [<a href="./files/download/templates/ME.5 - Virtual Multiplier Event Declaration.docx" class="nw">DOC</a>]</li>
											</ul>
											
											<p><strong>Training Activity</strong></p>
											<ul>
												<li>TA.1 – Register  [<a href="./files/download/templates/TA.1 - Training Activity Register.docx" class="nw">DOC</a>]</li>
												<li>TA.2 – Programme   [<a href="./files/download/templates/TA.2 - Programme Template.docx" class="nw">DOC</a>]</li>
												<li>TA.3 – Certificate  [<a href="./files/download/templates/TA.3 - Training Activity Certificate.docx" class="nw">DOC</a>]</li>
												<li>TA.4 – Contents for the Mobility Europass  [<a href="./files/download/templates/TA.4 – Contents for the Mobility Europass.docx" class="nw">DOC</a>]</li>
												<li>TA.5 – Participants Profile  [<a href="./files/download/templates/TA.5 – Participants Profiles.docx" class="nw">DOC</a>]</li>
												<li>TA.6 – Report  [<a href="./files/download/templates/TA.6 – Report.docx" class="nw">DOC</a>]</li>
                        <li>TA.7 – Training Activity Declaration [<a href="./files/download/templates/TA.7 - Training Activity Declaration.docx" class="nw">DOC</a>]</li>
											</ul>
											
										</div>
											
										
										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('wp6');">Visual Identity</a></strong></div>
										<div id="wp6" style="margin-left: 20px;display: none;">
											<ul>
												<!-- <li>Erasmus+ logo with Disclaimer  [<a href="./files/download/visualid/Erasmus+ logo with Disclaimer.png" class="nw">PNG</a>]</li> -->
												<li>Project headpaper letter  [<a href="./files/download/visualid/Headpaper letter.docx" class="nw">DOC</a>]</li>
												<li>Project logo   [<a href="./files/download/visualid/Project Logo.jpg" class="nw">JPG</a>]</li>
												<!-- <li>Project brochure   [<a href="./files/download/visualid/Off-Book Brochure.pdf" class="nw">PDF</a>]</li> -->
											</ul>
										</div>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('first');">First Meeting – Florence (IT), 29 – 30 October 2018</a></strong></div>
										<ul id="first" style="display: none;">
											<li>_First meeting minutes [<a href="./files/download/meet01/_First meeting minutes.docx" class="nw">DOC</a>]</li>
											<li>Annex 1 - Project presentation [<a href="./files/download/meet01/Annex 1 - Project presentation.ppt" class="nw">PPT</a>]</li>
											<li>Annex 2 - Calendar of activities [<a href="./files/download/meet01/Annex 2 - Calendar of activities.doc" class="nw">DOC</a>]</li>
											<li>Annex 3 - Calendar of deadlines [<a href="./files/download/meet01/Annex 3 - Calendar of deadlines.docx" class="nw">DOC</a>]</li>
											<li>Annex 4 - PM1.A – Student Information [<a href="./files/download/meet01/Annex 4 - PM1.A – Student Information.docx" class="nw">DOC</a>]</li>
											<li>Annex 5 - PM1.B – Lecturer Information [<a href="./files/download/meet01/Annex 5 - PM1.B – Lecturer Information.docx" class="nw">DOC</a>]</li>
											<li>Annex 6 - PM1.C - Role of the Target Groups [<a href="./files/download/meet01/Annex 6 - PM1.C - Role of the Target Groups.docx" class="nw">DOC</a>]</li>
											<li>Annex 7 - IO1.A - Assessment Tools [<a href="./files/download/meet01/Annex 7 - IO1.A - Assessment Tools.docx" class="nw">DOC</a>]</li>
											<li>Annex 8 - IE_LIT [<a href="./files/download/meet01/Annex 8 - IE_LIT.pptx" class="nw">PPT</a>]</li>
											<li>Annex 9 -PT_IPB [<a href="./files/download/meet01/Annex 9 -PT_IPB.pptx" class="nw">PPT</a>]</li>
											<li>Annex 10 -RO_EuroEd [<a href="./files/download/meet01/Annex 10 -RO_EuroEd.ppt" class="nw">PPT</a>]</li>
											<li>Annex 11 -RO_TUIASI [<a href="./files/download/meet01/Annex 11 -RO_TUIASI.pptx" class="nw">PPT</a>]</li>
											<li>Annex 13 - Partners' Role_EuroEd [<a href="./files/download/meet01/Annex 13 - Partners' Role_EuroEd.docx" class="nw">DOC</a>]</li>
											<li>Annex 14 - Partners' Role_IPB [<a href="./files/download/meet01/Annex 14 - Partners' Role_IPB.docx" class="nw">DOC</a>]</li>
											<li>Annex 15 - Partners' Role_KTU [<a href="./files/download/meet01/Annex 15 - Partners' Role_KTU.docx" class="nw">DOC</a>]</li>
											<li>Annex 16 - Partners' Role_LIT [<a href="./files/download/meet01/Annex 16 - Partners' Role_LIT.docx" class="nw">DOC</a>]</li>
											<li>Annex 17 - Partners' Role_Pixel [<a href="./files/download/meet01/Annex 17 - Partners' Role_Pixel.docx" class="nw">DOC</a>]</li>
											<li>Annex 18 - Partners' Role_TUIasi [<a href="./files/download/meet01/Annex 18 - Partners' Role_TUIasi.docx" class="nw">DOC</a>]</li>
											<li>Annex 19 - Partners' Role_UniGenova [<a href="./files/download/meet01/Annex 19 - Partners' Role_UniGenova.docx" class="nw">DOC</a>]</li>
										</ul>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('second');">Second Meeting – Kaunas (LT), 23 – 24 May 2019</a></strong></div>
										<ul id="second" style="display: none;">
											<li>Second meeting minutes [<a href="./files/download/meet02/_Second meeting minutes.docx" class="nw">DOCX</a>]</li>
											<li>Annex 1 - Project presentation [<a href="./files/download/meet02/Annex 1 - Project presentation.ppt" class="nw">PPT</a>]</li>
											<li>Annex 2 - Calendar of deadlines [<a href="./files/download/meet02/Annex 2 - Calendar of deadlines.docx" class="nw">DOCX</a>]</li>
											<li>Annex 3 - IO2.A - Review of Existing Video Lessons [<a href="./files/download/meet02/Annex 3 - IO2.A - Review of Existing Video Lessons.docx" class="nw">DOCX</a>]</li>
											<li>Annex 4 - IO2.B - Video lessons [<a href="./files/download/meet02/Annex 4 - IO2.B - Video lessons.docx" class="nw">DOCX</a>]</li>
										</ul>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('third');">Third Meeting – Limerick (IE), 2 – 3 December 2019</a></strong></div>
										<ul id="third" style="display: none;">
											<li>_Third meeting minutes [<a href="./files/download/meet03/_Third meeting minutes.docx" class="nw">DOCX</a>]</li>
											<li>Annex 1 - Project presentation [<a href="./files/download/meet03/Annex 1 - Project presentation.ppt" class="nw">PPT</a>]</li>
											<li>Annex 2 - Community of Practice [<a href="./files/download/meet03/Annex 2 - Community of Practice.ppt" class="nw">PPT</a>]</li>
											<li>Annex 3 - Calendar of deadlines [<a href="./files/download/meet03/Annex 3 - Calendar of deadlines.docx" class="nw">DOCX</a>]</li>
											<li>Annex 4 - IO2.F - Teaching Material [<a href="./files/download/meet03/Annex 4 - IO2.F - Teaching Material.docx" class="nw">DOCX</a>]</li>
										</ul>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('fourth');">Fourth Meeting – Online, 25 June 2020</a></strong></div>
										<ul id="fourth" style="display: none;">
											<li>_Fourth meeting minutes [<a href="./files/download/meet04/_Fourth meeting minutes.docx" class="nw">DOCX</a>]</li>
											<li>Annex 1 - Project presentation [<a href="./files/download/meet04/Annex 1 - Project presentation.ppt" class="nw">PPT</a>]</li>
											<li>Annex 2 - Calendar of deadlines [<a href="./files/download/meet04/Annex 2 - Calendar of deadlines.docx" class="nw">DOCX</a>]</li>
										</ul>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('fifth');">Fifth Meeting – Online, 21 December 2020</a></strong></div>
										<ul id="fifth" style="display: none;">
											<li>_Fifth meeting minutes [<a href="./files/download/meet05/_Fifth meeting minutes.docx" class="nw">DOCX</a>]</li>
											<li>Annex 1 - Project presentation [<a href="./files/download/meet05/Annex 1 - Project presentation.ppt" class="nw">PPT</a>]</li>
											<li>Annex 2 - Calendar of deadlines [<a href="./files/download/meet05/Annex 2 - Calendar of deadlines.docx" class="nw">DOCX</a>]</li>
										</ul>

										<div class="p01c"><img class="pt2" src="./wiztr.gif" alt="" /><strong><a href="javascript: void(0);" onclick="javascript: shid('sixth');">Sixth Meeting – Online, 23 June 2021</a></strong></div>
										<ul id="sixth" style="display: none;">
											<li>_Sixth meeting minutes [<a href="./files/download/meet06/_Sixth meeting minutes.docx" class="nw">DOCX</a>]</li>
											<li>Annex 01 - Project presentation [<a href="./files/download/meet06/Annex 01 - Project presentation.pptx" class="nw">PPT</a>]</li>
											<li>Annex 2 - Calendar of deadlines [<a href="./files/download/meet06/Annex 2 - Calendar of deadlines.docx" class="nw">DOCX</a>]</li>
										</ul>
									</div>


								<?php  } else { ?>
									<?php  include('./impianto/inc/sorry.php'); //PIEDE?>
								<?php  } ?>
										

							</div> <!-- page_crp -->
							<!-- END contenuto pagina -->
				
				
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
