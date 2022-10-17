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

$msg=$_GET["msg"];
$act=$_GET["act"];

if ($act=="reg") {

	$_SESSION['post_data']=$_POST;
	//Data recived from registry
	$name=$_POST["name"];
	$surname=$_POST["surname"];
	$email=strtolower($_POST["email"]);
	$email_conf=strtolower($_POST["email_conf"]);
	$password=$_POST["password"];
	$typology=$_POST["typology"];


	$checkStatus=0;
	if (
		$name AND 
		$surname AND 
		$email AND 
		$email_conf AND 
		$password AND 
		$email==$email_conf AND
		chkPassword($password)
	) $checkStatus=1;

	if ($checkStatus) {

		//Insert new user and send confirmation email
		$passCript= md5($password);

		$banned=0;
		if ($typology=="lecturer") $banned==1;


		$sql = "
			INSERT INTO `platform__user` 
			(`name`, `surname`, `username`, `password`, `typology`, `ban`)  
			VALUES ('$name', '$surname', '$email', '$passCript', '$typology', '$banned')";
		$result=mysqli_query($conn,$sql);
		$userId=mysqli_insert_id($conn);

		if ($result) {
			//echo $result;
			/* Code to align the password Forum */
			$nPsw="{\"type\":\"md5\",\"password\":\"".$passCript."\"}";
			$dateNow=Date("Y-m-d H:i:s");
			$fgid = 7;

			if ($typology=="lecturer") {
				$sql2 = "
					INSERT INTO `users` (`id`, `username`, `nickname`, `email`, `is_email_confirmed`, `password`, `bio`, `avatar_url`, `preferences`, `joined_at`, `last_seen_at`, `marked_all_as_read_at`, `read_notifications_at`, `discussion_count`, `comment_count`, `read_flags_at`, `suspended_until`, `password_changed`, `migratetoflarum_old_password`, `blocks_byobu_pd`) VALUES (null, '$email', '$name $surname', '$email', 1, '', NULL, NULL, NULL, '$dateNow', NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '$nPsw', 0)";
				$result2=mysqli_query($connTchForum,$sql2);
                        	$utente_forum=mysqli_insert_id($connTchForum);
                        	$sql ="insert into group_user (user_id,group_id) values (".$utente_forum.",8)";
                        	$result3=mysqli_query($connTchForum,$sql);
				$fgid = 8;
			}

			$sql3 = "
				INSERT INTO `users` (`id`, `username`, `nickname`, `email`, `is_email_confirmed`, `password`, `bio`, `avatar_url`, `preferences`, `joined_at`, `last_seen_at`, `marked_all_as_read_at`, `read_notifications_at`, `discussion_count`, `comment_count`, `read_flags_at`, `suspended_until`, `password_changed`, `migratetoflarum_old_password`, `blocks_byobu_pd`) VALUES (null, '$email', '$name $surname', '$email', 1, '', NULL, NULL, NULL, '$dateNow', NULL, NULL, NULL, 0, 0, NULL, NULL, 0, '$nPsw', 0)";
			$result3=mysqli_query($connStuForum,$sql3);
			$utente_forum=mysqli_insert_id($connStuForum);
			$sql ="insert into group_user (user_id,group_id) values (".$utente_forum.",".$fgid.")";
			$result3=mysqli_query($connStuForum,$sql);


			// Send email with confirmation code
			/********************************************/
			/* Send email to the user to confirm his email */

			$checkcode=Genera_Password();
			
			$sql = "
				UPDATE `platform__user` SET 
				`checkcode`='$checkcode'   
				WHERE (id=$userId AND username='$email')";
			$result=mysqli_query($conn,$sql);
			
			$checkcode=$userId.".".$checkcode;
			$subject="Welcome in MathE Portal - Please confirm your email address";

			$dominio=$_SERVER["HTTP_HOST"];

			$message = "
				<div style=\"padding: 10px 5px;\">
					<b>Hi {$name} {$surname}</b>,<br />
					you activated the registration process to the MathE platform.<br /><br />
					Please verify your email address by clicking on the following link:<br />
					<a href=\"https://{$dominio}/MP_confirmEmail.php?code={$checkcode}\" target=\"_blank\">{$dominio}/MP_confirmEmail.php?code={$checkcode}</a><br /><br />
					You will immediately after receive another email message with your username and password.<br /><br />
				</div>";

			if ($email) {
				$name_from="MathE Platform";
				$mail_from="mathe@ipb.pt";
				$mail_to=$email;
				$mail_cc=""; 
				$mail_bcc=""; 
				$msg_HTML = $message;
				$msg_NOHTML = "To read the message please switch in HTML format";


				$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
				$mail->SMTPOptions = array(								  // Allow hosts with self_signed
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				try {
					//Server settings
					//$mail->SMTPDebug = 1;                                 // Enable verbose debug output
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

					if (!$mail->Send()) {
						//echo "Mailer Error: " . $mail->ErrorInfo . PHP_EOL;
					} else $eResp=true;
				} catch (Exception $e) {
					$eResp=false;
				}
				
				if ($eResp) $email_spedita="1"; // Email contatto richiedente
			}

			/* FINE Invio email all'utente */
			/********************************************/

			//Redirect su messaggio
			$strpas11="./MP_signIn.php?msg=OK";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
			$_SESSION['post_data']="";
			die();

		} else {
			//Redirect su messaggio
			$strpas11="./MP_signIn.php?msg=KO&error=k01";
			print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
			die();
		}

	} else {
		if (!chkPassword($password)) $error="ko2";

		//Redirect su messaggio
		$strpas11="./MP_signIn.php?msg=KO&error=".$error;
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		die();
	}

}

?>



	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Sign Up To MathE Platform</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog detail -->
        <section class="single section-padding-large">
            <div class="container">
                <div class="row">
					
	<div class="col-1"></div>
	<div class="col-10">
	<div class="single-content">

							<!-- <nav aria-label="breadcrumb">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item">MathE Platform</li>
								</ul>
							</nav> -->

							<!-- <h1 class="single-title">
								Thanks for deciding to join the MathE Community. By registering to the portal you will be able to:<br>
								- Carry out a self-evaluation of your knowledge on selected Math topics.<br>
								- Participate in the final evaluations of your teacher, if your university officially joined the community

							</h1>
			
							<div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Sign Up To MathE Platform
									</span>
								</div>
							</div> -->
				
							<!-- START contenuto pagina -->
							<div id="page_crp">


<style>

div.signup_field {
	margin: 0 0 0 0;
}
div.signup_field label {
	margin: 30px 0 0 0;
	padding-right: 5px;
	font-size: 1.2em;
	font-weight: 400;
	color: #444;
}
div.signup_field input {
	width: 210px;
	padding: 3px;
	font-size: 1.2em;
	border: none;
	border: dotted 1px #00aeef;
}


/* Completa profilo */
div.signup_field1 {
	margin: 15px 0 0 0;
}
div.signup_field1 label {
	margin: 30px 0 0 0;
	padding-right: 5px;
	font-size: 1.0em;
	color: #999;
}
div.signup_field1 input {
	width: 210px;
	padding: 3px;
	font-size: 1.1em;
	border: none;
	border: dotted 1px #00aeef;
}

div.signup_field_ext {
	margin: 15px 0 0 18px;
}
div.signup_field_ext label {
	margin: 30px 0 0 0;
	padding-right: 5px;
	font-size: 1.0em;
	color: #999;
}
div.signup_field_ext input {
	display: block;
	width: 630px;
	margin: 0 0 0 0;
	padding: 3px;
	font-size: 1.1em;
	border: none;
	border: dotted 1px #00aeef;
}
div.signup_field_ext input.radiobutt {
	float: left;
	width: 30px;
	height: 30px;
	margin: 0 5px 0 0 ;
}
div.signup_field_ext label.radiobutt {
	float: left;
	width: 50px;
	margin: 3px 0 0 0;
	color: #000;
}
div.signup_field_ext textarea {
	display: block;
	width: 630px;
	margin: 0 0 0 0;
	padding: 3px;
	font-size: 1.1em;
	border: none;
	border: dotted 1px #00aeef;
}


div.signup_submit input.submit {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 70px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
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
div.signup_submit input.proceed {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
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
div.signup_submit input.notValidate {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* rosso */
	border-top: 1px solid #ccc;
	background: #d22d39;
	background: -webkit-gradient(linear, left top, left bottom, from(#fb040b), to(#c20338));
	background: -webkit-linear-gradient(top, #fb040b, #c20338);
	background: -moz-linear-gradient(top, #fb040b, #c20338);
	background: -ms-linear-gradient(top, #fb040b, #c20338);
	background: -o-linear-gradient(top, #fb040b, #c20338);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}
div.signup_submit button.abort {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* rosso */
	border-top: 1px solid #ccc;
	background: #d22d39;
	background: -webkit-gradient(linear, left top, left bottom, from(#fb040b), to(#c20338));
	background: -webkit-linear-gradient(top, #fb040b, #c20338);
	background: -moz-linear-gradient(top, #fb040b, #c20338);
	background: -ms-linear-gradient(top, #fb040b, #c20338);
	background: -o-linear-gradient(top, #fb040b, #c20338);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}
div.signup_submit button.edit {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* blu */
	border-top: 1px solid #ccc;
	background: #3300ff;
	background: -webkit-gradient(linear, left top, left bottom, from(#3366ff), to(#000099));
	background: -webkit-linear-gradient(top, #3366ff, #000099);
	background: -moz-linear-gradient(top, #3366ff, #000099);
	background: -ms-linear-gradient(top, #3366ff, #000099);
	background: -o-linear-gradient(top, #3366ff, #000099);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}
div.signup_submit button.proceed {
	width: auto;
	margin: 30px 0 0 0;
	padding: 5px 105px;
	font-family: 'Oswald', sans-serif;
	font-size: 1.5em;
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



							
								<?php if ($msg=="OK") {?>
									<p style="font-size: 2.0em;text-align: center;">Thank you for your request.</p>
									<p style="font-size: 1.5em;text-align: center;">We sent you an email message.<br />In order to activate your account,<br />please click on the link in the message.</p>

								<?php } else {?>


								 <!-- 	<p style="font-size: 1.2em;">Thanks for deciding to join the MathE Community. By registering to the portal you will be able to:</p>
									<ul style="font-size: 1.2em;margin: 5px 0 0 -15px;">
										<li>to carry out a self-evaluation of your knowledge on selected Math topics.</li>
										<li>if your university officially joined the community, to participate in the final evaluations of your teacher</li>
									</ul> -->
						  
              <p style="font-size: 1.2em;">Thanks for deciding to join the MathE Community.<br /> <br />
									
										By registering to the portal, as a <strong>student</strong> 
                        <ul style="font-size: 1.2em;margin: 5px 0 0 -15px;">
                            <li>You will be able to carry out a self-evaluation of your knowledge on selected Math topics.</li> 
                            <li>If your university officially joined the community, you will be able to participate in the final evaluations conducted by your teacher.</li>
							          </ul> 
                    <br />    
                    <p style="font-size: 1.2em;">By registering to the portal, as a <strong>lecturer</strong> 
                        <ul style="font-size: 1.2em;margin: 5px 0 0 -15px;">
                            <li>You will be able to help students identify their gaps in Math and provide them with appropriate digital resources to remedy these gaps.</li> 
                            <li>If your university officially joined the community, you will be able to create your own assessments for your students.</li>
							          </ul>
									
									<?php if ($_GET["msg"]=="KO") {?>
										<div style="margin-top: 25px;padding: 15px;font-size: 1.2em;border: solid 1px #f00;border-radius: 5px;">
											<ul style="margin-left: 35px;">
												<?php if ($_GET["error"]=="k01") {?><li>The email address you entered is already registered on the portal.<br />Please choose a different email address or click on "Forgot your Password" to receive a new one.</li><?php }?>
												<?php if ($_GET["error"]=="ko2") {?><li>The password must contain only numbers and letters and it should be of at least 8 characters.</li><?php }?>
											</ul>
										</div>
									<?php }?>
									
									<form method="post" action="./MP_signIn.php?act=reg" style="display: block;margin-top: 30px;padding: 20px 40px 20px 40px;border: solid 1px #00aeef;border-radius: 10px;background-color: #fff;">
										
										<div class="signup_field">
											<label style="margin-left: 2%;margin-right: 5%;">Name</label>
											<input type="text" name="name" value="<?=$_SESSION['post_data']['name']?>" required />
											<label style="margin-left: 2%;margin-right: 2%;">Surname</label>
											<input type="text" name="surname" value="<?=$_SESSION['post_data']['surname']?>" required />
										</div>
										
										<div class="signup_field">
											<label style="margin-left: 2%;margin-right: 5%;">Email</label>
											<input type="text" name="email" value="<?=$_SESSION['post_data']['email']?>" required />
											<label style="margin-left: 2%;margin-right: 2%;">Email Confirmation</label>
											<input type="text" name="email_conf" value="<?=$_SESSION['post_data']['email_conf']?>" required />
										</div>
										
										<div class="signup_field">
											<label style="margin-left: 2%;margin-right: 5%;">Password</label>
											<input type="password" name="password" value="<?=$_SESSION['post_data']['password']?>" required />
										</div>

										<div class="signup_field" style="width: 100%;">
											<p style="padding-top: 20px;font-size: 1.2em;">Please specify if you are a:</p>
											<p style="margin: 0;padding: 0;line-height: 1.0em;"><input type="radio" name="typology" value="student" <?php if ($_SESSION['post_data']['typology']=="student") echo "checked=\"checked\"";?> style="width: 25px;" required />
											<label style="font-size: 1.2em;text-transform: uppercase;">student</label></p>
											<p style="margin: 0;padding: 0;line-height: 1.0em;"><input type="radio" name="typology" value="lecturer" <?php if ($_SESSION['post_data']['typology']=="lecturer") echo "checked=\"checked\"";?> required style="width: 25px;" />
											<label style="font-size: 1.2em;text-transform: uppercase;">lecturer</label></p>
										</div>

										<div style="padding-top: 20px;">
											<p style="padding: 0 0 5px 0;font-size: 1.2em;font-weight: 400;color: #264869;">Confirmation of registration</p>
											<p>Hereby I confirm that I would like to register on the project portal of the Erasmus+ project MathE.</p>
										</div>

										<div style="padding-top: 20px">
											<p style="padding: 0 0 5px 0;font-size: 1.2em;font-weight: 400;color: #264869;">Agreement for electronic use of personal data</p> 
											<p style="padding: 0 0 5px 0;">I further agree that my personal data (full name, email) get collected and processed for</p>
											<ul style="margin-left: -15px;">
												<li>Reporting and audits of the Erasmus+ Portuguese national agency or any other organization indicated by the European Commission.</li>
												<li>Contacting me via email for information material related to the project</li>
												<li>Statistical purposes</li>
											</ul>
										</div>

										<div class="signup_submit" style="display: block; margin: 0 auto;">
											<input type="submit" value="Proceed" class="submit" style="padding: 5px 10px;" />
										</div>

									</form>
								<?php }?>
						






							</div> <!-- page_crp -->
							<!-- END contenuto pagina -->
				
				
						</div> <!-- single-content -->
					</div> <!-- col-8 -->
					<div class="col-1"></div>
				
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
