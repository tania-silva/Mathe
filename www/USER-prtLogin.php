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
                        <h1>User Login</h1>
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
									<li class="breadcrumb-item">MathE Platform</li>
								</ul>
							</nav>

							<h1 class="single-title">
								  To access to the reserved area you need to login.
							</h1>
			
							<div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>User Login
									</span>
								</div>
							</div>
			
							<div class="blog-content">
								<div id="page_crp">
									<div class="txt">

										<div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
											<p>Please insert your username and password</p>
											<form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0;">
												<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 3px;" />
												<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 3px;" />
												<input type="submit" class="submit" value="" style="width: 27px;height: 22px;margin: 0 12px 0 5px;padding: 2px 5px;cursor: pointer;border: solid 1px #777;border-radius: 7;background: url('./impianto/img/icone/ra_submit.png') #f4d19d no-repeat 5px 4px;" />
											</form>
										</div>
										<p>If you do not have username and password, please <a href="./MP_signIn.php">register to the portal</a>.</p>

									</div>
								</div>
							</div>


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