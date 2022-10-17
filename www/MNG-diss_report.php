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
                        <h1>Dissemination</h1>
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
								 This section is meant to facilitate the sharing of information among partners as far as the dissemination events carried out are concerned.
							</h1>
							<h4>
								  A description of the event, the number of people participating and the evaluation of the event are available for each dissemination event.
							</h4>

							<br /><br />
			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Dissemination
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">

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

	$sql = "SELECT * FROM pm__dissemination WHERE id_dis=".$act_id;
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$act_id=$row["id_dis"];
		$id_user=$row["id_user"];
		$data=$row["data"];
		$partner=Pulisci_READ($row["partner"]);
		$contact=Pulisci_READ($row["contact"]);
		$date_event=Pulisci_READ($row["date_event"]);
		$type_event=Pulisci_READ($row["type_event"]);
		$type_event_other=Pulisci_READ($row["type_event_other"]);
		$description=Pulisci_READ($row["description"]);
		$target=Pulisci_READ($row["target"]);
		$n_people=Pulisci_READ($row["n_people"]);
			$held_in_town=Pulisci_READ($row["held_in_town"]);
			$held_in_country=Pulisci_READ($row["held_in_country"]);
		$outcomes=Pulisci_READ($row["outcomes"]);
		$documents=Pulisci_READ($row["documents"]);
		
		if ($type_event=="Other") $type_event=$type_event_other;

		$period_from=$row["date_event_from"];
		$period_from_gg=substr($period_from, -2);
		$period_from_mm=substr($period_from, 4, 2);
		$period_from_aa=substr($period_from, 0,4);
		//$period_from=$period_from_gg.".".$period_from_mm.".".$period_from_aa;
		$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

		$period_to=$row["date_event_to"];
		$period_to_gg=substr($period_to, -2);
		$period_to_mm=substr($period_to, 4, 2);
		$period_to_aa=substr($period_to, 0,4);
		$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
		$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

		$period="";
		if ($row["date_event_from"]!="0") $period.=$period_from;
		if ($row["date_event_to"]!="0") $period.=" - ".$period_to;


	}

	$sql = "SELECT * FROM countries WHERE id=".$held_in_country;
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$held_in_country_name=Pulisci_READ($row["name"]);
	}


	// Target Group
	$target_str="";
	$sql = "SELECT * FROM db_TGR_app ORDER BY id_key";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id_key"];
		$nome=$row["nome"];

		if (strrpos($target,"_".$id_key."_")) $target_str.=$nome."<br />";
	}
	$target_str=substr($target_str,0,-6);

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

								<div style="margin: 25px 0 3px 0;padding: 2px 10px;text-align: right;background-color: #00aeef;border-radius: 5px;"><a href="./MNG-diss.php?partner=<?=$partner1?>" style="display: block;font-size: 1.0em;color: #fff;font-weight: 400;">< Back to the Dissemination List</a></div>

									<div class="doc_sch" style="margin-left: 25px;">
											<?php if ($partner) { ?>
												<div class="doc_blk1">
													<div class="title">Partners' Institution:</div>
													<div class="data"><?=$partner?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($contact) { ?>
												<div class="doc_blk1">
													<div class="title">Name of the person involved in the event:</div>
													<div class="data"><?=$contact?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($period) { ?>
												<div class="doc_blk1">
													<div class="title">Date of the event:</div>
													<div class="data"><?=$period?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($type_event) { ?>
												<div class="doc_blk1">
													<div class="title">Type of Dissemination event:</div>
													<div class="data"><?=$type_event?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($target_str) { ?>
												<div class="doc_blk1">
													<div class="title">Target group:</div>
													<div class="data"><?=$target_str?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($n_people) { ?>
												<div class="doc_blk1">
													<div class="title">Number of people reached by event:</div>
													<div class="data"><?=$n_people?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($held_in_town OR $held_in_country) { ?>
												<div class="doc_blk1">
													<div class="title">Held in:</div>
													<div class="data"><?=$held_in_town?> (<?=$held_in_country_name?>)</div>
												</div>
												<hr>
											<?php }?>

											<?php if ($description) { ?>
												<div class="doc_blk1">
													<div class="title">Description of Dissemination Event:</div>
													<div class="data"><?=nl2br($description)?></div>
												</div>
												<hr>
											<?php }?>

											<?php if ($outcomes) { ?>
												<div class="doc_blk1">
													<div class="title">Outcomes and Results:</div>
													<div class="data"><?=nl2br($outcomes)?></div>
												</div>
												<hr>
											<?php }?>
									</div>

									<div class="p03"><img class="pt2" src="./wiztr.gif" alt="" />Supporting Documents:</div>
									<div class="p04"><?php dir_list_GE("./data/dissemination",$act_id); ?></div>


								<br /><br />
								<div class="insrt" style="text-align: left;margin-left: 15px;"><a href="./MNG-diss.php?partner=<?=$partner1?>">Back to the Dissemination List</a></div>
									

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
