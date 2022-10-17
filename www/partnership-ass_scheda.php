<?php
include('./top.php'); // funzioni PHP
?>
<?php

	$part_id=$_GET["part_id"];
	$par=$_GET["par"];
	$id_asch=$_GET["id_sch"];

	$sql = "
		SELECT * 
		FROM members_apartners 
		WHERE id_asch=".$id_asch;
	$result=mysqli_query($conn, $sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_partner=Pulisci_READ_lnk($row["id_partner"]);
		$ptn_name=$row["partner"];
		$qst02=Pulisci_READ_lnk($row["sch_name"]);
		$qst03=Pulisci_READ_lnk($row["sch_type"]);
		$qst04=Pulisci_READ_lnk($row["sch_city"]);
		$qst05=Pulisci_READ_lnk($row["sch_address"]);
		$qst06=Pulisci_READ_lnk($row["sch_country"]);
		$qst07=Pulisci_READ_lnk($row["sch_web"]);
		$qst08=Pulisci_READ_lnk($row["sch_contact"]);
		$qst09=Pulisci_READ_email($row["sch_contact_email"]);
		$qst10=Pulisci_READ_lnk($row["sch_description"]);
		$qst11=Pulisci_READ_lnk($row["sch_contribute"]);
	}

$pict="./wiztr.gif";
if (file_exists("./data/partnership/students/{$id_asch}.jpg")) $pict="./data/partnership/students/{$id_asch}.jpg"; 
$pict1="./wiztr.gif";
if (file_exists("./data/partnership/students/{$id_asch}_uni.jpg")) $pict1="./data/partnership/students/{$id_asch}_uni.jpg"; 

?>



    <main>
        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Associated Partner</h1>
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
									<li class="breadcrumb-item">Partnership</li>
									<li class="breadcrumb-item active" aria-current="page"><a href="./partnership-ass.php">Associated Partners</a></li>
								</ul>
							</nav>
				
							<!-- <h1 class="single-title">
								As a result of the exploitation activity a number of associated partners officially joined the project in order to contribute to the improvement of the project impact on their target groups and to ensure the project sustainability by continuing using the project deliverables in the next years.
							</h1>
							<h5>
								The associate partners of the MathE project are organizations interested in scientific education.  All associated partners share the project objectives and are willing to contribute to their achievement.
								<br>
								Institutions and organisations interested in becoming associated partners of the MathE project can contact the national coordinators of the project.
							</h5>
 -->
							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Associated Partners
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">



<style>

	.doc_blk1 span {
		font-weight: bold;
		color: #999:
	}
	.doc_blk1 div.data {
		padding-bottom: 10px;
		color: #000:
	}

</style>

									<?php if ($_SESSION["usr_level"]>0 OR $usrId==586 OR $usrId==26) {  ?>
							
										<p style="margin-bottom: 20px;padding: 2px 10px;text-align: right;background-color: #00aeef;border-radius: 5px;"><a href="./partnership-ass.php" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">Back to Associated Partners</a></p>

										<div class="doc_sch">

											<!-- <?php if($qst02) {?>
												<div class="doc_blk1">
													<span>NAME OF THE ORGANISATION</span> 
													<div class="data"><?=$qst02?></div>
													<div class="clear"></div>
												</div>
											<?php }?> -->
											<p style="margin: 30px 0;font-size: 2.1em;font-weight: 600;color: #000;"><?=$qst02?></p>
											
											<?php if($qst03) {?>
												<div class="doc_blk1">
													<span>TYPE OF INSTITUTION</span> 
													<div class="data"><?=$qst03?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst04) {?>
												<div class="doc_blk1">
													<span>CITY</span> 
													<div class="data"><?=$qst04?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst05) {?>
												<div class="doc_blk1">
													<span>ADDRESS</span> 
													<div class="data"><?=$qst05?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst06) {?>
												<div class="doc_blk1">
													<span>COUNTRY</span> 
													<div class="data"><?=$qst06?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst07) {?>
												<div class="doc_blk1">
													<span>WEB SITE</span> 
													<div class="data"><?=$qst07?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst08) {?>
												<div class="doc_blk1">
													<span>NAME OF CONTACT PERSON</span> 
													<div class="data"><?=$qst08?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst09) {?>
												<div class="doc_blk1">
													<span>EMAIL OF CONTACT PERSON</span> 
													<div class="data"><?=$qst09?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst10) {?>
												<div class="doc_blk1">
													<span>BRIEF DESCRIPTION OF THE ORGANISATION</span> 
													<div class="data"><?=$qst10?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst11) {?>
												<div class="doc_blk1">
													<span>CONTRIBUTION TO THE DISSEMINATION AND EXPLOITATION OF THE PROJECT RESULTS</span> 
													<div class="data"><?=$qst11?></div>
													<div class="clear"></div>
												</div>
											<?php }?>			
											<div class="clear"></div>
										</div> <!-- doc_sch -->

									<?php } else {
										include('./impianto/inc/sorry.php'); //PIEDE
									}?>


							
							
							
							
							
							
							
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
