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
                        <h1>Project Meetings</h1>
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
								This section provides the access to the information about the transnational meetings and to all related documents.
							</h1>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Project Meetings
									</span>
								</div>
							</div> -->
	
				
							<!-- START contenuto pagina -->
							<div id="page_crp">
						
								<?php if ($_SESSION["usr_level"]>0 OR $usrId==586 OR $usrId==26) {  ?>
									
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
									.tit_lrg01 {
										padding: 15px 0 0 0;
										font-size: 1.2em;
										font-weight: 600;
										border-bottom: solid 1px #00aeef;
									}

									div.txt div.meet01 {
										padding: 2px 0 20px 18px;
										font-size: 1.1em;
									}
										div.txt div.meet01 div.meet02 {
											margin-top: 5px;
											padding: 5px;
											font-size: 0.9em;
											color: #ccc;
											border-radius: 5px;
											background-color: #00aeef;
										}
											div.txt div.meet01 div.meet02 a {
												padding: 0 5px;
												font-size: 1.1em;
												font-weight: 400;
												color: #fff;
											}
											div.txt div.meet01 div.meet02 div.photo {
												display: none;
												margin: 10px 0 0 0;
												padding: 5px;
												border-radius: 5px;
												background-color: #caf0ff;
											}
												div.txt div.meet01 div.meet02 div.photo ul {
													margin: 0;
													padding: 0;
													list-style-type: none;
												}
													div.txt div.meet01 div.meet02 div.photo ul li {
														margin: 0;
														padding: 0;
														list-style-type: none;
													}
													div.txt div.meet01 div.meet02 div.photo ul li a {
														float: left;
														margin: 5px 11px;
														padding: 0;
														border: solid 2px #fff;
													}
													div.txt div.meet01 div.meet02 div.photo ul li img {
														display: block;
														width: 90px;
														height: 60px;
														border: solid 1px #999;
													}
									</style>

									<div class="txt">

										<!-- <div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Sorry</div>
										<div class="cnt02">No Project Meetings are yet available</div> -->

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />First Meeting – Florence (IT), 29 – 30 October 2018</div>
										<div class="meet01">
											<p>The Kick-off meeting took place in Florence on 29 – 30 October 2018. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the project and the activities to be carried out. The meeting was also an opportunity for the partners to get to know each other and to discuss all details related to the project's activities. The partners presented the institutions involved. At the end of the meeting all the partners had a clear view of the future project's implementation, the financial rules and the next activity which is the development of the assessment tools.</p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal01');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal01" class="photo">
													<?php dir_list("01","phgall01"); ?>
													<div class="clear"></div>
												</div>
											</div>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Second Meeting – Kaunas (LT), 23 – 24 May 2019</div>
										<div class="meet01">
											<p>The second meeting took place in Kaunas on 23 – 24 May 2019. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the Self Need Assessment and Final Assessment Tools in order to assess them and to make the final adjustments. The meeting was also the opportunity for the partners to discuss the next activity which is the development of the MathE library.</p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal02');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal02" class="photo">
													<?php dir_list("02","phgall02"); ?>
													<div class="clear"></div>
												</div>
											</div>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Third Meeting – Limerick (IE), 2 – 3 December 2019</div>
										<div class="meet01">
											<p>The third meeting took place in Limerick on 2 – 3 December 2019. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the current situation for Self-Need Assessment and Final Assessment Tools. The meeting was also the opportunity for the partners to discuss the review of the video lesson and to plan the creation of new video lessons.</p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal03');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal03" class="photo">
													<?php dir_list("03","phgall03"); ?>
													<div class="clear"></div>
												</div>
											</div>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Fourth Meeting – Online, 25 June 2020</div>
										<div class="meet01">
											<p>The fourth meeting took place online on 25 June 2020. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the current situation for Self-Need Assessment, Final Assessment Tools and video Library. The meeting was also the opportunity for the partners to present the Community of Practice. The video recording is available the following <a href="https://talk.connectis.it/playback/presentation/2.0/playback.html?meetingId=c7afb8d3d52d982099e182e3dc3b0bcae3141b96-1593070210442" target="_blank">link</a></p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal04');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal04" class="photo">
													<?php dir_list("04","phgall04"); ?>
													<div class="clear"></div>
												</div>
											</div>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Fifth Meeting – Online, 21 December 2020</div>
										<div class="meet01">
											<p>The fifth meeting took place online on 21 December 2020. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the current situation for Self-Need Assessment, Final Assessment Tools and video Library. The meeting was also the opportunity for the partners to present the Community of Practice and to define the related calendar of activities.</p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal05');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal05" class="photo">
													<?php dir_list("06","phgall05"); ?>
													<div class="clear"></div>
												</div>
											</div>
										</div>

										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Sixth Meeting – Online, 23 June 2021</div>
										<div class="meet01">
											<p>The sixth meeting took place online on 23 June 2021. Ana Pereira from IPB (PT) and Lorenzo Martellini from Pixel (IT) presented to the partners the current situation for the intellectual outputs. The three of them are completed and available for the target groups on the project website. The meeting was also to discuss and present the impact of COVID on project activities and related impact on the project budget.</p>
											<div class="meet02">
												<p>Related documents: <a href="javascript: void(0);" onclick="javascript: showhidd('phgal06');">Pictures</a> - <a href="./MNG-download.php">Documents</a></p>
												<div id="phgal06" class="photo">
													<?php dir_list("07","phgall06"); ?>
													<div class="clear"></div>
												</div>
											</div>
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
	
	<!-- Gallery Simple LightBox JS -->
	<script type="text/javascript" src="./js/simple-lightbox.js"></script>
	<script>
		$(function(){
			var $gallery = $('.gallery a').simpleLightbox();
		});
	</script>
</body>
</html>
