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


$qstId=$_GET["id_act"];
$from=$_GET["from"];

$page=$_GET["page"];
$srcLevel=$_GET["srcLevel"];
$srcTopic=$_GET["srcTopic"];
$srcSubTopic=$_GET["srcSubTopic"];
$srcValidation=$_GET["srcValidation"];
$queryStr="page={$page}&srcLevel={$srcLevel}&srcTopic={$srcTopic}&srcSubTopic={$srcSubTopic}&srcValidation={$srcValidation}&from={$from}";

if ($from=="toggle") $destPage="MP_LECT_SNA_questionApprovedList";
else $destPage="MP_LECT_SNA_questionValidateList";

$validateValue=0;
if (isset($_POST['validate'])) $validateValue=1;
if (isset($_POST['notValidate'])) $validateValue=2;

if ($_GET["act"]=="reg" AND $qstId AND $validateValue) {

	$validateDate=Date("Y-m-d H:i:s");

	$sql = "
		UPDATE `platform__SNA__questions` 
		SET 
			validate=$validateValue, 
			validate_date='$validateDate', 
			validate_by=$usrId 
		WHERE id=$qstId";
	$result=mysqli_query($conn,$sql);
		
	$redirectUrl="./".$destPage.".php?".$queryStr;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

} else {

	$sql = "
		SELECT *, p.id AS qstId 
		FROM platform__SNA__questions AS p 
		WHERE p.id='$qstId' 
		ORDER BY p.date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$qstId=$row["qstId"];
		$qstLectId=$row["id_lect"];
		$description=$row["description"];
		$topic=$row["topic"];
		$subtopic=$row["subtopic"];
		$question=$row["question"];
		$level=$row["level"];
		$answer1=$row["answer1"];
		$answer2=$row["answer2"];
		$answer3=$row["answer3"];
		$answer4=$row["answer4"];
		$fileName=$row["file_name"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
		$validate=$row["validate"];
		$validate_date=$row["validate_date"];
		$validate_by=$row["validate_by"];
	}
	
	if ($validate==1) $validateTr="<span style=\"font-weight: 600;color: #090;\">VALIDATED</span>";
	elseif ($validate==2) $validateTr="<span style=\"font-weight: 600;color: #900;\">NOT VALIDATED</span>";
	else $validateTr="<span style=\"font-weight: 600;color: #ffcc00;\">WAITING FOR VALIDATION</span>";

	// File allegato alla question
	//$pict="./data/news/".$pict_id.".jpg";
	$pict="./data/mathePlatform/SNA/attach/".$qstId.".".$fileExt;
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

					<p class="rsvPage_Title">Validate Question</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_LECT_SNA_questionValidateResponse.php?act=reg&id_act=<?=$qstId?>&<?=$queryStr?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<?php 
						$sql = "
							SELECT * 
							FROM platform__topic 
							WHERE (id=$topic AND hidden=0) 
							LIMIT 1";
						$result=mysqli_query($conn,$sql);

						while ($row=mysqli_fetch_array($result)) { 
							$topicName=($row["name"]);
						}

						$sql = "
							SELECT * 
							FROM platform__subtopic 
							WHERE (id=$subtopic AND id_top=$topic AND hidden=0) 
							LIMIT 1";
						$result=mysqli_query($conn,$sql);

						while ($row=mysqli_fetch_array($result)) { 
							$subtopicName=($row["name"]);
						}

						$topicTr=$topicName;
						if ($subtopicName) $topicTr.=" / ".$subtopicName;

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
									<p><span style="font-weight: 400;color: #666;">Code:</span> SNA<?=$qstId?></p>
									<p><span style="font-weight: 400;color: #666;">Status:</span> <?=$validateTr?></p>
									<p><span style="font-weight: 400;color: #666;">Topic:</span> <?=$topicTr?></p>
									<p><span style="font-weight: 400;color: #666;">Level:</span> <?=$level?></p>
									<?php if (file_exists($pict)) {?><p><span style="font-weight: 400;color: #666;">Attachment:</span> <a href="<?=$pict?>" target="_blank" style="font-size: 1.0em;color: #900;"><?=$fileName?></a></p><?php }?>
								</div>
								<div style="float: right;width: 300px;margin-right: 10px;border: solid 1px #ccc;border-radius: 5px;">
									<p style="padding: 2px 5px;border-radius: 5px 5px 0 0;background-color: #444;color: #fff;">Author</p>
									<div style="padding: 5px;">
										<p style="font-weight: 400;"><?=$authorName?> <?=$authorSurname?></p>
										<p><a href="mailto:<?=$authorEmail?>?subject=Comment on Question code SNA<?=$qstId?>"><?=$authorEmail?></a></p>
										<p><?=$authorUniversity?></p>
										<p><?=$authorDepartment?></p>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Question</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=nl2br($question)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #090;">Answer n. 1 (TRUE)</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #090;border-radius: 5px;">
								<?=nl2br($answer1)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #900;">Answer n. 2 (FALSE)</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #900;border-radius: 5px;">
								<?=nl2br($answer2)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #900;">Answer n. 3 (FALSE)</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #900;border-radius: 5px;">
								<?=nl2br($answer3)?>
							</div>
						</div>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #900;">Answer n. 4 (FALSE)</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #900;border-radius: 5px;">
								<?=nl2br($answer4)?>
							</div>
						</div>


						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./<?=$destPage?>.php?<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<a href="./MP_LECT_SNA_questionValidateEdit.php?id_act=<?=$qstId?>&<?=$queryStr?>"><button type="button" class="edit" style="width: 100px;margin-left: 5px;padding: 5px;" />EDIT</button></a>
							<input type="submit" name="notValidate" value="NOT APPROVED" class="notValidate" style="width: 150px;margin-left: 100px;padding: 5px;" />
							<input type="submit" name="validate" value="APPROVED" class="proceed" style="width: 150px;margin-left: 5px;padding: 5px;" />
						</div>

					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>