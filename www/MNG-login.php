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
                        <h1>Partners Login</h1>
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
								  To access to partner's reserved area you need to login.
							</h1>
			

							<br /><br />
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Partners Login
									</span>
								</div>
							</div> -->
			
							<div class="blog-content">
								<div id="page_crp">
									<div class="txt">
										<style>
											input.submit {
												padding: 1px 15px;
												font-size: 1em;
												font-weight: 400;
												color: #fff;
												text-align: center;

												/* verde */
												border-top: 1px solid #ccc;
												background: #006600;
												background: -webkit-gradient(linear, left top, left bottom, from(#33cc33), to(#006600));
												background: -webkit-linear-gradient(top, #33cc33, #006600);
												background: -moz-linear-gradient(top, #33cc33, #006600);
												background: -ms-linear-gradient(top, #33cc33, #006600);
												background: -o-linear-gradient(top, #33cc33, #006600);

												-webkit-border-radius: 6px;
												-moz-border-radius: 6px;
												border-radius: 6px;
											}
										</style>
										<div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
											<p>Please insert your username and password</p>
											<form method="post" action="./impianto/inc/check.php" style="padding: 15px 0;">
												<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 8px;" />
												<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 8px;" />
												<input type="submit" class="submit" value="Login" style="display: block;width: 250px;margin: 10px auto;" />
											</form>
											<p>If you do not have username and password, please contact <script type="text/javascript">makelink( "lorenzo", "pixel-online.net" )</script>.</p>
										</div>
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