<?php 
include('./impianto/inc/function.php'); // funzioni PHP

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MathE</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href='vendor/animate/animate.css' />

    <!-- Main CSS File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
</head>
<body>

<?php include("header.php"); ?>

	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Students</h1>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
			    <li class="breadcrumb-item"><a href="index.php">Partnership</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
                        </ul>
                    </nav>
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
				
                                <h2 class="single-title">
                                    From this section it is possible to access to the information related to the students involved in the MathE project in the 5 European partner countries
                                </h2>
				
                                <div class="info">
                                    <div class="entry">
                                        <span class="categories">
                                            <i class="fas fa-tag"></i>Partnership
                                        </span>
                                    </div>
                                </div>
				
				<!-- START contenuto pagina -->
				
                                <!-- <div class="blog-content">
                                    <div class="desc">
                                        <span style="font-size: 80px">#</span>
                                        <p>&nbsp;Coming Soon</p>
                                    </div>
                                    <p>
                                        No Students are yet available<br>
                                    </p>
                                </div> -->

				
                                <div id="page_crp">
					<div class="txt">


						<?php 
						$sql = "
							SELECT * 
							FROM PRT_student 
							ORDER BY qst02 ASC";

						$result=mysqli_query($conn,$sql);
						$n_doc=mysqli_num_rows($result);

						if ($n_doc) {

							?>
							<table class="for2" style="font-size: 1.1em;">
								<thead>
									<tr>
										<td style="width: 100%">Name and Surname</td>
										<td><img src="./wiztr.gif" width="300" height="1" />University</td>
										<td><img src="./wiztr.gif" width="150" height="1" />Country</td>
									</tr>
								</thead>
								<tbody>
							<?php 

							while ($row=mysqli_fetch_array($result)) { 
								$sch_id=$row["id_asch"];
								$sch_id_partner=$row["id_partner"];
								
								$qst02=Pulisci_READ($row["qst02"]);
								$qst06=Pulisci_READ($row["qst06"]);
								$qst20=Pulisci_READ($row["qst20"]);
								if (strtolower($qst20)=="choose country") $qst20="";

								$par_permit="off";
								if (($id_partner==$row["doc_id_partner"] && $_SESSION["usr_level"]>=2) || $_SESSION["usr_level"]==5) $par_permit="on";
								$adm_permit="off";
								if ($_SESSION["usr_level"]==5) $adm_permit="on";

	//							$sql33 = "
	//								SELECT * 
	//								FROM partner 
	//								WHERE id_partner=".$sch_id_partner;
	//							$result33=mysql_query($sql33,$conn);
	//
	//							$prt_name="";
	//							$prt_country="";
	//							while ($row33=mysql_fetch_array($result33)) { 
	//								$prt_name=$row33["name"];
	//								$prt_country=$row33["country"];
	//							}



								?>
									<tr>
										<td class="bold" style="font-size: 1.0em;line-height: 1.1em;"><a href="./PRTN_students_scheda.php?id_sch=<?=$sch_id?>&part_id=<?=$sch_id_partner?>&par=<?=$par?>"><?=$qst02?></a></td>
										<td><?=$qst06?></td>
										<td><?=$qst20?></td>
									</tr>
								<?php 
							}
							?>
								</tbody>
							</table>
							<?php 
						} else {?>
							<div class="tit_lrg01"><img class="pt2" src="./wiztr.gif" alt="" />Sorry</div>
							<div class="cnt02">No Students are yet available</div>
						<?php  } ?>

						
				</div> <!-- page_crp -->

				
				<!-- END contenuto pagina -->
				
				
			</div> <!-- single-content -->
		    </div> <!-- col8 -->
			
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