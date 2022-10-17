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

$lectId=$_GET["lectId"];
$act=$_GET["act"];

if ($act=="reg") {
	//print_r($_POST);

	$tpoSTR="str_";

	$sql = "
		SELECT * 
		FROM platform__topic
		WHERE hidden=0 
		ORDER BY name ASC";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$topId=$row["id"];

		if ($_POST["top".$topId]) $tpoSTR.="top".$topId."_";

		$sql1 = "
			SELECT * 
			FROM platform__subtopic 
			WHERE (id_top=$topId AND hidden=0) 
			ORDER BY name ASC";
		$result1=mysqli_query($conn,$sql1);
		
		while ($row1=mysqli_fetch_array($result1)) { 
			$subtopicId=($row1["id"]);
			
			if ($_POST["subtop".$subtopicId]) $tpoSTR.="sub".$topId."|".$subtopicId."_";
		}
	
	
	}

	//echo $tpoSTR;
			
	$sql = "
		UPDATE `platform__lecturers` 
		SET 
			topic_permission='$tpoSTR'
		WHERE id_lect='$lectId'";
	$result=mysqli_query($conn,$sql);

	// Redirect
	$redirectUrl="./MP_LECT_topicAssign.php";
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {

	$sql = "
		SELECT * 
		FROM  platform__lecturers 
		WHERE (id_lect='$lectId') 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
												
	while ($row=mysqli_fetch_array($result)) { 
		$tpoSTR=$row["topic_permission"];
	}
}
?>

					<p class="rsvPage_Title">Topics and Subtopics</p>
					<p class="rsvPage_Title1">Assign Topic and SubTopic to Lecturer</p>

					<form method="post" action="./MP_LECT_topicAssignEdit.php?act=reg&lectId=<?=$lectId?>" enctype="multipart/form-data" style="display: block;margin-top: 45px;">
						<?php 

						$sqlP = "
							SELECT *
							FROM platform__topic 
							WHERE hidden=0 
							ORDER BY name ASC";
						$resultP=mysqli_query($conn,$sqlP);
						if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

						?>

						<table class="table table-hover">
							<thead>
								<tr>
									<th class="tdtit"></th>
									<th class="tdtit">Name</th>
									<th class="tdtit">Subtopic</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$count=1;
								while ($row=mysqli_fetch_array($resultP)) { 
									$topicId=$row["id"];
									$topicName=$row["name"];

									$slqQst="
										SELECT *
										FROM platform__SNA__questions 
										WHERE topic=$topicId AND subtopic=0";
									$resultQst=mysqli_query($conn,$slqQst);
									if ($resultQst) $totqst=mysqli_num_rows($resultQst); else $totqst=0;

									$checkedRs="";
										$checkSTR="_top".$topicId."_";
										$find=strpos($tpoSTR, $checkSTR);
										if ($find) $checkedRs="checked";

									?>
									<tr>
										<td style="font-size: 0.9em;"></td>
										<td style="font-size: 0.9em;">
											
											<p style="font-size: 1.1em;font-weight: 400;"><input type="checkbox" name="top<?=$topicId?>" <?=$checkedRs?> /> <?=$topicName?> <span style="font-size: 0.8em;color: #999;">(<?=$totqst?>)</span></p>
										</td>
										<td>
											<?php 
												$sqlSP = "
													SELECT *
													FROM platform__subtopic 
													WHERE (id_top=$topicId AND hidden=0) 
													ORDER BY name ASC";
												$resultSP=mysqli_query($conn,$sqlSP);
												
												$k=1;
												while ($rowSP=mysqli_fetch_array($resultSP)) { 
													$subtopicId=$rowSP["id"];
													$subtopicName=$rowSP["name"];
													
													$slqQst1="
														SELECT *
														FROM platform__SNA__questions 
														WHERE topic=$topicId AND subtopic=$subtopicId";
													$resultQst1=mysqli_query($conn,$slqQst1);
													if ($resultQst1) $totqst1=mysqli_num_rows($resultQst1); else $totqst1=0;
													
													$checkedRs1="";
														$checkSTR1="_sub".$topicId."|".$subtopicId."_";
														$find1=strpos($tpoSTR, $checkSTR1);
														if ($find1) $checkedRs1="checked";

													?><p><input type="checkbox" name="subtop<?=$subtopicId?>" <?=$checkedRs1?> /> <?=$subtopicName?> <span style="font-size: 0.8em;color: #999;">(<?=$totqst1?>)</span></p><?php 

													$k+=1;
												}

											?>
										</td>
									</tr>
									<?php 
									$count+=1;
								}
								?>
							</tbody>
						</table>

						<div class="signup_submit" style="padding-left: 230px;">
							<a href="./MP_LECT_topicAssign.php"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 20px;padding: 5px;" />
						</div>
					
					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>