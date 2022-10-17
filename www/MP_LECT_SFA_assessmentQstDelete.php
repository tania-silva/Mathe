	<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="./impianto/addons/calendar1/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>

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

$assId=Pulisci_INS($_GET["assId"]);
$qstNb=Pulisci_INS($_GET["qstNb"]);
$qstId=Pulisci_INS($_GET["qstId"]);

$act=$_GET["act"];

if ($act=="delete" AND $assId AND $qstId AND $usrId) {
	
	if (strlen($qstNb)==1) $qstNb="0".$qstNb;
	$sql = "
		UPDATE `platform__SFA__assestment` 
		SET 
			qst{$qstNb}=Null
		WHERE (id=$assId AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);

	$sql = "
		SELECT *, p.id AS qstId 
		FROM platform__SFA__assquestions AS p 
		WHERE (p.id='$qstId' AND p.id_lect=$usrId) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$fileExt=$row["file_ext"];
	}
	
	$sql = "
		DELETE 
		FROM `platform__SFA__assquestions` 
		WHERE (id='$qstId' AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);

	/* Cancello il file associat0 */
	$pict="./data/mathePlatform/SFA/assAttach/{$qstId}.{$fileExt}";
	if(file_exists($pict)) unlink($pict);

	// Redirect
	$redirectUrl="./MP_LECT_SFA_assessmentNew1.php?assId=".$assId;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {

	$sql = "
		SELECT *, p.id AS qstId, q.name AS topicName 
		FROM platform__SFA__assquestions AS p 
		LEFT JOIN platform__topic AS q 
		ON p.topic=q.id 
		WHERE (p.id='$qstId' AND p.id_lect=$usrId) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		//$qstId=$row["qstId"];
		$description=$row["description"];
		$topic=$row["topicName"];
		$subtopic=$row["subTopicName"];
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
	
					<p class="rsvPage_Title">Insert New Final Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>



					<div class="el_msg" style="margin-top: 10px;padding: 10px;border: solid 1px #00AEEF;border-radius: 5px;">
						<p class="p01" style="margin: 0;padding: 0;text-align: center;">Do you want to delete this question in this assessment?</p>

						<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Topic:</p>
						<p class="p03" style="font-size: 0.9em;font-weight: 200;"><?=$topic?></p>

						<p class="titpar" style="margin-top: 10px;font-size: 0.9em;font-style: italic;font-weight: 400;">Question</p>
						<p class="p03" style="font-weight: 200;"><?=$question?></p>


						<div class="signup_submit" style="padding-left: 70px;">
							<a href="./MP_LECT_SFA_assessmentNew1.php?assId=<?=$assId?>"><button type="button" class="abort" style="margin-left: 30px;" />Abort</button></a>
							<a href="./MP_LECT_SFA_assessmentQstDelete.php?assId=<?=$assId?>&qstNb=<?=$qstNb?>&qstId=<?=$qstId?>&act=delete"><button type="button" class="proceed" style="margin-left: 20px;" />Proceed</button></a>
						</div>
					</div>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>