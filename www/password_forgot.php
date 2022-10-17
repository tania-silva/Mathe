<?php
include('./top.php'); // funzioni PHP
?>
<?php

/* PhpMailer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "./impianto/addons/PHPMailer/src/PHPMailer.php";
require "./impianto/addons/PHPMailer/src/SMTP.php";
require "./impianto/addons/PHPMailer/src/Exception.php";


$username="";
if (isset($_POST["username"])) $username=strtolower($_POST["username"]);

if ($username) {
	
	$sql = "
		SELECT * 
		FROM  platform__user 
		WHERE (username='$username') 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	$find=mysqli_num_rows($result);
		
	if ($find==1) {
		while ($row=mysqli_fetch_array($result)) {
			$usr_id=$row["id"];
			$usr_par02=$row["name"]." ".$row["surname"];
			$usr_par03=$row["username"];
			$usr_typology=$row["typology"];
		}

		$usr_email="";

		if ($usr_typology=="lecturer") {
			// Email dell'insegnante
			$sql = "
				SELECT * 
				FROM  platform__lecturers 
				WHERE (id_lect='$usr_id') 
				LIMIT 1";
			$result=mysqli_query($conn,$sql);
				
			while ($row=mysqli_fetch_array($result)) {
				$usr_email=$row["email"];
			}
		}
		if ($usr_typology=="student") {
			// Email dello studente
			$sql = "
				SELECT * 
				FROM  platform__students 
				WHERE (id_stud='$usr_id') 
				LIMIT 1";
			$result=mysqli_query($conn,$sql);
				
			while ($row=mysqli_fetch_array($result)) {
				$usr_email=$row["email"];
			}
		}

		if ($usr_email) {

			$password=Genera_Password();
			$passCript= md5($password);
			
			$sql = "
				UPDATE `platform__user` SET 
				`password`='$passCript'   
				WHERE id=$usr_id";
			$result=mysqli_query($conn,$sql);

                        /* Codice per allineare password Forum */
                        $nPsw="{\"type\":\"md5\",\"password\":\"".$passCript."\"}";

                        $sql2 = "
                                UPDATE `users` 
                                SET `migratetoflarum_old_password` = '$nPsw' 
                                WHERE `users`.`username` = '$usr_par03';";
                        $result2=mysqli_query($connTchForum,$sql2);

                        $sql3 = "
                                UPDATE `users` 
                                SET `migratetoflarum_old_password` = '$nPsw' 
                                WHERE `users`.`username` = '$usr_par03';";
                        $result3=mysqli_query($connStuForum,$sql3);

			if ($result AND $usr_email) {

				// Invio email con codice per conferma

				/********************************************/
				/* Invio email all'utente per conferma email */
				$subject="MathE Portal - Password Forgot";

				$dominio=$_SERVER["HTTP_HOST"];

				$message = "
					<div style=\"padding: 10px 5px;\">
						<b>Hi {$name} {$surname}</b>,<br />
						you requested a new password to access MathE platform.<br /><br />
						In order to access the portal you need to log in at the <a href=\"http://{$dominio}/index.php\" target=\"_blank\">MathE Portal Home Page</a> using your credentials:<br /><br />
						username: <b>{$usr_par03}</b><br />
						password: <b>{$password}</b><br /><br />
						Enjoy!<br />
						The MathE team
					</div>";

				$name_from="MathE Platform";
				$mail_from="mathe@ipb.pt";
				$mail_to=$usr_email;
				$mail_cc=""; 
				$mail_bcc=""; 
				$msg_HTML = $message;
				$msg_NOHTML = "To read the message please switch in HTML format";

				$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
				try {
					//Server settings
					$mail->SMTPDebug = 0;                                 // Enable verbose debug output
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = $mailHost;  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = $mailUsername;                 // SMTP username
					$mail->Password = $mailPassword;                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = $mailPort;                                    // TCP port to connect to

					//Recipients
					$mail->setFrom($mail_from, $name_from);
					$mail->addAddress($mail_to);               // Name is optional

					//Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = $subject;
					$mail->Body    = $msg_HTML;
					$mail->AltBody = $msg_NOHTML;

					$mail->send();
					$eResp=true;
				} catch (Exception $e) {
					$eResp=false;
				}
				
				if ($eResp) $email_spedita="1"; // Email contatto richiedente

				/* FINE Invio email all'utente */
				/********************************************/

				// Redirect
				$strpas11="./password_forgot.php?msg=OK";
				print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
				die();

			} else {

				// Redirect
				$strpas11="./password_forgot.php?msg=KO";
				print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
				die();

			}
		} else {

			// Redirect
			$strpas11="./password_forgot.php?msg=KO";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
			die();

		}
	} else {

			// Redirect
			$strpas11="./password_forgot.php?msg=KO";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
			die();

	}
}

?>

<style>

input.submit {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 25px;
	font-size: 1.3em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* verde */
	border-top: 1px solid #ccc;
	background: #1d6d18;
	background: -webkit-gradient(linear, left top, left bottom, from(#69c22e), to(#387016));
	background: -webkit-linear-gradient(top, #69c22e, #387016);
	background: -moz-linear-gradient(top, #69c22e, #387016);
	background: -ms-linear-gradient(top, #69c22e, #387016);
	background: -o-linear-gradient(top, #69c22e, #387016);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

</style>


    <main>
        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Password Forgot</h1>
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
								  To access to platform area you need to login.
							</h1>
			
							<div class="blog-content">
								<div id="page_crp">
									<div class="txt" style="padding-top: 25px;">

										<!-- <div style="padding: 15px 0 35px 0;font-size: 1.2em;text-align: center;">
											<p>Please insert your username and password</p>
											<form method="post" action="./impianto/inc/check.php" style="padding: 15px 0;">
												<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 3px;" />
												<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="width: 30%;	margin: 0;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 3px;" />
												<input type="submit" class="submit" value="" style="width: 27px;height: 22px;margin: 0 12px 0 5px;padding: 2px 5px;cursor: pointer;border: solid 1px #777;border-radius: 7;background: url('./impianto/img/icone/ra_submit.png') #f4d19d no-repeat 5px 4px;" />
											</form>
											<p>If you do not have username and password, please contact <script type="text/javascript">makelink( "lorenzo", "pixel-online.net" )</script>.</p>
										</div> -->

			<?php if ($_GET["msg"]) {?>
				<?php if ($_GET["msg"]=="OK") {?>
					<div style="padding: 25px 0;text-align: center;">
						<h1>Process Complete</h1>
						<p style="padding-top: 10px;font-size: 1.2em;text-align: center;color: #444;">We have send you an email with the new password</p>
						<div class="clear"></div>
					</div>
				<?php } else {?>
					<div style="padding: 25px 0;text-align: center;">
						<h1>Sorry!</h1>
						<p style="padding-top: 10px;font-size: 1.2em;text-align: center;color: #444;">the email address you inserted is not registered on the platform</p>
						<div class="clear"></div>
					</div>
				<?php }?>
			<?php } else {?>
				<form method="post" action="./password_forgot.php" style="padding: 15px 0;">
					<p>Insert the email address you register with in order to receive a message with the new password</p>
					<p><input type="text" name="username" placeholder="email" style="float: left;width: 50%;margin: 12px 0 0 30px;padding: 6px 5px;border: dotted 1px #66cdff;" /><input type="submit" class="submit" value="send" style="float: left;margin: 10px 0 0 10px;" /></p>
					<div class="clear"></div>
				</form>
			<?php }?>


									</div>
								</div>
							</div>





						</div> <!-- single-content -->
					 </div> <!-- col-8 -->
					<div class="col-2"></div>
				</div>
			</div>
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
