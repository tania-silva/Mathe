<?php
include('./top.php'); // funzioni PHP
?>



<?php 

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'wps'=>'str',
			'partner'=>'str'
	);
	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

	$partner=$_GET["partner"];

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

							

								<div class="mdr" style="margin-top: 0px;padding-bottom: 5px;">
									<p class="tit">Search by:</p>
									<em style="width: 150px;">Select Partners' Institution</em>
									<div class="opt">
										<select name="partner" onchange="javascript:document.location.href='./MNG-diss.php?&partner='+this.options[this.selectedIndex].value;">
											<option value="">All Partners</option>
											<?php
											sanitize($_GET, $var_get);
											////////////////////////////////////////////////////
											$partner=$_GET["partner"];

											$sql = "SELECT * FROM partner WHERE vis=1 ORDER BY name";
											$result=mysqli_query($conn,$sql);

											while ($row=mysqli_fetch_array($result)) { 
												?>
												<option value="<?=$row["id_partner"]?>" <?php if (trim($partner)==trim($row["id_partner"])) echo "selected"?>><?=Pulisci_READ($row["name"])?> (<?=$row["country_sinc"]?>)</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="clear"></div>
								</div>

								<?php
								if ($_SESSION["id_user"]) {
									$sql = "SELECT * FROM user WHERE id_user=".$_SESSION["id_user"];
									$result=mysqli_query($conn,$sql);

									while ($row=mysqli_fetch_array($result)) { 
										$id_partner=Pulisci_READ($row["id_partner"]);
										$usr_level=Pulisci_READ($row["usr_level"]);
									}
								}

								if ($partner!="") {
									$partner=sanitizeOne($partner,'sql');
									$where="WHERE p.id_partner='".$partner."'";
								} else {
									$where="";
								}

								$sql = "
									SELECT * 
									FROM pm__dissemination AS p 
									LEFT JOIN countries AS q 
									ON p.held_in_country=q.id 
									$where 
									ORDER BY p.date_event_from DESC";
								$result=mysqli_query($conn,$sql);
								if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;
								?>

								
								<div id="wip01" style="margin: 25px 0 2px 5px;">
									<p class="sx">Found <?=$count_tot?> documents</p>
									<p class="dx"></p>
									<div class="clear"></div>
								</div>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Date</th>
											<th>Type of Event</th>
											<th>Place</th>
											<th>Partner Institution</th>
										</tr>
									</thead>
									<tbody>
									<?php
									while ($row=mysqli_fetch_array($result)) { 
										$lnk="./MNG-diss_report.php?id_act=".$row["id_dis"]."&partner=".$partner;

										$par_permit="off";
										if (($id_partner==$row["id_partner"] && $usr_level>=2) || $usr_level==5) $par_permit="on";
										$adm_permit="off";
										if ($usr_level==5) $adm_permit="on";

										$type_event_scr=substr(Pulisci_READ($row["type_event"]),0,25);
										if (strlen(Pulisci_READ($row["type_event"]))>25) $type_event_scr=$type_event_scr."...";
										if ($row["type_event"]=="Other") $type_event_scr=substr(Pulisci_READ($row["type_event_other"]),0,25);;
										
										$held_in_town=Pulisci_READ($row["held_in_town"])." (".strtoupper(Pulisci_READ($row["alpha_2"])).")";

										$period_from=$row["date_event_from"];
										$period_from_gg=substr($period_from, -2);
										$period_from_mm=substr($period_from, 4, 2);
										$period_from_aa=substr($period_from, 0,4);
										$period_from=Date1($period_from_gg,$period_from_mm,$period_from_aa);

										$period_to=$row["date_event_to"];
										$period_to_gg=substr($period_to, -2);
										$period_to_mm=substr($period_to, 4, 2);
										$period_to_aa=substr($period_to, 0,4);
										$period_to=$period_to_gg.".".$period_to_mm.".".$period_to_aa;
										$period_to=Date1($period_to_gg,$period_to_mm,$period_to_aa);

										$period="";
										if ($row["date_event_from"]!="0") $period.="".$period_from;

										?>
										<tr>
											<td><a href="<?=$lnk?>"><?=$period?></a></td>
											<td><a href="<?=$lnk?>"><?=$type_event_scr?></a></td>
											<td><a href="<?=$lnk?>"><?=$held_in_town?></a></td>
											<td><a href="<?=$lnk?>"><?=Pulisci_READ($row["partner"])?></a></td>
										</tr>
										<?php
									}
									?>
									</tbody>
								</table>				
									

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
