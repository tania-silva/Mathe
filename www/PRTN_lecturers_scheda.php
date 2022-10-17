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
                        <h1>Lecturers</h1>
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
								</ul>
							</nav>
				
							<h2 class="single-title">
								From this section it is possible to access to the information related to the lecturers involved in the MathE project in the 5 European partner countries.
							</h2>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Lecturers
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp" style="padding-top: 0px;">

<?php 

////////////////////////////////////////Sanitize Vars ////////////////////
$DS=DIRECTORY_SEPARATOR;
$root="./";
require_once($root."librerie".$DS."sanitize".$DS."sanitize.lib.php");
$var_post=array(
			'art_id'=>'int',
			'par'=>'int',
			'id_asch'=>'int'
	);
$var_get=array(
			'part_id'=>'int',
			'par'=>'int',	
			'id_sch'=>'int'
	);
sanitize($_GET,$var_get);
sanitize($_POST,$var_post);
//////////////////////////////////////////////////////////////////////////////

$part_id=$_GET["part_id"];
$par=$_GET["par"];
$id_asch=$_GET["id_sch"];

$sql = "SELECT * FROM PRT_lecturer WHERE id_asch=".$id_asch;
$result=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_array($result)) { 
	$id_partner=Pulisci_READ_lnk($row["id_partner"]);
	$ptn_name=Pulisci_READ_lnk($row["partner"]);
	$qst02=Pulisci_READ($row["qst02"]);
	$qst03=Pulisci_READ($row["qst03"]);
	$qst04=Pulisci_READ($row["qst04"]);
	$qst05=Pulisci_READ($row["qst05"]);
	$qst06=Pulisci_READ($row["qst06"]);
	$qst07=Pulisci_READ($row["qst07"]);
	$qst08=Pulisci_READ($row["qst08"]);
	$qst09=Pulisci_READ($row["qst09"]);
	$qst10=Pulisci_READ($row["qst10"]);
	$qst11=Pulisci_READ($row["qst11"]);
	$qst12=Pulisci_READ($row["qst12"]);
	$qst13=Pulisci_READ($row["qst13"]);
	$qst14=Pulisci_READ($row["qst14"]);
	$qst15=Pulisci_READ($row["qst15"]);
	$qst16=Pulisci_READ($row["qst16"]);
	$qst17=Pulisci_READ($row["qst17"]);
	$qst20=Pulisci_READ($row["qst20"]);
}

$pict="./impianto/img/nousergradpict.jpg";
if (file_exists("./data/partnership/lecturers/{$id_asch}.jpg")) $pict="./data/partnership/lecturers/{$id_asch}.jpg"; 
$pict1="./impianto/img/nounipict.jpg";
if (file_exists("./data/partnership/lecturers/{$id_asch}_uni.jpg")) $pict1="./data/partnership/lecturers/{$id_asch}_uni.jpg"; 

?>
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
			
									<p style="margin-bottom: 20px;padding: 2px 10px;text-align: right;background-color: #0085c8;border-radius: 5px;"><a href="./PRTN_lecturers.php" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">Back to the Lecturers</a></p>

									<div class="doc_sch">

										<p style="float: left;width: 150px;margin: 0 25px 0 0;"><img src="<?=$pict?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst02?>" /></p>
											
										<div style="float: left;">
											<?php if($qst02) {?>
												<div class="doc_blk1">
													<span>NAME AND SURNAME</span> 
													<div class="data"><?=$qst02?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst03) {?>
												<div class="doc_blk1">
													<span>E-MAIL</span> 
													<div class="data"><?=replaceEmails($qst03)?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst04) {?>
												<div class="doc_blk1">
													<span>WEB SITE</span> 
													<div class="data"><?=replaceLinks($qst04)?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst05) {?>
												<div class="doc_blk1">
													<span>FIELD OF RESEARCH</span> 
													<div class="data"><?=$qst05?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst06) {?>
												<div class="doc_blk1">
													<span>SUBJECT TAUGHT</span> 
													<div class="data"><?=$qst06?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst07) {?>
												<div class="doc_blk1">
													<span>YEARS OF EXPERIENCE</span> 
													<div class="data"><?=$qst07?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst08) {?>
												<div class="doc_blk1">
													<span>PROFILE</span> 
													<div class="data"><?=replaceLinks(nl2br($qst08))?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
										</div>
										
										<div style="float: left;width: 150px;margin: 0 25px 0 0;">
											<img src="<?=$pict1?>?rnd=<?=$rand_n?>" style="width: 150px;border: solid 1px #999;" alt="<?=$qst09?>" />
										</div>
											
										<div style="float: left;">
											<?php if($qst09) {?>
												<div class="doc_blk1">
													<span>NAME OF THE UNIVERSITY</span> 
													<div class="data"><?=$qst09?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst10) {?>
												<div class="doc_blk1">
													<span>FACULTY / DEPARTMENT</span> 
													<div class="data"><?=$qst10?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst12) {?>
												<div class="doc_blk1">
													<span>COUNTRY</span> 
													<div class="data"><?=$qst20?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst11) {?>
												<div class="doc_blk1">
													<span>NUMBER OF STUDENTS</span> 
													<div class="data"><?=$qst11?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst13) {?>
												<div class="doc_blk1">
													<span>CITY</span> 
													<div class="data"><?=$qst13?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst14) {?>
												<div class="doc_blk1">
													<span>ADDRESS</span> 
													<div class="data"><?=$qst14?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst15) {?>
												<div class="doc_blk1">
													<span>TEL</span> 
													<div class="data"><?=$qst15?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst16) {?>
												<div class="doc_blk1">
													<span>E-MAIL</span> 
													<div class="data"><?=replaceEmails($qst16)?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
											
											<?php if($qst17) {?>
												<div class="doc_blk1">
													<span>WEB SITE</span> 
													<div class="data"><?=replaceLinks($qst17)?></div>
													<div class="clear"></div>
												</div>
											<?php }?>
										</div>
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
