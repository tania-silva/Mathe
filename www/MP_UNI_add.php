<?php include('top.php'); ?>
<?php include('./impianto/inc/protectedGuest.php'); //Se non loggato esci...?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-2">
			<?php //include('./impianto/rsv_menu.php'); //Menu?>
			<?php  include('./impianto/spallaSx_LECT.php'); // funzioni PHP ?>
		</div>
		<div id="rsv_crp" class="col-md-10">
			<hr />					
			<!-- INCOLLA START -->





<?php 

if ($_GET["act"]=="reg" AND $usrId) {

	$_SESSION['post_data']=$_POST;

	$name=Pulisci_INS($_POST["name"]);
	$country=Pulisci_INS($_POST["country"]);
	$timezone=Pulisci_INS($_POST["timezone"]);
	$latitude=Pulisci_INS($_POST["latitude"]);
	$longitude=Pulisci_INS($_POST["longitude"]);

	$checkStatus=0;
	if (
		$usrId AND 
		$name AND 
		$country
	) $checkStatus=1;

	if ($checkStatus) {

		$sql = "
			INSERT INTO `platform__university` 
			(`name`, `country`, `timezone`, `latitude`, `longitude`)  
			VALUES ('$name', '$country', '$timezone', '$latitude', '$longitude')";
		$result=mysqli_query($conn,$sql);

		$redirectUrl="./MP_UNI_manageList.php";

	} else $redirectUrl="./MP_UNI_manageList.php?msg=KO";

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
}
?>

					<p class="rsvPage_Title">Insert New University</p>
					<p class="rsvPage_Title1">MathE Platform</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_UNI_add.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Name</label>
							<textarea name="name" id="name" required /></textarea>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Country</label>
							<textarea name="country" id="country" required /></textarea>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Timezone</label>
							<select name="timezone" required>
								<option value="">Please select timezone</option>
								<?php 
								$tmz=generate_timezone_list();
								
								foreach ($tmz as $key => $value) {
									echo "<option value='".$key."'>".$value."</option>";
								}
								?>
							</select>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Latitude</label>
							<input name="latitude" id="latitude" value="" style="width: 100px;" />
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Longitude</label>
							<input name="longitude" id="longitude" value="" style="width: 100px;" />
						</div>


						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_UNI_manageList.php<?=$queryStr?>"><button type="button" class="abort" style="width: 150px;margin-left: 150px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 10px;padding: 5px;" />
						</div>


					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>