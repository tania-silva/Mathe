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
$srcValidation=$_GET["srcValidation"];
$queryStr="page={$page}&srcValidation={$srcValidation}";

if ($act=="delete" AND $act_id AND $usrId) {

	$sql = "
		SELECT *, p.id AS qstId 
		FROM platform__SNA__VID_reviews AS p 
		WHERE (p.id='$act_id' AND p.id_lect=$usrId)
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$fileExt=$row["file_ext"];
	}
	
	$sql = "
		DELETE 
		FROM `platform__SNA__VID_reviews` 
		WHERE (id='$act_id' AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);

	/* Cancello il file associat0 */
	$pict="./data/mathePlatform/SNA/vdReviews/{$act_id}.{$fileExt}";
	if(file_exists($pict)) unlink($pict);

	// Redirect
	$redirectUrl="./MP_LECT_SNA_videoRevManage.php?".$queryStr;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__VID_reviews AS p 
		WHERE (p.id='$act_id' AND p.id_lect=$usrId) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$vidId=$row["vidId"];
		$videoTitle=$row["title"];
		$videoAuthor=$row["author"];
		$videoDescription=$row["description"];
		$videoLink=$row["link"];
		$videoLang=$row["languages"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
	}

	// File allegato alla question
	$pict="./data/mathePlatform/SNA/vdReviews/".$vidId.$fileExt;
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

					<p class="rsvPage_Title">Delete Video Review</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>
						




						<div class="el_msg" style="margin-top: 10px;padding: 10px;border: solid 1px #00AEEF;border-radius: 5px;">
							<p class="p01" style="margin: 0;padding: 0;text-align: center;">Do you want to delete this Video Review?</p>

							<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Title:</p>
							<p class="p03" style="font-size: 0.9em;font-weight: 200;"><?=$videoTitle?></p>

							<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Author:</p>
							<p class="p03" style="font-weight: 200;"><?=$videoAuthor?></p>


							<div class="signup_submit" style="padding-left: 70px;">
								<a href="./MP_LECT_SNA_videoRevManage.php?<?=$queryStr?>"><button type="button" class="abort" style="margin-left: 30px;" />Abort</button></a>
								<a href="./MP_LECT_SNA_videoRevDelete.php?id_act=<?=$act_id?>&<?=$queryStr?>&act=delete"><button type="button" class="proceed" style="margin-left: 20px;" />Proceed</button></a>
							</div>
						</div>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>