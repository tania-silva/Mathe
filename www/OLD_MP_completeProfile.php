<?
include('./impianto/inc/function.php'); // funzioni PHP

$code_ar=explode("|",base64_decode($_SESSION["guest"]));	
$id_usr=$code_ar[0];
$id_code=$code_ar[1];

if ($_GET["act"]=="reg") {

	$userId=$_POST["usrId"];
	$name=$_POST["name"];
	$surname=$_POST["surname"];
	$email=$_POST["email"];
	$fieldOfResearch=$_POST["fieldOfResearch"];
	$subjectTaught=$_POST["subjectTaught"];
	$yearsOfExperience=$_POST["yearsOfExperience"];
	$profile=$_POST["profile"];
	$uniName=$_POST["uniName"];
	$uniDepartment=$_POST["uniDepartment"];
	$uniCountry=$_POST["uniCountry"];
	$uniCity=$_POST["uniCity"];
	$uniAddress=$_POST["uniAddress"];

} else {
	
	$userId=mysql_real_escape_string($_GET["userId"]);
	
	if ($userId==$id_usr AND $id_code) {

		$sql = "
			SELECT * 
			FROM  platform__user 
			WHERE (id='$id_usr' AND checkcode='$id_code') 
			LIMIT 1";
		$result=mysql_query($sql,$conn);
		$find=mysql_num_rows($result);
			
		if ($find==1) {

			while ($row=mysql_fetch_array($result)) {
				$usr_name=$row["name"];
				$usr_surname=$row["surname"];
				$usr_email=$row["email"];
				$usr_typology=$row["typology"];
			}
		}
	} else {
		// I codici di ingresso non sono validi
		header("location: ./denied.php"); die();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
<head>
	<title><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="Generator" content="AmeeIV" />
	<meta name="Author" content="Ing. Francesco Pinzani" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/struttura.css" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/mathePortal.css" />
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
</head>

<body>
	<div id="container">
		<? include('./impianto/cappello.php'); //PIEDE?>
		<? include('./impianto/testa.php'); //PIEDE?>
		<div id="cnt1">
			<div id="corpo">

			
				<h1>Sign Up To MathE Platform</h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > MathE Platform > Sign up</p>

				<div id="page_sx">
					<img src="./impianto/img/sx_diss.jpg" width="190" height="112" alt="" class="ntr" />
					<div class="intro">Praesent vitae ante justo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam vitae urna vel nulla tincidunt faucibus aliquet congue nisi. Suspendisse tristique mi sit amet neque placerat mollis. Curabitur porta tincidunt varius. Aliquam vitae iaculis est. Nullam condimentum eleifend lorem, in sodales erat porta quis. Morbi suscipit mauris vel tellus tristique gravida. Proin purus nisl, mollis eu sodales at, condimentum facilisis justo. In eu enim vitae purus rhoncus vulputate. Duis accumsan facilisis felis, ut interdum lorem mollis at. </div>
				</div>
				<div id="page_crp">


					<? if ($msg=="OK") {?>

						<p style="font-size: 2.0em;text-align: center;">Thank you for your request.<br />We have send you an email.</p>

					<?} else {?>


						<p style="font-size: 1.2em;">Grazie per esserti iscritto alla piattaforma MathE.<br />Prima di procedere ti chiediamo di completare il tuo profilo compilando il modulo sottostante.</p>
						
						<? if ($_GET["msg"]=="KO") {?>
							<div style="margin-top: 25px;padding: 15px;font-size: 1.2em;border: solid 1px #f00;border-radius: 5px;">
								Sorry but there's an error.
								<ul style="margin-left: 35px;">
									<? if ($_GET["error"]=="k01") {?><li>the email address is yet registered in our portal. Choose another one or click on "Forgive Password" to receive a new one.</li><?}?>
								</ul>
							</div>
						<?}?>


						<!-- <? if ($usr_typology=="lecturer") include('./impianto/inc/LECT_profile.php'); ?>
						<? if ($usr_typology=="student") include('./impianto/inc/STUD_profile.php'); ?> -->

						<? if ($usr_typology=="lecturer") include('./impianto/inc/STUD_profile.php'); ?>




					<?}?>
					
					
					
				</div> <!-- page_crp -->


				<div class="clear"></div>
			</div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<? include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
