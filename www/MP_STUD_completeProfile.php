<?php include('top.php'); ?>
<?php include('./impianto/inc/protectedGuest.php'); //Se non loggato esci...?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-2">
			<?php //include('./impianto/rsv_menu.php'); //Menu?>
			<?php  include('./impianto/spallaSx_STUD.php'); // funzioni PHP ?>
		</div>
		<div id="rsv_crp" class="col-md-10">
			
			<hr />					
			<!-- INCOLLA START -->






					
					
					
<?php

//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
//require_once($root."lib".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
//require_once($root."lib".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

if ($_GET["act"]=="reg") {

	$userId=Pulisci_INS($_POST["usrId"]);
	$name=Pulisci_INS($_POST["name"]);
	$surname=Pulisci_INS($_POST["surname"]);
	$email=Pulisci_INS($_POST["email"]);
	$usn=Pulisci_INS($_POST["usn"]);
	$profile=Pulisci_INS($_POST["profile"]);
	$uniName=Pulisci_INS($_POST["uniName"]);
	$uniDepartment=Pulisci_INS($_POST["uniDepartment"]);
	$uniDegree=Pulisci_INS($_POST["uniDegree"]);
	$uniStudyProgramme=Pulisci_INS($_POST["uniStudyProgramme"]);
	$uniCity=Pulisci_INS($_POST["uniCity"]);
	$uniAddress=Pulisci_INS($_POST["uniAddress"]);

	$actComplete=0;

	if (
		$userId AND 
		$name AND 
		$surname AND 
		$email AND 
		$uniName AND 
		$uniDepartment
	) $chk_status=1;

	if ($chk_status==1) {

		///////////////////////////////////////////////////////////
		/////////////// Registro su database MySql /////////////////
		
		$sql = "
			SELECT * 
			FROM  platform__students 
			WHERE (id_stud='$userId') 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);
		$find=mysqli_num_rows($result);

		if ($find==1) {
			$sql = "
				UPDATE `platform__students` 
				SET 
					email='$email', 
					usn='$usn', 
					profile='$profile', 
					uni_name='$uniName', 
					uni_department='$uniDepartment', 
					uni_degree='$uniDegree', 
					uni_study_programme='$uniStudyProgramme', 
					uni_city='$uniCity', 
					uni_address='$uniAddress' 
				WHERE id_STUD='$userId'";

		} else {
			$sql = "INSERT INTO `platform__students` 
			(`id_stud`, `usn`, `email`, `profile`, `uni_name`, `uni_department`, `uni_degree`, `uni_study_programme`, `uni_city`, `uni_address`)  VALUES 
			( '$userId', '$usn', '$email', '$profile', '$uniName', '$uniDepartment', '$uniDegree', '$uniStudyProgramme', '$uniCity', '$uniAddress')";
		}

		$result=mysqli_query($conn,$sql);

		if ($result===True) {

			if ($find!=1) {
				$guid=getGUID();

				$sql = "
					UPDATE `platform__user` 
					SET 
						guid='$guid', 
						name='$name', 
						surname='$surname', 
						checkcode='', 
						completeProfile='1' 
					WHERE id='$userId'";
				$result=mysqli_query($conn,$sql);

				$_SESSION["guest"]=base64_encode($userId."|".$guid."|student");
				$redirectPage="./MP_STUD_welcome.php";

			} else {
				$sql = "
					UPDATE `platform__user` 
					SET 
						name='$name', 
						surname='$surname', 
						completeProfile='1' 
					WHERE id='$userId'";
				$result=mysqli_query($conn,$sql);

				$redirectPage="./MP_STUD_completeProfile.php?userId=$userId&msg=OK";

			}


			// Upload document
			$check= new CheckUpload($_FILES["filex"]);
			if ($check->isOk()) {
				// Upload dell'allegato
				//$path=ereg_replace("MP_STUD_completeProfile.php","",$_SERVER["PATH_TRANSLATED"]);
				$upload_dir = "./data/mathePlatform/students"; 
				//$fileName=$_FILES['filex']['name'];
				$file_ext = pathinfo($_FILES['filex']['name'], PATHINFO_EXTENSION);

				if (strtolower($file_ext)=="jpg") {

					$upload_dir = "./data"; 
					$file_name = $userId.".jpg";

					move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name); 
					chmod($upload_dir."/".$file_name, 0777);

					//$upload_dir = "./data/news"; 
					$upload_dir = "./data/mathePlatform/students"; 
					
					// Immagine normale
					$file_name_big = $userId."_big.jpg";
					resize($file_name, $upload_dir, '500');
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_big);

					// Immagine small
					$file_name_small = $userId."_ico.jpg";
					$img_width="170";
					resize($file_name, $upload_dir, $img_width);
					chmod($upload_dir."/".$file_name, 0777);
					rename($upload_dir."/".$file_name,$upload_dir."/".$file_name_small);

					if(file_exists("./data/".$file_name)) unlink("./data/".$file_name);


					move_uploaded_file($_FILES["filex"]["tmp_name"],$upload_dir."/".$file_name); 
					chmod($upload_dir."/".$file_name, 0777);
				}

			}

			print "<script language=\"JavaScript\">window.location = '".$redirectPage."';</script>";
			die();

			$actComplete=1;
		} else $actErr=1; //Errata registrazione dei dati su MySQL


	} else $actErr=2; //Alcuni campi obbligatori non sono stati compilati

	if ($actComplete!=1) {

		//Redirect su messaggio
		$strpas11="./MP_LECT_completeProfile.php?userId={$userId}&msg={$actErr}";
		print "<script language=\"JavaScript\">window.location = '".$strpas11."';</script>";
		die();
	}


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
				FROM  platform__students 
				WHERE (id_stud='$usrId') 
				LIMIT 1";
			$result=mysqli_query($conn,$sql);
			$find=mysqli_num_rows($result);
			
			if ($find==1) {
				while ($row=mysqli_fetch_array($result)) {
					$usr_email=$row["email"];
					$usr_usn=$row["usn"];
					$usr_profile=$row["profile"];
					$uniName=$row["uni_name"];
					$uniDepartment=$row["uni_department"];
					$uniDegree=$row["uni_degree"];
					$uniStudyProgramme=$row["uni_study_programme"];
					$uniCountry=$row["uni_country"];
					$uniCity=$row["uni_city"];
					$uniAddress=$row["uni_address"];
				}
			}
		}

		$picturePath="./data/mathePlatform/students/".$userId."_ico.jpg";
		if (!file_exists($picturePath)) $picturePath="";
	} else {

		// Redirect
		$redirectUrl="./impianto/inc/logout.php";
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();
	}
}
?>
						
					<?php if ($_GET["msg"]=="OK") {?>
						<div style="margin-top: 25px;padding: 15px;border: solid 1px #070;border-radius: 5px;">
							<p style="font-size: 1.5em;font-weight: 600;text-align: center;color: #070;">Your profile is updated.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_STUD_completeProfile.php?act=reg" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p class="titpar" style="margin: 0px 45px 35px 17px;font-size: 1.5em;font-weight: 400;border-bottom: solid 2px #00aeef;color: #00aeef">YOUR PROFILE</p>

						<input type="hidden" name="usrId" value="<?=$usrId?>" />

						<div class="signup_field1">
							<label style="margin-left: 18px;font-weight: 400;color: #c00;">* Name</label>
							<input type="text" name="name" value="<?=$usr_name?>" required />
							<label style="margin-left: 80px;font-weight: 400;color: #c00;">* Surname</label>
							<input type="text" name="surname" value="<?=$usr_surname?>" required />
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Email</label>
							<input type="text" name="email" value="<?=$usr_email?>" required />
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">USN (University Student Number)</label>
							<input type="text" name="usn" value="<?=$usr_usn?>" />
						</div>
						
						<div class="signup_field_ext">
							<label>Profile</label>
							<textarea name="profile" /><?=$usr_profile?></textarea>
						</div>

						<div class="signup_field_ext">
							<label>Picture (JPG format)</label>
							<div class="clear"></div>
							<input type="file" name="filex" style="float: left;width: 300px;" />
							<?php if ($picturePath) {?>
								<div style="float: right;margin: -20px 42px 0 0;width: 150px;height: 150px;background: url('<?=$picturePath?>?rnd=<?=$rand_n?>') #fff no-repeat center center;"></div>
							<?php }?>
							<div class="clear"></div>
						</div>

						<p class="titpar" style="margin: 35px 45px 0 17px;font-size: 1.5em;font-weight: 400;border-bottom: solid 2px #00aeef;color: #00aeef">UNIVERSITY</p>

						<p style="margin: 10px 0 45px 20px;">Please choose the University you belong to. If your University is not on the list, please contact Ana Pereira at <a href="mailto:mathe@ipb.pt">mathe@ipb.pt</a></p>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Name of the University</label>
							<select name="uniName" style="width: 405px;padding: 5px;" required>
								<option value="">Select University</option>
								<?php
								$sql = "
									SELECT * 
									FROM platform__university 
									WHERE vis=1 
									ORDER BY name";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									?><option value="<?=$row["id"]?>" <?php if ($row["id"]==$uniName) echo "selected=\"selected\"";?>><?=$row["name"]?></option><?php
								}
								?>
								<option value="other" <?php if ($uniName=="other") echo "selected=\"selected\"";?>>other</option>
							</select>
						</div>
						
						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Faculty / Department</label>
							<input type="text" name="uniDepartment" value="<?=$uniDepartment?>" required />
						</div>
						
						<div class="signup_field_ext">
							<label>Degree</label>
							<p><input type="radio" name="uniDegree" class="radiobutt" value="bachelor" style="width: 30px;" <?php if (strtolower($uniDegree)=="bachelor") echo "checked=\"checked\"";?> /><label class="radiobutt">Bachelor</label></p>
							<p><input type="radio" name="uniDegree" class="radiobutt" value="master" style="width: 30px;margin-left: 30px;" <?php if (strtolower($uniDegree)=="master") echo "checked=\"checked\"";?> /><label class="radiobutt">Master</label></p>
							<p><input type="radio" name="uniDegree" class="radiobutt" value="phd" style="width: 30px;margin-left: 30px;" <?php if (strtolower($uniDegree)=="phd") echo "checked=\"checked\"";?> /><label class="radiobutt">PHD</label></p>
							<p><input type="radio" name="uniDegree" class="radiobutt" value="other" style="width: 30px;margin-left: 30px;" <?php if (strtolower($uniDegree)=="other") echo "checked=\"checked\"";?> /><label class="radiobutt">Other</label></p>
							<div class="clear"></div>
						</div>
						
						<div class="signup_field_ext">
							<label>Study Programme</label>
							<input type="text" name="uniStudyProgramme" value="<?=$uniStudyProgramme?>" />
						</div>
						
						<div class="signup_field_ext">
							<label>City</label>
							<input type="text" name="uniCity" value="<?=$uniCity?>" />
						</div>
						
						<div class="signup_field_ext">
							<label>Address</label>
							<input type="text" name="uniAddress" value="<?=$uniAddress?>" />
						</div>

						<?php if ($usr_completeProfile!=1) {?>
							<div style="padding: 35px 50px 0 50px;">
								<p style="padding: 0 0 5px 0;font-size: 1.2em;font-weight: 400;color: #264869;">Confirmation of registration</p>
								<p>Hereby I confirm that I would like to register on the project portal of the Erasmus+ project MathE.</p>
							</div>

							<div style="padding: 15px 50px;">
								<p style="padding: 0 0 5px 0;font-size: 1.2em;font-weight: 400;color: #264869;">Agreement for electronic use of personal data</p> 
								<p style="padding: 0 0 5px 0;">I further agree that my personal data (full name, email) get collected and processed for</p>
								<ul style="margin: 5px 0 0 25px;">
									<li>Reporting and audits of the Erasmus+ Portuguese national agency or any other organization indicated by the European Commission.</li>
									<li>Contacting me via email for information material related to the project</li>
									<li>Statistical purposes</li>
								</ul>
							</div>
						<?php }?>

						<div class="signup_submit">
							<input type="submit" value="Proceed" class="submit" style="display: block;margin: 50px auto 0 auto;" />
						</div>

					</form>







			<!-- INCOLLA END -->
		</div>
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>