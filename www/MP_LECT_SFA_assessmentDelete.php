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

	////////////////////////// SANITIZE VARS ///////////////////////////
	$DS=DIRECTORY_SEPARATOR;
	$root=".".$DS;
	require_once($root."lib".$DS."sanitize".$DS."sanitize.lib.php");

	$var_get=array(
			'assId'=>'int',
			'act'=>'str',
	);

	sanitize($_GET, $var_get);
	////////////////////////////////////////////////////

	$act=$_GET["act"];
	$assId=$_GET["assId"];

	if ($act=="delete" AND $assId AND $usrId) {
		
		$sql = "
			DELETE 
			FROM `platform__SFA__assestment` 
			WHERE (id='$assId' AND id_lect=$usrId)";
		$result=mysqli_query($conn,$sql);

	
//		$sql = "
//			DELETE 
//			FROM `platform__SFA__assquestions` 
//			WHERE (id_ass='$assId' AND id_lect=$usrId)";
//		$result=mysqli_query($conn,$sql);

		// Redirect
		$redirectUrl="./MP_LECT_SFA_assessmentManage.php";
		echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
		die();

	} else {

		$sql = "
			SELECT * 
			FROM platform__SFA__assestment
			WHERE (id=$assId AND id_lect=$usrId) 
			ORDER BY FA_date DESC";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$assTitle=$row["title"];
			$assDescription=$row["description"];
			$assDate=$row["FA_date"];
			$assDuration=$row["duration"];
		}

		// File allegato alla question
		$pict="./data/news/".$pict_id.".jpg";
	}
?>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

					<p class="rsvPage_Title">Delete Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>
						



						<div class="el_msg" style="margin-top: 10px;padding: 10px;border: solid 1px #00AEEF;border-radius: 5px;">
							<p class="p01" style="margin: 0;padding: 0;text-align: center;">Do you want to delete this assessment?</p>

						
							<div class="signup_field_ext">
								<label style="font-weight: 400;color: #c00;">Title:</label>
								<span><?=$assTitle?></span>
							</div>

							<div class="signup_field_ext">
								<label style="font-weight: 400;color: #c00;">Description:</label>
								<div><?=$assDescription?></div>
							</div>


							<div class="signup_submit" style="padding-left: 70px;">
								<a href="./MP_LECT_SFA_assessmentManage.php<?=$queryStr?>"><button type="button" class="abort" />Abort</button></a>
								<a href="./MP_LECT_SFA_assessmentDelete.php?assId=<?=$assId?>&act=delete"><button type="button" class="proceed" />Proceed</button></a>
							</div>
						</div>
					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>