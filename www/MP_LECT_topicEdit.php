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

$topicId=$_GET["topicId"];

if ($_GET["act"]=="reg" AND $topicId) {
	$_SESSION['post_data']=$_POST;

	$topicName=Pulisci_INS($_POST["topicName"]);

	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$topicId AND 
		$topicName
	) $checkStatus=1;

	if ($checkStatus) {

		/* Modifico il topic */
		$sql = "
			UPDATE `platform__topic` 
			SET 
				name='$topicName' 
			WHERE id=$topicId";
		$result=mysqli_query($conn,$sql);

		/* Modifico i subtopic */

		foreach ($_POST as $chiave => $valore) {
			if (substr($chiave,0,4)=="STUP") {
				if ($valore) {
					$subTopicId=substr($chiave,4,strlen($chiave));
					$sql = "
						UPDATE `platform__subtopic` 
						SET 
							name='$valore' 
						WHERE (id=$subTopicId AND id_top=$topicId)";
					 $result=mysqli_query($conn,$sql);
				} 
			} elseif (substr($chiave,0,4)=="STNW") {
				if ($valore) {
					$sql = "
						INSERT INTO `platform__subtopic` 
						(`id_top`, `name`)  
						VALUES ('$topicId', '$valore')";
					$result=mysqli_query($conn,$sql);
				}
			}
			$sql="";
		}

		$redirectUrl="./MP_LECT_topicManage.php";

	} else $redirectUrl="./MP_LECT_topicEdit.php?msg=KO";

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

} else {

	$sql = "
		SELECT *
		FROM platform__topic 
		WHERE id=$topicId 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$topicName=$row["name"];
	}

}
?>

					<p class="rsvPage_Title">Topics and Subtopics</p>
					<p class="rsvPage_Title1">Edit Topic/Subtopics</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>


					<form method="post" action="./MP_LECT_topicEdit.php?act=reg&topicId=<?=$topicId?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p style="padding: 5px 15px 0 15px;font-size: 1.2em;">In order to edit the name of a subtopic, change the name and click on save.</p>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">* Topic</label>
							<textarea name="topicName" style="height: 40px;padding: 10px;" required /><?=$topicName?></textarea>
						</div>

						<?php 
						$sqlSP = "
							SELECT *
							FROM platform__subtopic 
							WHERE (id_top=$topicId AND hidden=0) 
							ORDER BY name ASC";
						$resultSP=mysqli_query($conn,$sqlSP);
						if ($resultSP) $ST_find=mysqli_num_rows($resultSP); else $ST_find=0;
						
						if ($ST_find>=1) {
							?>
							<div class="signup_field_ext">
								<label style="font-weight: 400;color: #c00;">SubTopics</label>
								<div style="margin-left: 15px;">
									<?php 
									
									$k=1;
									while ($rowSP=mysqli_fetch_array($resultSP)) { 
										$subtopicId=$rowSP["id"];
										$subtopicName=$rowSP["name"];

										?><input type="text" name="STUP<?=$subtopicId?>" value="<?=$subtopicName?>" /><br /><?php 

										$k+=1;
									}

									?>
								</div>
							</div>
							<?php 
						}
						?>

						<div class="signup_field_ext">
							<label style="font-weight: 400;color: #c00;">Add new SubTopics</label>
							<p style="padding: 5px 15px 20px 15px">In order to add a subtopic, insert the name of the subtopic in the first available empty line and click on save</p>
							<div style="margin-left: 15px;">
								<?php 

								for ($d=1;$d<=(10-$ST_find);$d++) {
									?><input type="text" name="STNW<?=$d?>" value="" /><br /><?php 
								}


								?>
							</div>
						</div>
						

						<div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_topicManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 150px;margin-left: 150px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 10px;padding: 5px;" />
						</div>




					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>