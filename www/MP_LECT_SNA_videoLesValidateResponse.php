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
	
//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
//require_once($root."lib".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
//require_once($root."lib".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
//require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
//require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////


$vidId=$_GET["id_act"];
$from=$_GET["from"];

$page=$_GET["page"];
$srcValidation=$_GET["srcValidation"];
$queryStr="page={$page}&srcValidation={$srcValidation}&from={$from}";

if ($from=="toggle") $destPage="MP_LECT_SNA_videoLesApprovedList";
else $destPage="MP_LECT_SNA_videoLesValidateList";

$validateValue=0;
if (isset($_POST['validate'])) $validateValue=1;
if (isset($_POST['notValidate'])) $validateValue=2;

if ($_GET["act"]=="reg" AND $vidId AND $validateValue) {

	$validateDate=Date("Y-m-d H:i:s");

	$sql = "
		UPDATE `platform__SNA__VID_lessons` 
		SET 
			validate=$validateValue, 
			validate_date='$validateDate', 
			validate_by=$usrId 
		WHERE id=$vidId";
	$result=mysqli_query($conn,$sql);
		
	$redirectUrl="./".$destPage.".php?".$queryStr;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__VID_lessons AS p 
		WHERE p.id='$vidId' 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$vidId=$row["vidId"];
		$qstLectId=$row["id_lect"];
		$videoTitle=$row["title"];
		$videoAuthor=$row["author"];
		$videoDescription=$row["description"];
		$videoLink=$row["link"];
		$videoLang=$row["languages"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
		$validate=$row["validate"];
		$validate_date=$row["validate_date"];
		$validate_by=$row["validate_by"];
	}


	$videoPreview="";
	if (strpos($videoLink, "/")===False AND strlen($videoLink)==11) {
		// E' stato inserito il codice di 11 caratteri di YouTube
		$youtubeCode=$videoLink;
		$videoPreview="<iframe width='400' height='226' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	} elseif (strpos($videoLink, "youtu.be")>0) {
		// E' stato inserito il link per la condivisione di Youtube
		$youtubeCode=substr($videoLink,-11);
		$videoPreview="<iframe width='400' height='226' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	} else {
		$icon="./impianto/img/notAvailable.jpg";
		if (file_exists("./data/mathePlatform/SNA/vdLessons/".$vidId.".".$fileExt)) $icon="./data/mathePlatform/SNA/vdLessons/$vidId.$fileExt";
		$videoPreview="<a href=\"".$videoLink."\" style=\"display: block;width: 400px;\" target=\"_blank\"><div style=\"display: block;width: 400px;height: 226px;background: url(".$icon.") #fff no-repeat 0 0;background-size: 400px auto;\"></div></a>";
	}


	
	if ($validate==1) $validateTr="<span style=\"font-weight: 600;color: #090;\">VALIDATED</span>";
	elseif ($validate==2) $validateTr="<span style=\"font-weight: 600;color: #900;\">NOT VALIDATED</span>";
	else $validateTr="<span style=\"font-weight: 600;color: #ffcc00;\">WAITING FOR VALIDATION</span>";

	// File allegato alla question
	$pict="./data/mathePlatform/SNA/vdLessons/".$vidId.".".$fileExt;
}
?>
	<script type="text/x-mathjax-config">
	  MathJax.Hub.Config({
		tex2jax: {
		  inlineMath: [ ['$','$'], ["\\(","\\)"] ],
		  processEscapes: true
		}
	  });
	</script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

					<p class="rsvPage_Title">Validate Video Lesson</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_LECT_SNA_videoLesValidateResponse.php?act=reg&id_act=<?=$vidId?>&<?=$queryStr?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<?php 
						$sql = "
							SELECT *,
								p.name AS authorName,
								p.surname AS authorSurname,
								k.name AS authorUniversity, 
								q.email AS authorEmail
							FROM platform__user AS p 
							LEFT JOIN platform__lecturers AS q 
							ON p.id=q.id_lect 
							LEFT JOIN platform__university AS k 
							ON q.uni_name=k.id 
							WHERE p.id=$qstLectId 
							LIMIT 1";
						$result=mysqli_query($conn,$sql);

						while ($row=mysqli_fetch_array($result)) { 
							$authorName=$row["authorName"];
							$authorSurname=$row["authorSurname"];
							$authorUniversity=$row["authorUniversity"];
							$authorDepartment=$row["uni_department"];
							$authorEmail=$row["authorEmail"];
						}
						?>

						<div class="signup_field_ext">
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #666;border-radius: 5px;">
								<div style="float: left;width: 300px;">
									<p><span style="font-weight: 400;color: #666;">Code:</span> VLE<?=$vidId?></p>
									<p><span style="font-weight: 400;color: #666;">Status:</span> <?=$validateTr?></p>
								</div>
								<div style="float: right;width: 300px;margin-right: 10px;border: solid 1px #ccc;border-radius: 5px;">
									<p style="padding: 2px 5px;border-radius: 5px 5px 0 0;background-color: #444;color: #fff;">Lecturer</p>
									<div style="padding: 5px;">
										<p style="font-weight: 400;"><?=$authorName?> <?=$authorSurname?></p>
										<p><a href="mailto:<?=$authorEmail?>?subject=Comment on Question code VLE<?=$vidId?>"><?=$authorEmail?></a></p>
										<p><?=$authorUniversity?></p>
										<p><?=$authorDepartment?></p>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Title of the Lesson</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=nl2br($videoTitle)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Author of the Lesson</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=$videoAuthor?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Description</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=nl2br($videoDescription)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Video</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=$videoPreview?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Language(s)</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?php 
								$sql = "
									SELECT * 
									FROM VID_lang 
									ORDER BY ord";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$id_key=$row["id_key"];
									$nome=$row["nome"];

									if (strrpos($videoLang,"_".$id_key."_")) {
										?>
											<p style="float: left;width: 100px;padding: 10px 0 0 0;font-weight: normal;"><label class="radiobutt" style="float: left;margin: -4px 0 0 5px;" ><?=$nome?></label></p>
										<?php 
									}
								}
								?>
								<div class="clear"></div>
							</div>
						</div>


						<div class="signup_submit" style="padding-left: 0;">
							<a href="./<?=$destPage?>.php?<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<a href="./MP_LECT_SNA_videoLesValidateEdit.php?id_act=<?=$vidId?>&<?=$queryStr?>"><button type="button" class="edit" style="width: 100px;margin-left: 5px;padding: 5px;" />EDIT</button></a>
							<input type="submit" name="notValidate" value="NOT APPROVED" class="notValidate" style="width: 150px;margin-left: 100px;padding: 5px;" />
							<input type="submit" name="validate" value="APPROVED" class="proceed" style="width: 150px;margin-left: 5px;font-size: 1.3em;padding: 5px 20px;" />
						</div>

					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>