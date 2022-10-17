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
                        <h1>Latest News</h1>
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
                                    News Archive
                                </h1>

							<br /><br />
				
                                <!-- <div class="info">
                                    <div class="entry">
                                        <span class="categories">
                                            <i class="fas fa-tag"></i>Latest News
                                        </span>
                                    </div>
                                </div> -->
				
                                <div class="blog-content">
									<div id="page_crp" style="padding-top: 10px;">
										<?php
										$sql = "
											SELECT * 
											FROM news 
											ORDER BY date DESC";
										$result=mysqli_query($conn,$sql);
										if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;

										$count=1;
										while ($row=mysqli_fetch_array($result)) { 

											$pict_id=$row["id"];
											$title=stripslashes($row["title"]);
											$text=stripslashes($row["text"]);
											$date=$row["date"];

											if ($date!="" AND $date!="0000-00-00 00:00:00") {
												$fatt_data_expl=explode("-",$date);
												$fatt_data_aa=$fatt_data_expl[0];
												$fatt_data_mm=$fatt_data_expl[1];
												$fatt_data_expl1=explode(" ",$fatt_data_expl[2]);
												$fatt_data_gg=$fatt_data_expl1[0];
												$fatt_data_expl2=explode(":",$fatt_data_expl1[1]);
												$fatt_data_ora=$fatt_data_expl2[0];
												$fatt_data_min=$fatt_data_expl2[1];
												$date=$fatt_data_gg."/".$fatt_data_mm."/".$fatt_data_aa;
											} else $date="";

											$date=Date("d F Y",strtotime($row["date"]));


											$pict="./data/news/".$pict_id."_ico.jpg";

											?>
											<em style="display: block;margin: 0 0 5px 0;padding: 2px;font-size: 1.0em;border-bottom: solid 2px #00aeef;"><?=$date?></em>
											<strong style="display: block;margin: 0 0 5px 0;font-size: 1.4em;"><?=$title?></strong>
											<img src="<?=$pict?>?rnd=<?=$rand_n?>" width="170" alt="" style="float: left; margin: 0 15px 15px 0;border-radius: 7px;" />
											<div style="font-size: 1.2em;font-style: normal;"><?=$text?></div>
											<div class="clear"></div>

											<?php
											$count+=1;
										}
										?>
									</div>
								</div>



                            </article>
						</div> <!-- single-content -->
					 </div> <!-- col-8 -->
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