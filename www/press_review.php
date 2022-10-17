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
                        <h1>Press Review</h1>
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
								  The MathE project partnership made contacts with web sites focusing on the field of scientific education
							</h1>
							
							<h5>
								  The MathE project was presented to the web masters and a link to the MathE project portal was made so that those who will access the selected web sites can also access, through a direct link, the MathE portal.
							</h5>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Press Review
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">


									<?php
									$sql = "
										SELECT * 
										FROM press 
										ORDER BY id DESC";
									$result=mysqli_query($conn,$sql);
									if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;

									$count=1;
									while ($row=mysqli_fetch_array($result)) { 

										$pict_id=$row["id"];
										$title=stripslashes($row["title"]);
										$text=stripslashes($row["text"]);
										$link=stripslashes($row["link"]);

										$pict="./data/press/".$pict_id."_ico.jpg";
										$pict_big="./data/press/".$pict_id."_big.jpg";

										?>
										<div class="row">
											<div class="col-md-3 col-sm-4 event-contentarea">
												<div style="margin-bottom: 15px;">
													<?php if ($noPict==1) {?>
														<img src="<?=$pict?>?rnd=<?=$rand_n?>" alt="<?=$title?>" width="90%"/>
													<?php } else {?>
														<ul class="gallery clearfix"><li style="list-style-type: none;"><a href="<?=$pict_big?>" target="_blank"><img src="<?=$pict?>?rnd=<?=$rand_n?>" alt="<?=$title?>" width="90%"/></a></li></ul>
													<?php }?>
												</div>
											</div>			    
											<div class="col-md-9 col-sm-8 event-contentarea">
												<h3 class="course-title" style="margin: 0 0 0 0;font-size: 1.3em;font-weight: 600;"><?=$title?></h3>
												<!-- <div class="course-description"><?=replaceLinks($link)?></div> -->
												<div class="course-description"><?=$text?></div>
											</div>
										</div>
										<hr>


										<!-- <em style="display: block;margin: 0 0 5px 0;padding: 2px;font-size: 1.0em;border-bottom: solid 2px #00aeef;"></em>
										<a href="<?=$pict_big?>" class="nw"><img src="<?=$pict?>?rnd=<?=$rand_n?>" width="170" alt="" style="float: left; margin: 0 15px 15px 0;border: solid 1px #ddd;border-radius: 7px;" /></a>
										<div style="float: left;font-size: 0.9em;line-height: 1.5em;">
											<strong style="display: block;margin: 0 0 5px 0;font-size: 1.4em;"><a href="<?=$pict_big?>" class="nw"><?=$title?></a></strong>
											<div class="prew01" style="font-size: 1.2em;font-style: normal;"><?=$text?></div>
										</div>
										<hr> -->
										<div class="clear"></div>


										<?php
										$count+=1;
									}

									if ($count_tot==0) {
										?>
										<div style="padding: 25px 0;font-size: 1.4em;text-align: center;">Sorry<br />No press reviews are yet available.</div>
										<?php
									}
									?>

										

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
	
	<!-- Gallery Simple LightBox JS -->
	<script type="text/javascript" src="./js/simple-lightbox.js"></script>
	<script>
		$(function(){
			var $gallery = $('.gallery a').simpleLightbox();
		});
	</script>
</body>
</html>
