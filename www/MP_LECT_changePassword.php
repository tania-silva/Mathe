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

if ($_GET["act"]=="reg") {

	$userId=$_POST["usrId"];
	$passOld=$_POST["passOld"];
	$passNew1=$_POST["passNew1"];
	$passNew2=$_POST["passNew2"];
	$usr_password="";

	// Retrive current password
		$sql = "
			SELECT * 
			FROM platform__user 
			WHERE id=$userId 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$usr_username=$row["username"];
			$usr_password=$row["password"];
		}

	if (
		$usr_password==md5($passOld) AND 
		$passNew1==$passNew2
	) $chk_status=1;

	if ($chk_status==1) {
		
		$passCript=md5($passNew1);

		$sql = "
			UPDATE `platform__user` 
			SET 
				password='$passCript' 
			WHERE id='$userId'";
		$result=mysqli_query($conn,$sql);

		if ($result) {
			$msg="ok0";

			/* Codice per allineare password Forum */
			$nPsw="{\"type\":\"md5\",\"password\":\"".$passCript."\"}";

			$sql2 = "
				UPDATE `users` 
				SET `migratetoflarum_old_password` = '$nPsw' 
				WHERE `users`.`username` = '$usr_username';";
			$result2=mysqli_query($connTchForum,$sql2);

			$sql3 = "
				UPDATE `users` 
				SET `migratetoflarum_old_password` = '$nPsw' 
				WHERE `users`.`username` = '$usr_username';";
			$result3=mysqli_query($connStuForum,$sql3);
		}

	} else $msg="ko0";

	// Redirect
	$strpas11="./MP_LECT_changePassword.php?userId={$userId}&msg={$msg}";
	print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
	die();

} else {
	
	$userId=mysqli_real_escape_string($conn, $_GET["userId"]);
	
	if ($userId==$usrId AND $usrCode) {

		$sql = "
			SELECT * 
			FROM  platform__user 
			WHERE (id='$usrId' AND (checkcode='$usrCode' OR guid='$usrCode')) 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		$find=mysqli_num_rows($result);
			
		if ($find==1) {

			while ($row=mysqli_fetch_array($result)) {
				$usr_name=$row["name"];
				$usr_surname=$row["surname"];
				$usr_email=$row["username"];
				$usr_typology=$row["typology"];
				$usr_completeProfile=$row["completeProfile"];
			}

			$sql = "
				SELECT * 
				FROM  platform__lecturers 
				WHERE (id_lect='$usrId') 
				LIMIT 1";
			$result=mysqli_query($conn,$sql);
			$find=mysqli_num_rows($result);
			
			if ($find==1) {
				while ($row=mysqli_fetch_array($result)) {
					$usr_email=$row["email"];
					$usr_fieldOfResearch=$row["field_of_research"];
					$usr_subjectTaught=$row["subject_taught"];
					$usr_yearsOfExperience=$row["years_of_experience"];
					$usr_profile=$row["profile"];
					$uniName=$row["uni_name"];
					$uniDepartment=$row["uni_department"];
					$uniCity=$row["uni_city"];
					$uniAddress=$row["uni_address"];
				}
			}
		}
	} else {
		// I codici di ingresso non sono validi
		$strpas11="./impianto/inc/logout.php";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		die();
	}
}
?>
					<p class="rsvPage_Title">Change Your Password</p>

						
					<?php if ($_GET["msg"]=="ok0") {?>
						<div style="margin-top: 25px;padding: 15px;border: solid 1px #070;border-radius: 5px;">
							<p style="font-size: 1.5em;font-weight: 600;text-align: center;color: #070;">Your password is updated.</p>
						</div>
					<?php }?>
					<?php if ($_GET["msg"]=="ko0") {?>
						<div style="margin-top: 25px;padding: 15px;border: solid 1px #f00;border-radius: 5px;">
							<p style="font-size: 1.1em;font-weight: 600;text-align: center;">The data you have entered doesn't match</p>
							<p style="font-size: 1.5em;font-weight: 600;text-align: center;color: #c00;">Your password is not updated.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_LECT_changePassword.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p class="titpar" style="margin: 0px 45px 35px 17px;font-size: 1.5em;font-weight: 400;border-bottom: solid 2px #00aeef;color: #00aeef">CHANGE PASSWORD</p>

						<input type="hidden" name="usrId" value="<?=$usrId?>" />
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Old Password</label>
							<input type="password" name="passOld" value="" style="width: 270px;" required />
						</div>

						<div>
							<div class="signup_field_ext" style="width: 320px;float: left;">
								<label style="font-weight: 400;color: #c00;">* New Password</label>
								<input type="password" name="passNew1" value="" style="width: 270px;" required />
							</div>
							
							<div class="signup_field_ext" style="width: 320px;float: right;">
								<label style="font-weight: 400;color: #c00;">* Repeat New Password</label>
								<input type="password" name="passNew2" value="" style="width: 270px;" required />
							</div>
							<div class="clear"></div>
						</div>

						<div class="signup_submit">
							<input type="submit" value="Proceed" class="submit" style="display: block;margin: 50px auto 0 auto;" />
						</div>

					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>