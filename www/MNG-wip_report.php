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
                        <h1>Work in Progress</h1>
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
								  This section allows a constant communication and sharing of information among the project partners as far as the activities for the different intellectual outputs are concerned.
							</h1>
							<h4>
								  Each project partner upload this section of a three months basis.
							</h4>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Work in Progress
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp" style="padding-top: 0;">

<?php 

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'id_act'=>'int',
			'wps'=>'sql',
			'partner'=>'sql'
	);

	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////
	$act_id=$_GET["id_act"];
	$wps1=$_GET["wps"];
	$partner1=$_GET["partner"];

	$sql = "SELECT * FROM pm__workinprogress WHERE id_act=".$act_id;
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$act_id=$row["id_act"];
		$data=$row["data"];
		$id_user=$row["id_user"];
		$partner=Pulisci_READ($row["partner"]);
		$wps=Pulisci_READ($row["wps"]);
		$objectives=Pulisci_READ($row["objectives"]);
		$time=Pulisci_READ($row["time"]);
		$description=Pulisci_READ($row["description"]);
		$outcomes=Pulisci_READ($row["outcomes"]);
		$evaluation=Pulisci_READ($row["evaluation"]);

		$period_from=$row["period_from"];
		$period_from_gg=substr($period_from, -2);
		$period_from_mm=substr($period_from, 4, 2);
		$period_from_aa=substr($period_from, 0,4);
		//$period_from=$period_from_gg.".".$period_from_mm.".".$period_from_aa;
		$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

		$period_to=$row["period_to"];
		$period_to_gg=substr($period_to, -2);
		$period_to_mm=substr($period_to, 4, 2);
		$period_to_aa=substr($period_to, 0,4);
		$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
		$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

		$period="";
		if ($row["period_from"]!="0") $period.=$period_from;
		if ($row["period_to"]!="0") $period.=" - ".$period_to;
	}

	 switch ($wps) {
		case "IO1":   $wps_name="IO1 - Student Assessment Toolkit";
		break;
		case "IO2":   $wps_name="IO2 - Math Library";
		break;
		case "IO3":   $wps_name="IO3 - Community of Practice ";
		break;
		case "ME":   $wps_name="ME - Multiplier Events";
		break;
		case "PM":   $wps_name="PM - Project Management";
		break;
	} 
?>
<style>
		div.doc_blk1 div.title {
			display: block;
			padding: 10px 0 0 0;
			font-size: 0.9em;
			font-weight: bold;
			color: #000;
			text-transform: uppercase;
			text-align: left;
		}
		div.doc_blk1 div.data {
			display: block;
			margin: 10px 0 0 0;
			padding: 0;
			color: #444;
			line-height: 1.2em;
		}
</style>
							
								<div style="margin: 25px 0 3px 0;padding: 2px 10px;text-align: right;background-color: #00aeef;border-radius: 5px;"><a href="./MNG-wip.php?wps=<?=$wps1?>&amp;partner=<?=$partner1?>" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">< Back to the Work in Progress List</a></div>

								<div class="doc_sch" style="margin-left: 25px;">
									<?php if ($partner) { ?>
										<div class="doc_blk1">
											<div class="title">Partners' Institution:</div>
											<div class="data"><?=$partner?></div>
										</div>
										<hr>
									<?php }?>

									<?php if ($period) { ?>
										<div class="doc_blk1">
											<div class="title">Project's period (from/to):</div>
											<div class="data"><?=$period?></div>
										</div>
										<hr>
									<?php }?>

									<?php if ($wps_name) { ?>
										<div class="doc_blk1">
											<div class="title">Activity concerned:</div>
											<div class="data"><?=$wps_name?></div>
										</div>
										<hr>
									<?php }?>

									<?php if ($objectives) { ?>
										<div class="doc_blk1">
											<div class="title">Objectives of activities carried out:</div>
											<div class="data"><?=nl2br($objectives)?></div>
										</div>
										<hr>
									<?php }?>

									<?php if ($description) { ?>
										<div class="doc_blk1">
											<div class="title">Description of activities carried out:</div>
											<div class="data"><?=nl2br($description)?></div>
										</div>
										<hr>
									<?php }?>

									<?php if ($outcomes) { ?>
										<div class="doc_blk1">
											<div class="title">Results Achieved:</div>
											<div class="data"><?=nl2br($outcomes)?></div>
										</div>
										<hr>
									<?php }?>
								</div>

								
								<br /><br />
								<div class="insrt" style="text-align: left;margin-left: 15px;"><a href="./MNG-wip.php?wps=<?=$wps1?>&amp;partner=<?=$partner1?>">Back to the Work in Progress List</a></div>

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
