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

	$wps=$_GET["wps"];
	$partner=$_GET["partner"];

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
							<div id="page_crp">
										
								<!-- <h2>Work in Progress</h2> -->
								
								<div class="mdr" style="margin-top: 0;padding-bottom: 5px;">
									<p class="tit">Search by:</p>
										<em style="width: 150px;">Select Activity concerned</em>
										<div class="opt">
											<select name="wps" onchange='javascript:document.location.href="./MNG-wip.php?wps="+this.options[this.selectedIndex].value+"&partner=<?=$partner?>";'>
												<option value="">All Activities</option>
												<option value="IO1" <?php if ($wps=="IO1") echo "selected"?>>IO1 - Student Assessment Toolkit</option>
												<option value="IO2" <?php if ($wps=="IO2") echo "selected"?>>IO2 - Math Library</option>
												<option value="IO3" <?php if ($wps=="IO3") echo "selected"?>>IO3 - Community of Practice</option>
												<option value="ME" <?php if ($wps=="ME") echo "selected"?>>ME - Multiplier Events</option>
												<option value="PM" <?php if ($wps=="PM") echo "selected"?>>PM - Project Management</option>
											</select>
										</div>
										<div class="clear"></div>
										
										<em style="width: 150px;">Select Partners' Institution</em>
										<div class="opt">
											<select name="partner" onchange='javascript:document.location.href="./MNG-wip.php?wps=<?=$wps?>&partner="+this.options[this.selectedIndex].value;'>
												<option value="">All Partners</option>
												<?php 

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

								if ($wps!="" || $partner!="") {
									//echo("<script> alert('".sanitizeOne($wps,'sql')."')</script>");
									$wps=sanitizeOne($wps,'sql');
									$partner=sanitizeOne($partner,'sql');
									
									if ($wps!="" && $partner!="") {
										$where="WHERE (wps='".$wps."' AND id_partner='".$partner."')";
									} elseif ($wps!="") {
										$where="WHERE wps='".$wps."'";
									} elseif ($partner!="") {
										$where="WHERE id_partner='".$partner."'";
									}
								} else {
									$where="";
								}

								$sql = "SELECT * FROM pm__workinprogress ".$where." ORDER BY wps,period_from,period_to,id_act";
								$result=mysqli_query($conn,$sql);
								if ($result) $count_tot=mysqli_num_rows($result); else $count_tot=0;
								?>

								
								<div style="margin: 25px 0 2px 5px;">
									<p style="float: left;width: 300px;">Found <?=$count_tot?> documents</p>
									<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;"></p>
									<div class="clear"></div>
								</div>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Activities</th>
											<th>Project period</th>
											<th>Partners Institution</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									while ($row=mysqli_fetch_array($result)) { 
										$lnk="./MNG-wip_report.php?id_act=".$row["id_act"]."&wps=".$wps."&partner=".$partner;
										$lnk3="./rsv_pm_wip_stampa.php?id_act=".$row["id_act"];

										$period_from=$row["period_from"];
										$period_from_gg=substr($period_from, -2);
										$period_from_mm=substr($period_from, 4, 2);
										$period_from_aa=substr($period_from, 0,4);
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

										?>
										<tr>
											<td class="td01"><a href="<?=$lnk?>"><?=Pulisci_READ($row["wps"])?></a></td>
											<td><a href="<?=$lnk?>"><?=$period?></a></td>
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
