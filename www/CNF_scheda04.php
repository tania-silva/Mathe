<?php
include('./top.php'); // funzioni PHP
?>

	<!-- Gallery Simple LightBox CSS -->
	<link href='./css/simplelightbox.min.css' rel='stylesheet' type='text/css'>

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

							<h1 class="single-title">
								The MathE project was presented in a number of events in order to report about the activities carried out and the results achieved.
							</h1>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Conferences
									</span>
								</div>
							</div> -->

				
							<!-- START contenuto pagina -->
							<div id="page_crp">
								
								
								
								<?php
									function dir_list($directory = FALSE,$gallery) {

										$directory_min="./photo/".$directory."/min";
										$directory_nor="./photo/".$directory."/nor";
										$dirs= array();
										$files = array();

										if ($handle = opendir("./" . $directory_min)) {
											while ($file = readdir($handle)) {
												if (is_dir("./{$directory_min}/{$file}")) {
													if ($file != "." & $file != "..") $dirs[] = $file;
												}
												else {
													if ($file != "." & $file != "..") $files[] = $file;
												}
											}
										}
										closedir($handle);	
										reset($files);
										sort($files);
										reset($files);

										echo "<ul class=\"gallery clearfix\">";

										while(list($key, $value) = each($files)) {
											$f++;
											echo "<li><a href=\"{$directory_nor}/{$value}\" target=\"_blank\" title=\"{$value}\"><img src=\"{$directory_min}/{$value}\" alt=\"\" /></a></li>\n";
										}

										echo "</ul>";

										if (!$d) $d = "0";
										if (!$f) $f = "0";
									}
								?>
								<style>
										div.txt div.photo {
											display: block;
											margin: 10px 0 0 0;
											padding: 5px;
											border-radius: 5px;
											background-color: #caf0ff;
										}
											div.txt div.photo ul {
												margin: 0;
												padding: 0;
												list-style-type: none;
											}
												div.txt div.photo ul li {
													margin: 0;
													padding: 0;
													list-style-type: none;
												}
												div.txt div.photo ul li a {
													float: left;
													margin: 5px 11px;
													padding: 0;
													border: solid 2px #fff;
												}
												div.txt div.photo ul li img {
													display: block;
													width: 90px;
													height: 60px;
													border: solid 1px #999;
												}
								</style>
					
								<p style="margin-top: 0px;margin-bottom: 20px;padding: 2px 10px;text-align: right;background-color: #00236c;border-radius: 5px;"><a href="./conferences.php" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">Back to the Conferences List</a></p>

								<div class="txt">
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Title of the Conference</div>
									<div class="p04" style="font-size: 1.4em;font-weight: 400;">MathE – teaching and learning is attractive! MathE tools and instruments for Math teaching and learning, sharing of good practise</div>
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Date of the conference:</div>
									<div class="p04">01/07/2021</div>
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Place of the conference:</div>
									<div class="p04">Kaunas, Lithuania</div>
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Description of the conference:</div>
									<div class="p04">
									
Event was organized face to face, respecting all requirements related to covid-19 restrictions. 
<br />-	Most of our participants were lecturers from Universities, colleges (who teach not only Lithuanian students, but also foreigners), as well from vocational education centres, schools and non-formal education providers, there were students who study Math and also work as trainers of Math.
<br />-	The contents of the focus group: during the Multiplier event we had 2 focus groups moderated by associate professors who were researchers in MathE project. Selected topics to go deeper and to discuss with participants were: “Community of Practice – where students and teachers meet online” and “Automated tool for students’ knowledge assessment”.
<br />-	Participants were interested into project, especially automated knowledge assessment tool and possibility to update it with new questions, to share questions with other lecturers. They also expressed wish that this tool would be translated into Lithuanian. Participants were encouraged to use Community of Practice. All of the participants who expressed wish to have log in to MathE  system, had this opportunity, they were registered and got credentials before the conference, therefore they were able to be fully involved into focus group. As well they promised to share Community of Practice tool with their students and in September, October to use the tool together.
<br /><br />
<a href="./files/conferences/04/LT_Minutes.pdf" class="nw">More</a> 
									
									</div>
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Programme:</div>
									<div class="p04"><a href="./files/conferences/04/LT_Programme.pdf" class="nw">Conference Programme</a></div>
								
								
									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Pictures:</div>
									<!-- <div class="phtgallery" style="width: 520px;">
										<div id="phtgallery01" style="display: block;margin: 5px 0 0 35px;"><?php dir_list("05","phgall04"); ?></div>
									</div> -->
											<div id="phgal04" class="photo">
												<?php dir_list("10","phgall04"); ?>
												<div class="clear"></div>
											</div>
				
				
				
				
								
								</div>
							</div> <!-- page_crp -->
								
							<!-- END contenuto pagina -->






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
	
	<!-- Gallery Simple LightBox JS -->
	<script type="text/javascript" src="./js/simple-lightbox.js"></script>
	<script>
		$(function(){
			var $gallery = $('.gallery a').simpleLightbox();
		});
	</script>
</body>
</html>
