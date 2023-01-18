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
require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

$vidId=$_GET["idVideo"];

$fromPage="";
$fromPage=$_GET["from"];
$keywords=[];

$validateValue=0;
if (isset($_POST['examine'])) $validateValue=4;
if ($fromPage=="valedit") $validateValue=4;

if ($fromPage=="edit") $pageTitle="Edit Teaching Material";
elseif ($fromPage=="valedit" OR $fromPage=="toggle") $pageTitle="Validate Teaching Material";
else $pageTitle="Insert New Teaching Material";

if ($_GET["act"]=="reg" AND $usrId) {

	$_SESSION['post_data']=$_POST;

	// Keywords
	$videoKeywords="key_";
	$sql = "
		SELECT * 
		FROM platform__keywords 
		ORDER BY name";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id"];
		if ($_POST["key".$id_key]==$id_key){
			$videoKeywords.=$id_key."_";
			array_push($keywords, $id_key);
		} 
	}

	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$usr_completeProfile==1 AND 
		$videoKeywords!="key_"
	) $checkStatus=1;

	if ($checkStatus) {

		/* Registro topic/subtopic associati al video */
		$sql = "
			UPDATE `platform__SNA__tchmaterials` 
			SET 
				keywords='$videoKeywords',
				validate='$validateValue'
			WHERE id=$vidId";
		$result=mysqli_query($conn,$sql);

		//IPB: Add keywords to platform_keyword_videoreviews
		$sqlDelete = " 
		DELETE FROM `platform_keyword_snatchmaterials` WHERE `id_sna_tchmaterials` = '$vidId'";
		$resultDelete=mysqli_query($conn,$sqlDelete);

		$sqlInsert= "
		INSERT INTO `platform_keyword_snatchmaterials`(`id_keyword`, `id_sna_tchmaterials`) VALUES";
		foreach($keywords as $key){
			$sqlInsert .= "('$key','$vidId'),";
		}
		$sqlInsert= rtrim($sqlInsert, ",");
		$resulInsert=mysqli_query($conn,$sqlInsert);
		
		if ($fromPage=="edit") $redirectUrl="./MP_LECT_SNA_TchMatEdit.php?id_act=".$vidId; // passa alla pagina di edit
		elseif ($fromPage=="valedit" OR $fromPage=="toggle") $redirectUrl="./MP_LECT_SNA_TchMatValidateEdit.php?from=".$fromPage."&id_act=".$vidId; // passa alla pagina di edit
		else $redirectUrl="./MP_LECT_SNA_TchMatManage.php"; // torna alla lista delle video reviews

	} else $redirectUrl="./MP_LECT_SNA_TchMatAdd3.php?idVideo=".$vidId."&msg=KO&from=".$fromPage;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
		
} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__tchmaterials AS p 
		WHERE (p.id='$vidId') 
		ORDER BY p.date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$vidId=$row["vidId"];
		$videoTitle=$row["title"];
		$videoAuthor=$row["author"];
		$videoDescription=$row["description"];
		$videoLink=$row["link"];
		$videoLang=$row["languages"];
		$videoTopic=$row["topic"];
		$videoSubTopic=$row["subtopic"];
		$videoKeywords=$row["keywords"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
	}

}
?>

					<p class="rsvPage_Title"><?=$pageTitle?></p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_LECT_SNA_TchMatAdd2.php?act=reg&idVideo=<?=$vidId?>&from=<?=$fromPage?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">
						<p>Please select keywords for this video reviews</p>

						<div style="padding-top: 25px;">
							<label style="display: block;padding: 0 0 5px 0;font-weight: 400;color: #c00;">* Keywords</label>
							<div style="width: 625px;height: 400px;padding: 10px 0 10px 10px;border: dotted 1px #00aeef;border-radius: 5px;overflow: auto;">

								<?php 
								$sql = "
									SELECT *, p.id AS topicId, q.id AS keyId, p.name AS topicName, q.name AS keyName  
									FROM platform__topic as p 
									LEFT JOIN platform__keywords as q 
									ON (p.id=q.id_top AND q.id_sub=0 AND q.hidden=0 AND p.hidden=0)
									ORDER BY p.name ASC";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$topicId=($row["topicId"]);
									$topicName=($row["topicName"]);
									$TopkeyId=($row["keyId"]);
									$TopkeyName=($row["keyName"]);

									if (strrpos($videoTopic,"_".$topicId."_") AND $TopkeyName) {
										if ($topicName!=$topicNameOld) {?><div class="clear"></div><div style="padding: 5px 0 2px 0;font-size: 1.2em;font-weight: 500;"><?=$topicName?></div><?php }
										?><div style="float: left;width: 300px;"><?php 
											?><div><input type="checkbox" name="key<?=$TopkeyId?>" value="<?=$TopkeyId?>" <?php if (strrpos($videoKeywords,"_".$TopkeyId."_")) echo "checked=\"checked\"";?> /> <label style="font-size: 1.0em;font-weight: 300;"><?=$TopkeyName?></label></div><?php 
										?></div><?php 
									}
									
									if ($topicName!=$topicNameOld) {
										$sql1 = "
											SELECT *, p.id AS subtopicId, q.id AS keyId, p.name AS subtopicName, q.name AS keyName  
											FROM platform__subtopic as p 
											LEFT JOIN platform__keywords as q 
											ON (p.id=q.id_sub AND q.hidden=0 AND p.hidden=0)
											WHERE (p.id_top=$topicId) 
											ORDER BY p.name ASC";
										$result1=mysqli_query($conn,$sql1);

										//if ($topicId==4) echo $sql1;

										while ($row1=mysqli_fetch_array($result1)) { 
											$subtopicId=($row1["subtopicId"]);
											$subtopicName=($row1["subtopicName"]);
											$SubkeyId=($row1["keyId"]);
											$SubkeyName=($row1["keyName"]);
											if (strrpos($videoSubTopic,"_".$subtopicId."_") AND $SubkeyName) {
												if ($subtopicName!=$subtopicNameOld) {?><div class="clear"></div><div style="padding: 5px 0 2px 0;font-size: 1.2em;font-weight: 500;"><?=$topicName?> / <?=$subtopicName?></div><?php }
												?><div style="float: left;width: 300px;"><?php 
													?><div><input type="checkbox" name="key<?=$SubkeyId?>" value="<?=$SubkeyId?>" <?php if (strrpos($videoKeywords,"_".$SubkeyId."_")) echo "checked=\"checked\"";?> /> <label style="font-size: 1.0em;font-weight: 300;"><?=$SubkeyName?></label></div><?php 
												?></div><?php 
											}
											$subtopicNameOld=$subtopicName;
										}
									}

									$topicNameOld=$topicName;
								}
								?>
								<div class="clear"></div>
							</div>
						</div>
						
						<?php if ($fromPage=="edit") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_TchMatEdit.php?id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } elseif ($fromPage=="valedit" OR $fromPage=="toggle") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_TchMatValidateEdit.php?from=<?=$fromPage?>&id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } else {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_TchMatManage.php"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="Proceed" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php }?>



						<!-- <div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SNA_TchMatManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;padding: 5px;" />
							<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;padding: 5px;" />
						</div> -->



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>