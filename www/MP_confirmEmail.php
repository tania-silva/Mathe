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
					<h1>Access Denied</h1>
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
								<li class="breadcrumb-item">Access Denied</li>
							</ul>
						</nav>
										
						<!-- START contenuto pagina -->
						<div id="page_crp">

					
					
					
					
					
					
					
<?php 

/* PhpMailer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "./impianto/addons/PHPMailer/src/PHPMailer.php";
require "./impianto/addons/PHPMailer/src/SMTP.php";
require "./impianto/addons/PHPMailer/src/Exception.php";

$code=mysqli_real_escape_string($conn,$_GET["code"]);
$check_email="0";

if ($code) {

	$code_ar=explode(".",$code);	
	$id_usr=$code_ar[0];
	$id_code=$code_ar[1];

	if ($id_usr AND $id_code) {
	
		$sql = "
			SELECT * 
			FROM  platform__user 
			WHERE (id='$id_usr' AND checkcode='$id_code') 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		if ($result) $find=mysqli_num_rows($result);
			
		if ($find==1) {

			while ($row=mysqli_fetch_array($result)) {
				$usr_par02=$row["name"]." ".$row["surname"];
				$usr_par03=$row["username"];
				$usr_code=$row["checkcode"];
				$usr_typology=$row["typology"];
			}

			//$usr_pass = Genera_Password();
			//$cryptPass=getHash($usr_pass);
			
			// Inserisco nella lista degli utenti
			$sql = "
				UPDATE `platform__user` SET 
				`verifyEmail`=1   
				WHERE id=$id_usr";
			$result=mysqli_query($conn,$sql);

			if ($usr_typology=="student") $pageRedirect="MP_STUD_completeProfile.php";
			elseif ($usr_typology=="lecturer") $pageRedirect="MP_LECT_completeProfile.php";
			else {
				header("location: ./impianto/inc/logout.php");
				die();
			}

			$_SESSION["guest"]=base64_encode($id_usr."|".$usr_code."|".$usr_typology);

			/********************************************/
			/* Invio email al responsabile con i codici di accesso */
			
			$subject="Welcome in MathE Portal";
			
			$dominio=$_SERVER["HTTP_HOST"];

			$message = "
				<div style=\"padding: 10px 5px;\">
					<b>Hi {$usr_par02}</b>,<br />
					the registration process is finished and you can now complete your profile.<br />
					In order to access the portal you need to log in at the <a href=\"http://{$dominio}/index.php\" target=\"_blank\">MathE Portal Home Page</a> using your credentials:<br /><br />
					username: <b>{$usr_par03}</b><br />
					password: <b>the one you chose</b><br /><br />
					Enjoy!<br />
					The MathE team
				</div>";

			if ($usr_par03) {
				$name_from="MathE Platform";
				$mail_from="mathe@ipb.pt";
				$mail_to=$usr_par03;
				$mail_cc=""; 
				$mail_bcc=""; 
				$msg_HTML = $message;


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

				if ($eResp) $check_email="1"; // Email contatto richiedente
			}

			/* FINE Invio email all'utente */
			/********************************************/

			echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
			echo "document.location.href='./".$pageRedirect."?userId=".$id_usr."';";
			echo "</SCRIPT>";

		}
	}
}
?>

<div style="">
	<?php
	if ($check_email!=1) {
		?>
			<p style="width: 60%;margin: 50px auto; padding: 15px;font-size: 1.0em;text-align: center;border: solid 3px #a40000;border-radius: 5px;background-color: #fff;"><strong style="font-size: 1.4em;font-weight: 400;">Questo link è scaduto.</strong><br />Se sei già registrato inserisci le tue credenziali per accedere a MathE Platform altrimenti registrati <a href="./MP_signIn.php">cliccando qui</a>.</p>
		<?php
	}
	?>
</div>

					
					
					
					
					
					
					
					</div> <!-- page_crp -->
					<!-- END contenuto pagina -->
					
				<div class="col-2"></div>
			</div> <!-- row -->
		</div> <!-- container -->
	</section>
</main>
<?php include('./impianto/inc/bottom.php'); //PIEDE?>
