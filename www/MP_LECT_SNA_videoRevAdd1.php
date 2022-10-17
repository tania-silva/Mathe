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

//$validateValue=0;
//if (isset($_POST['examine'])) $validateValue=4;
//if ($fromPage=="valedit") $validateValue=4;

if ($fromPage=="edit") $pageTitle="Edit Video Review";
elseif ($fromPage=="valedit" OR $fromPage=="toggle") $pageTitle="Validate Video Review";
else $pageTitle="Insert New Video Review";

if ($_GET["act"]=="reg" AND $usrId) {

	$_SESSION['post_data']=$_POST;

//	$topic=Pulisci_INS($_POST["topic"]);
//	$subTopic=Pulisci_INS($_POST["subtopic"]);

	// Topic
	$videoTopic="key_";
	$sql = "
		SELECT * 
		FROM platform__topic 
		WHERE hidden=0 
		ORDER BY name";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id"];
		
		if ($_POST["topic".$id_key]==$id_key) $videoTopic.=$id_key."_";
	}

	// SubTopic
	$videoSubTopic="key_";
	$sql = "
		SELECT * 
		FROM platform__subtopic 
		ORDER BY name";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$id_key=$row["id"];
		
		if ($_POST["subtopic".$id_key]==$id_key) $videoSubTopic.=$id_key."_";
	}

	if ($fromPage) {
		// Siamo in modalità modifica quindi devo verificare che non siano state tolti topic/subtopic e casomai intervenire.
		$sql = "
			SELECT *, p.id AS vidId 
			FROM platform__SNA__VID_reviews AS p 
			WHERE (p.id='$vidId' AND p.id_lect=$usrId) 
			ORDER BY p.date DESC";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$videoTopicOld=$row["topic"];
			$videoSubTopicOld=$row["subtopic"];
			$videoKeywordsOld=$row["keywords"];
			$videoQuestionsOld=$row["questions"];
		}

		$videoKeywordsNew=$videoKeywordsOld;
		$videoQuestionsNew=$videoQuestionsOld;

		if ($videoTopicOld!=$videoTopic) {
			//trovo i topic tolti

			// topic
			$videoTopic1=substr($videoTopicOld,4); //tolgo key_
			if ($videoTopic1) {
				$videoTopic1=substr($videoTopic1,0,-1); //tolgo ultimo _
				$videoTopicArray=explode("_",$videoTopic1);

				foreach ($videoTopicArray as $value) { 
					if (!strrpos($videoTopic,"_".$value."_")) {
						
						// Elimino le keywords del topic eliminato
						$sql22 = "
							SELECT *, p.id AS keyId 
							FROM platform__keywords AS p 
							WHERE (p.id_top='$value' AND p.id_sub=0)";
						$result22=mysqli_query($conn,$sql22);

						while ($row22=mysqli_fetch_array($result22)) { 
							$TmpKeyId=$row22["keyId"];

							if (strrpos($videoKeywordsOld,"_".$TmpKeyId."_")) {
								$videoKeywordsNew=str_replace("_".$TmpKeyId."_","_",$videoKeywordsNew);
								//echo "<br />".$TmpKeyId."<br />".$videoKeywordsOld."<br />".$videoKeywordsNew;
							}
						}
						
						// Elimino le questions del topic eliminato
						$sql23 = "
							SELECT *, p.id AS qstId 
							FROM platform__SNA__questions AS p 
							WHERE (p.topic='$value' AND p.subtopic=0)";
						$result23=mysqli_query($conn,$sql23);

						while ($row23=mysqli_fetch_array($result23)) { 
							$TmpQstId=$row23["qstId"];

							if (strrpos($videoQuestionsOld,"_".$TmpQstId."_")) {
								$videoQuestionsNew=str_replace("_".$TmpQstId."_","_",$videoQuestionsNew);
								//echo "<br />".$TmpQstId."<br />".$videoQuestionsOld."<br />".$videoQuestionsNew;
							}
						}
					}
				}
				
				$sql = "
					UPDATE `platform__SNA__VID_reviews` 
					SET 
						keywords='$videoKeywordsNew',
						questions='$videoQuestionsNew', 
					WHERE id=$vidId";
				$result=mysqli_query($conn,$sql);
			}
		}

		if ($videoSubTopicOld!=$videoSubTopic) {
			//trovo i subtopic tolti

			// subtopic
			$videoSubTopic1=substr($videoSubTopicOld,4); //tolgo key_
			if ($videoSubTopic1) {
				$videoSubTopic1=substr($videoSubTopic1,0,-1); //tolgo ultimo _
				$videoSubTopicArray=explode("_",$videoSubTopic1);

				foreach ($videoSubTopicArray as $value) { 
					if (!strrpos($videoSubTopic,"_".$value."_")) {
						
						// Elimino le keywords del subtopic eliminato
						$sql22 = "
							SELECT *, p.id AS keyId 
							FROM platform__keywords AS p 
							WHERE (p.id_top='$value' AND p.id_sub=0)";
						$result22=mysqli_query($conn,$sql22);

						while ($row22=mysqli_fetch_array($result22)) { 
							$TmpKeyId=$row22["keyId"];

							if (strrpos($videoKeywordsOld,"_".$TmpKeyId."_")) {
								$videoKeywordsNew=str_replace("_".$TmpKeyId."_","_",$videoKeywordsNew);
								//echo "<br />".$TmpKeyId."<br />".$videoKeywordsOld."<br />".$videoKeywordsNew;
							}
						}
						
						// Elimino le questions del subtopic eliminato
						$sql23 = "
							SELECT *, p.id AS qstId 
							FROM platform__SNA__questions AS p 
							WHERE (p.subtopic='$value')";
						$result23=mysqli_query($conn,$sql23);

						while ($row23=mysqli_fetch_array($result23)) { 
							$TmpQstId=$row23["qstId"];

							if (strrpos($videoQuestionsOld,"_".$TmpQstId."_")) {
								$videoQuestionsNew=str_replace("_".$TmpQstId."_","_",$videoQuestionsNew);
								//echo "<br />".$TmpQstId."<br />".$videoQuestionsOld."<br />".$videoQuestionsNew;
							}
						}
					}
				}
			}
		}
	}

	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$usr_completeProfile==1 AND 
		($videoTopic!="key_" OR $videoSubTopic!="key_")
	) $checkStatus=1;

	if ($checkStatus) {

		/* Registro topic/subtopic associati al video */
		$sql = "
			UPDATE `platform__SNA__VID_reviews` 
			SET 
				topic='$videoTopic', 
				subtopic='$videoSubTopic',
				keywords='$videoKeywordsNew',
				questions='$videoQuestionsNew' 
			WHERE id=$vidId";
		$result=mysqli_query($conn,$sql);
		
		if ($fromPage=="edit") $redirectUrl="./MP_LECT_SNA_videoRevEdit.php?id_act=".$vidId; // passa alla pagina di edit
		elseif ($fromPage=="valedit" OR $fromPage=="toggle") $redirectUrl="./MP_LECT_SNA_videoRevValidateEdit.php?from=".$fromPage."&id_act=".$vidId; // passa alla pagina di edit
		else $redirectUrl="./MP_LECT_SNA_videoRevAdd2.php?idVideo=".$vidId; // passa alla scelta delle keywords 

	} else $redirectUrl="./MP_LECT_SNA_videoRevAdd1.php?idVideo=".$vidId."&msg=KO&from=".$fromPage;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__VID_reviews AS p 
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
		$fileExt=$row["file_ext"];
		$date=$row["date"];
	}

}
?>

					<p class="rsvPage_Title"><?=$pageTitle?></p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>In order to proceed, you need to select at least one topic or subtopic.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_LECT_SNA_videoRevAdd1.php?act=reg&idVideo=<?=$vidId?>&from=<?=$fromPage?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 50px;border: solid 1px #00aeef;border-radius: 10px;">

						<p>Please select topic/subtopic for this video reviews</p>

						<div style="padding-top: 25px;">
							<label style="display: block;padding: 0 0 5px 0;font-weight: 400;color: #c00;">* Topic/Subtopic</label>
							<div style="width: 625px;padding: 10px 0 10px 10px;border: dotted 1px #00aeef;border-radius: 5px;">

								<?php 
								$sql = "
									SELECT * 
									FROM platform__topic 
									WHERE hidden=0 
									ORDER BY name ASC";
								$result=mysqli_query($conn,$sql);

								while ($row=mysqli_fetch_array($result)) { 
									$topicId=($row["id"]);
									$topicName=($row["name"]);

									
									$sql11 = "
										SELECT * 
										FROM platform__subtopic 
										WHERE id_top=$topicId AND hidden=0 
										ORDER BY name ASC";
									$result11=mysqli_query($conn,$sql11);
									if ($result11) $totSubTop=mysqli_num_rows($result11);

									$objActive="";
									if ($totSubTop>0) $objActive="disabled";

									?>
									<div style="padding: 5px 0 2px 0;font-size: 1.2em;font-weight: 500;">
										<input type="checkbox" <?=$objActive?> name="topic<?=$topicId?>" value="<?=$topicId?>" <?php if (strrpos($videoTopic,"_".$topicId."_")) {?> checked <?php if ($fromPage=="valedit" OR $fromPage=="toggle") {?>disabled<?php }?><?php }?> /> 
										<?php if (strrpos($videoTopic,"_".$topicId."_") AND ($fromPage=="valedit" OR $fromPage=="toggle")) {?><input type="hidden" <?=$objActive?> name="topic<?=$topicId?>" value="<?=$topicId?>" /><?php }?>
										<label><?php if (strrpos($videoTopic,"_".$topicId."_")) {?><strong style="color: #c00;"><?php }?><?=$topicName?><?php if (strrpos($videoTopic,"_".$topicId."_")) {?></strong><?php }?></label>
									</div>
									<?php 
									
									$sql1 = "
										SELECT * 
										FROM platform__subtopic 
										WHERE id_top=$topicId AND hidden=0 
										ORDER BY name ASC";
									$result1=mysqli_query($conn,$sql1);

									while ($row1=mysqli_fetch_array($result1)) { 
										$subtopicId=($row1["id"]);
										$subtopicName=($row1["name"]);
										?>
										<div style="padding: 0 0 0 25px;">
											<input type="checkbox" name="subtopic<?=$subtopicId?>" value="<?=$subtopicId?>" <?php if (strrpos($videoSubTopic,"_".$subtopicId."_")) {?> checked <?php if ($fromPage=="valedit" OR $fromPage=="toggle") {?>disabled<?php }?><?php }?> /> 
											<?php if (strrpos($videoSubTopic,"_".$subtopicId."_") AND ($fromPage=="valedit" OR $fromPage=="toggle")) {?><input type="hidden" name="subtopic<?=$subtopicId?>" value="<?=$subtopicId?>" /><?php }?>
											<label><?php if (strrpos($videoSubTopic,"_".$subtopicId."_")) {?><strong style="color: #c00;"><?php }?><?=$subtopicName?><?php if (strrpos($videoSubTopic,"_".$subtopicId."_")) {?></strong><?php }?></label>
										</div><?php 
									}

								}
								?>
							</div>
						</div>
						
						<?php if ($fromPage=="edit") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoRevEdit.php?from=<?=$fromPage?>&id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } elseif ($fromPage=="valedit" OR $fromPage=="toggle") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoRevValidateEdit.php?from=<?=$fromPage?>&id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } else {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoRevManage.php<?=$queryStr?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="Proceed" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php }?>


						<!-- <div class="signup_submit" style="padding-left: 30px;">
							<a href="./MP_LECT_SNA_videoRevManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
							<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;padding: 5px;" />
							<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;padding: 5px;" />
						</div> -->



					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>