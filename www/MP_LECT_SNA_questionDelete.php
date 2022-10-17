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

//////////////////////////// SANITIZE VARS ///////////////////////////
//$DS=DIRECTORY_SEPARATOR;
//$root=".".$DS;
//require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");
//
//$var_get=array(
//		'id_act'=>'int',
//		'act'=>'str',
//);
//
//sanitize($_GET, $var_get);
//////////////////////////////////////////////////////

$act=$_GET["act"];
$act_id=$_GET["id_act"];

$page=$_GET["page"];
$srcLevel=$_GET["srcLevel"];
$srcTopic=$_GET["srcTopic"];
$srcSubTopic=$_GET["srcSubTopic"];
$srcValidation=$_GET["srcValidation"];
$queryStr="page={$page}&srcLevel={$srcLevel}&srcTopic={$srcTopic}&srcSubTopic={$srcSubTopic}&srcValidation={$srcValidation}";

if ($act=="delete" AND $act_id AND $usrId) {

	$sql = "
		SELECT *, p.id AS qstId 
		FROM platform__SNA__questions AS p 
		WHERE (p.id='$act_id' AND p.id_lect=$usrId) 
		ORDER BY p.date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$fileExt=$row["file_ext"];
	}
	
	$sql = "
		DELETE 
		FROM `platform__SNA__questions` 
		WHERE (id='$act_id' AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);

	/* Cancello il file associat0 */
	$pict="./data/mathePlatform/SNA/attach/{$act_id}.{$fileExt}";
	if(file_exists($pict)) unlink($pict);

	// Redirect
	$redirectUrl="./MP_LECT_SNA_questionManage.php?".$queryStr;
	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
	die();

} else {

	$sql = "
		SELECT *, p.id AS qstId, q.name AS topicName 
		FROM platform__SNA__questions AS p 
		LEFT JOIN platform__topic AS q 
		ON p.topic=q.id 
		WHERE (p.id='$act_id' AND p.id_lect=$usrId) 
		ORDER BY date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$qstId=$row["qstId"];
		$description=$row["description"];
		$topic=$row["topicName"];
		$question=$row["question"];
		$level=$row["level"];
		$answer1=$row["answer1"];
		$answer2=$row["answer2"];
		$answer3=$row["answer3"];
		$answer4=$row["answer4"];
		$date=$row["date"];
	}

	// File allegato alla question
	$pict="./data/news/".$pict_id.".jpg";
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

					<p class="rsvPage_Title">Delete Question</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>
						



						<div class="el_msg" style="margin-top: 10px;padding: 10px;border: solid 1px #00AEEF;border-radius: 5px;">
							<p class="p01" style="margin: 0;padding: 0;text-align: center;">Do you want to delete this question?</p>

						
							<div class="signup_field_ext">
								<label style="font-weight: 400;color: #c00;">Topic:</label>
								<span><?=$topic?></span>
							</div>

							<div class="signup_field_ext">
								<label style="font-weight: 400;color: #c00;">Question:</label>
								<p><?=$question?></p>
							</div>


							<div class="signup_submit" style="padding-left: 70px;">
								<a href="./MP_LECT_SNA_questionManage.php?<?=$queryStr?>"><button type="button" class="abort" />Abort</button></a>
								<a href="./MP_LECT_SNA_questionDelete.php?id_act=<?=$act_id?>&<?=$queryStr?>&act=delete"><button type="button" class="proceed" />Proceed</button></a>
							</div>
						</div>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>