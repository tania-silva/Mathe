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
                        <h1>Project Results</h1>
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
								  The section presents the complete list of project results.
							</h1>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Project Results
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">
						
								<?php  if ($_SESSION["usr_level"]>0 OR $usrId==586 OR $usrId==26) {  ?>

<style>
.tit_lrg01 {
	padding: 15px 0 0 0;
	font-size: 1.2em;
	font-weight: 600;
	border-bottom: solid 1px #00aeef;
}

.cnt02 {
	padding: 10px 0 0 25px;
}

</style>

									<div class="txt">

										<p style="padding-bottom: 10px;">The results produced by the MathE project are:</p>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />IO1 – Student Assessment Toolkit</div>
										<div class="cnt02">
											<strong>1) <a href="./STAS_SNA.php">Student Self Need Assessment</a></strong><br />
											This toolkit allows students to carry out a self-evaluation of their knowledge on 10 selected Math topics.
											<br /><br />
											<strong>2) <a href="./STAS_FA.php">Student Final Assessment</a></strong><br />
											This toolkit provides teachers with the possibility to organize for their students an online test on 10 selected Math topics.
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />IO2 – Math Library</div>
										<div class="cnt02">
											<strong>3) <a href="./MALI_VC.php">Video Collection </a></strong><br />
											A collection including reviews of already exsisting video lessons and specifically tailor made ones.
											<br /><br />
											<!--<strong>4) <a href="./MALI_VL.php">Video Lessons </a></strong><br />
											A collection of specifically created video lessons on 10 selected Math topics.
											<br /><br />-->
											<strong>4) <a href="./MALI_TM.php">Teaching Material </a></strong><br />
											Acquisition of intercultural competences based on understanding human rights and non-discrimination values
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />IO3 – Community of Practice </div>
										<div class="cnt02">
											<strong>5) <a href="./CM_community.php">Community of Practice</a></strong><br />
											A virtual place to exchange teaching and learning experiences between teachers and students.
										</div>

										<div style="margin-top: 35px;padding-bottom: 10px;font-size: 1.7em;color: #444;text-align: center;"><strong>Project Management</strong></div>
										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Coordination of Activities</div>
										<div class="cnt02">
											<strong>6) Partners' Meeting</strong><br /><br />
											First Partners' Meeting
											<ul>
												<li><a href="./files/download/meetings/01_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/01_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet01/_First%20meeting%20minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>
											Second Meeting
											<ul>
												<li><a href="./files/download/meetings/02_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/02_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet02/_Second meeting minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>
											Third Meeting
											<ul>
												<li><a href="./files/download/meetings/03_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/03_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet03/_Third meeting minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>
											Fourth Meeting
											<ul>
												<li><a href="./files/download/meetings/04_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/04_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet04/_Fourth meeting minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>
											Fifth Meeting
											<ul>
												<li><a href="./files/download/meetings/05_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/05_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet05/_Fifth%20meeting%20minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>
											Sixth Meeting
											<ul>
												<li><a href="./files/download/meetings/06_Folder.PDF" class="nw">Meeting Folder</a></li>
												<li><a href="./files/download/meetings/06_Participants.PDF" class="nw">List of Participants</a></li>
												<li><a href="./files/download/meet06/_Sixth meeting minutes.docx" class="nw">Minutes </a></li>
												<li>The Annexes to the minutes are available in the <a href="./MNG-prjmeeting.php">Meeting section </a></li>
											</ul>

											<!--<strong>Financial Management</strong><br />-->
											<strong>7) <a href="./files/download/templates/PM1.E – Financial Manual.pdf" class="nw">Financial Manual </a></strong>
											<br />
											The manual contains a description of the financial rules.
											<br /><br />
														
							  <strong>8) <a href="./files/download/templates/PM1.F – Financial Forms.rar" class="nw">Financial Forms </a></strong>
							  <br />
							  Suggested models and examples to be used for for the accounting of project costs.
											<br /><br />
							  
							  <strong>9) <a href="MNG-wip.php">In progress Activity Reports</a></strong>
											<br />  
											The activities reports are produced on a three monthly basis by the project partners and directly uploaded on the project web site.
											<br /><br />

											<strong>10) Project web site</strong><br />
											The management section of the project portal has been created in order to support the partners with the project management.<br />
											<ul>
												<li><a href="MNG-prjdescription.php">Project Description</a></li>
												<li><a href="MNG-prjpartnership.php">Project Partnership</a></li>
												<li><a href="MNG-prjresult.php">Project Results</a></li>
												<li><a href="MNG-prjmeeting.php">Project Meetings</a></li>
												<li><a href="MNG-wip.php">Work in Progress</a></li>
												<li><a href="MNG-diss.php">Dissemination</a></li>
												<li><a href="MNG-exploitation.php">Exploitaiton</a></li>
												<li><a href="MNG-download.php">Download Area  </a></li>
												<!-- <li><a href="xxx">Partners Forum</a></li> -->
											</ul>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Quality and Monitoring Plan</div>
										<div class="cnt02">
											<strong>11) Quality Plan</strong><br />
											The quality plan identifies for each phase and transversal activity the relevant milestones and indicators of performances.
											<ul>
												<li><a href="./files/quality/Quality_Plan_ 01.pdf" class="nw">Quality Plan Issue 01, October 2018</a></li>
												<li><a href="./files/quality/Quality_Plan_ 02.pdf" class="nw">Quality Plan Issue 02, September 2019 </a></li>
												<li><a href="./files/quality/Quality_Plan_ 03.pdf" class="nw">Quality Plan Issue 03, July 2021 </a></li>
											</ul>
											<strong>12) <a href="./files/Transnational Internal Evaluation report.pdf" class="nw">Transnational Internal Evaluation report</a></strong><br />
											The internal evaluation report is produced for the final report and contains a detailed description and analysis of the project activities carried out and the project results achieved by the project partnership.
											<br /><br />
											<strong>13) Testing National Evaluation Reports</strong><br />
											All Intellectual Outputs have been tested at national level by the students and lecturers involved in the project. The results of the testing are reported in the following national evaluation reports:
											<ul>
												<li><a href="./files/testing/IE_Testing_Evaluation_Report.pdf" class="nw">Irish Report </a></li>
												<li><a href="./files/testing/IT_Testing_Evaluation_Report.pdf" class="nw">Italian Report  </a></li>
												<li><a href="./files/testing/LT_Testing_Evaluation_Report.pdf" class="nw">Lithuanian Report  </a></li>
												<li><a href="./files/testing/PT_Testing_Evaluation_Report.pdf" class="nw">Portuguese Report  </a></li>
												<li><a href="./files/testing/RO_Testing_Evaluation_Report.pdf" class="nw">Romanian Report </a></li>
											</ul>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Dissemination</div>
										<div class="cnt02">
											<strong>14) <a href="./files/Transnational Dissemination Report.pdf" class="nw">Dissemination Report</a></strong><br />
											The dissemination report is produced for final report and contains a detailed description and analysis of the dissemination activities carried out by the project partnership.
											<br /><br />
											<strong>15) <a href="MNG-diss.php">Dissemination Section </a></strong><br />
											It contains the electronic dissemination forms filled by the project partners for every dissemination event carried out.
											<br /><br />
											<strong>16) <a href="brochure.php">Promotional Material</a></strong><br />
											Information brochures translated in the project languages.
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Exploitation</div>
										<div class="cnt02">
											<strong>17) Involvement of project beneficiaries </strong><br />
											The network is composed by:
											<ul>
												<li><a href="./MP_LECT_SNA_lecturerList.php">Math Lecturers</a></li>
												<li><a href="./MP_LECT_SNA_studentList.php">Math Students</a></li>
											</ul>
											<strong>18) <a href="partnership-ass.php">Involvement of key actors </a></strong><br />
											As a result of the exploitation activity a number of associated partners officially joined the project in order to contribute to the improvement of the project impact on their target groups and to ensure the project sustainability by continuing using the project deliverables in the next years.
											<br /><br />
											<strong>19) <a href="press_review.php">Press Review </a></strong><br />
											The project partnership made contacts with web sites focusing on the fields of the project in order to guarantee the visibility of the project results.
                      <br /><br />
											<strong>20) <a href="./files/Publication and Communication.pdf" class="nw">Publication and Communications</a></strong><br />
											The attached publications and communications were done associated to the MathE Project.
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Training Activity</div>
										<div class="cnt02">
											<!--<strong>20) Documents for Participation</strong><br />
											The course has been organized according to the ECTS standards. For each participant, also, a Mobility Europass has been issued
											<ul>
												<li><a href="xxx" class="nw">Mobility Europass</a></li> -->
											</ul>
											<strong>21) Training Activity Documents</strong><br />
											The training activity took place online from 14 to 18 June 2021. The programme was organized in 5 days and delivered by the experts of the hosting partner, IPB (PT) with the support of the other contractual partners. The course has been organized according to the ECTS standards.
											<br />During the training event a collaborative document was elaborated and shared among the participants. The participants intend to keep working on this document, improving it and adapting it, in order to submit it to and appropriate conference or journal.
                      <br /><br />The following documents are available:
											<ul>
												<li><a href="./files/trainingact/Training Activity Declaration.pdf" class="nw">Training Activity Declaration</a></li>
												<li><a href="./files/trainingact/Training Activity Programme.pdf" class="nw">Training Programme</a></li>
												<li><a href="./files/trainingact/Training Activity Certificates.zip" class="nw">Participants Certificates</a></li>
												<li><a href="./files/trainingact/Training Activity Register.pdf" class="nw">Training Activity Register</a></li>
                        <li><a href="./files/trainingact/Training Activity Paper.pdf" class="nw">Training Activity Paper</a></li>
											</ul>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Multiplier Events</div>
										<div class="cnt02">
											22) Multiplier Event in Lithuania
											<ul>
												<li><a href="./CNF_scheda02.php">Description</a></li>
												<li><a href="./files/multiplierEvents/LT_Participants.pdf" class="nw">List of Participants</a></li>
											</ul>
											25) Multiplier Event in Portugal
											<ul>
												<li><a href="./CNF_scheda03.php">Description</a></li>
												<li><a href="./files/multiplierEvents/PT1_List of Participants.pdf" class="nw">List of Participants</a></li>
												<li><a href="./files/multiplierEvents/PT1_Declaration.pdf" class="nw">Declaration</a></li>
											</ul>
											26) Multiplier Event in Portugal
											<ul>
												<li><a href="./CNF_scheda04.php">Description</a></li>
												<li><a href="./files/multiplierEvents/PT2_List of facetoface Participants.pdf" class="nw">List of Participants</a></li>
												<li><a href="./files/multiplierEvents/PT2_Declaration.pdf" class="nw">Declaration</a></li>
											</ul>
											27) Multiplier Event in Romania
											<ul>
												<li><a href="./CNF_scheda05.php">Description</a></li>
												<li><a href="./files/multiplierEvents/RO_List of Participants.pdf" class="nw">List of Participants</a></li>
											</ul>
										</div>

									
									</div>			
								<?php  } else { ?>
									<?php  include('./impianto/inc/sorry.php'); //PIEDE?>
								<?php  } ?>

							</div> <!-- page_crp -->
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
