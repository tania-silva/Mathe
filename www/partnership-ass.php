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
                        <h1>Associated Partners</h1>
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
				
							<h1 class="single-title">
								As a result of the exploitation activity a number of associated partners officially joined the project in order to contribute to the improvement of the project impact on their target groups and to ensure the project sustainability by continuing using the project deliverables in the next years.
							</h1>
							<h5>
								The associate partners of the MathE project are organizations interested in scientific education.  All associated partners share the project objectives and are willing to contribute to their achievement.
								<br>
								Institutions and organisations interested in becoming associated partners of the MathE project can contact the national coordinators of the project.
							</h5>

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

				



								<?php
								$sql = "
									SELECT * 
									FROM members_apartners 
									ORDER BY sch_name ASC";
								$result=mysqli_query($conn, $sql);
								if ($result) $n_doc=mysqli_num_rows($result);

								if ($n_doc) {

									?>
									<table class="table table-hover" style="margin-top: 45px;">
										<thead>
											<tr>
												<th>Name</th>
												<th>Type of Institution</th>
												<th>Country</th>
											</tr>
										</thead>
										<tbody>
									<?php

									while ($row=mysqli_fetch_array($result)) { 
										$sch_id=$row["id_asch"];
										$sch_id_partner=$row["id_partner"];
										
										$sch_name=Pulisci_READ($row["sch_name"]);
										$sch_address=Pulisci_READ($row["sch_address"]);
										$sch_type=Pulisci_READ($row["sch_type"]);
										$sch_country=Pulisci_READ($row["sch_country"]);

										$sql33 = "
											SELECT * 
											FROM partner 
											WHERE id_partner=".$sch_id_partner;
										$result33=mysqli_query($conn, $sql33);

										$prt_name="";
										$prt_country="";
										while ($row33=mysqli_fetch_array($result33)) { 
											$prt_name=$row33["name"];
											$prt_country=$row33["country"];
										}



										?>
											<tr>
												<td class="bold" style="font-size: 1.0em;line-height: 1.1em;"><a href="./partnership-ass_scheda.php?id_sch=<?=$sch_id?>&part_id=<?=$sch_id_partner?>&par=<?=$par?>"><?=$sch_name?></a></td>
												<td><?=$sch_type?></td>
												<td><?=$sch_country?></td>
											</tr>
										<?php
									}
									?>
										</tbody>
									</table>
									<?php
								} else {?>
									<div class="txt" style="padding-top: 0px;font-size: 1.1em;">
										<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Sorry</div>
										<div class="cnt02">No Associated Partners are yet available</div>
									</div>
								<?php } ?>	








									

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
