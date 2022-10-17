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

$validateValue=0;
if (isset($_POST['examine'])) $validateValue=4;
if ($fromPage=="valedit") $validateValue=4;

if ($fromPage=="edit") $pageTitle="Edit Video Lesson";
elseif ($fromPage=="valedit" OR $fromPage=="toggle") $pageTitle="Validate Video Lesson";
else $pageTitle="Insert New Video Lesson";

if ($_GET["act"]=="reg" AND $usrId) {

	$_SESSION['post_data']=$_POST;

	// Questions
	$videoQuestions="key_";
	foreach($_POST as $chiave => $valore) { 
		if (substr($chiave,0,3)=="qst") {
			$qstId=substr($chiave,3);
			$videoQuestions.=$qstId."_";
		}
	} 

	$checkStatus=0;
	if (
		$usrId AND 
		$usrTypology=="lecturer" AND 
		$usr_completeProfile==1 AND 
		$videoQuestions!="key_"
	) $checkStatus=1;

	if ($checkStatus) {

		/* Registro topic/subtopic associati al video */
		$sql = "
			UPDATE `platform__SNA__VID_lessons` 
			SET 
				questions='$videoQuestions', 
				validate='$validateValue'
			WHERE id=$vidId";
		$result=mysqli_query($conn,$sql);
		
		if ($fromPage=="edit") $redirectUrl="./MP_LECT_SNA_videoLesEdit.php?id_act=".$vidId; // passa alla pagina di edit
		elseif ($fromPage=="valedit" OR $fromPage=="toggle") $redirectUrl="./MP_LECT_SNA_videoLesValidateEdit.php?from=".$fromPage."&id_act=".$vidId; // passa alla pagina di edit
		else $redirectUrl="./MP_LECT_SNA_videoLesManage.php"; // torna alla lista delle video reviews

	} else $redirectUrl="./MP_LECT_SNA_videoLesAdd3.php?idVideo=".$vidId."&msg=KO&from=".$fromPage;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
} else {

	$sql = "
		SELECT *, p.id AS vidId 
		FROM platform__SNA__VID_lessons AS p 
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
		$videoQuestions=$row["questions"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
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

					<p class="rsvPage_Title"><?=$pageTitle?></p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php if ($_GET["msg"]=="KO") {?>
						<div style="margin: 10px 0 25px 0;padding: 10px;font-size: 2.1em;color: #f00;text-align: center;border: solid 1px #f00;border-radius: 5px;">
							<p>Sorry but something went wrong. Please repeat the operation.</p>
						</div>
					<?php }?>

					<form method="post" action="./MP_LECT_SNA_videoLesAdd3.php?act=reg&idVideo=<?=$vidId?>&from=<?=$fromPage?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 20px 0 20px 15px;border: solid 1px #00aeef;border-radius: 10px;">

						<p>Please select questions for this video reviews</p>

						<div>


							
							
							
								<?php 


								$where=" WHERE (p.validate=1 AND ";
								
								// topic
								$videoTopic=substr($videoTopic,4);
								if ($videoTopic) {
									$videoTopic=substr($videoTopic,0,-1);
									$videoTopicArray=explode("_",$videoTopic);
									$where.="((";
									$where1="";
									foreach ($videoTopicArray as $value){ 
										$where1.="p.topic={$value} OR "; 
									}
									$where1=substr($where1,0,-4);
									$where.=$where1.") AND subtopic=0) OR  ";
								}
								
								// subtopic
								$videoSubTopic=substr($videoSubTopic,4);
								if ($videoSubTopic) {
									$videoSubTopic=substr($videoSubTopic,0,-1);
									$$videoSubTopicArray=explode("_",$videoSubTopic);
									$where.="(";
									$where2="";
									foreach ($$videoSubTopicArray as $value){ 
										$where2.="p.subtopic={$value} OR "; 
									}
									$where2=substr($where2,0,-4);
									$where.=$where2.") OR  ";
								}

								$where=substr($where,0,-4);
								$where.=")";

								$sqlP = "
									SELECT *, p.id AS qstId, q.name AS topicName, k.name AS subTopicName  
									FROM platform__SNA__questions AS p 
									LEFT JOIN platform__topic AS q 
									ON p.topic=q.id 
									LEFT JOIN platform__subtopic AS k 
									ON p.subtopic=k.id 
									$where 
									ORDER BY date ASC";
								$resultP=mysqli_query($conn,$sqlP);
								if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

//								$q_pag=10; //quanti per pagina
//								$pagine1=bcdiv($totale,$q_pag,3);
//								$pagine = ceil($pagine1); //arrotonda all'intero maggiore
//								$page_from=($page-1)*$q_pag;
//
//								$sqlP = $sqlP." LIMIT ".$page_from.",".$q_pag.";";
//								$resultP=mysqli_query($conn,$sqlP);
								?>
				
								<div style="margin: 25px 0 5px 5px;">
									<p style="float: right;width: 300px;padding: 0 30px 0 0;text-align: right;">Found <?=$totale?> questions</p>
									<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
									<div class="clear"></div>
								</div>


								<?php if ($totale>0) {?>
									<div style="width: 100%;height: 400px;overflow: auto;">
									<table class="table table-hover">
										<thead>
											<tr>
												<th class="tdtit"></th>
												<th class="tdtit">Question</th>
												<th class="tdtit"></th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$count=1;
										while ($row=mysqli_fetch_array($resultP)) { 

											//$pict_id=$row["id"];
											$qstId=$row["qstId"];
											$description=$row["description"];
											$topic=$row["topicName"];
											$subTopic=$row["subTopicName"];
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

											$topicTr=$topic;
											if ($subTopic) $topicTr.=" / ".$subTopic;

											$valName="";
											if ($validate_by) {
												$sql33 = "
													SELECT * 
													FROM platform__user 
													WHERE id='$validate_by' 
													LIMIT 1";
												$result33=mysqli_query($conn,$sql33);

												while ($row33=mysqli_fetch_array($result33)) { 
													$valName=$row33["name"];
													$valSurname=$row33["surname"];
												}

												if ($valSurname) $valName.=" ".$valSurname;
											}


											$lnk1="./MP_LECT_SNA_questionValidateEdit.php?id_act=".$qstId."&".$queryStr;
											$lnk3="./MP_LECT_SNA_questionValidateResponse.php?id_act=".$qstId."&".$queryStr."&from=toggle";

											if ($date!="" AND $date!="0000-00-00 00:00:00") {
												$ins_data_expl=explode("-",$date);
												$ins_data_aa=$ins_data_expl[0];
												$ins_data_mm=$ins_data_expl[1];
												$ins_data_expl1=explode(" ",$ins_data_expl[2]);
												$ins_data_gg=$ins_data_expl1[0];
												$ins_data_expl2=explode(":",$ins_data_expl1[1]);
												$ins_data_ora=$ins_data_expl2[0];
												$ins_data_min=$ins_data_expl2[1];
												$date=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa;
											} else $date="";
											if ($validate_date!="" AND $validate_date!="0000-00-00 00:00:00") {
												$val_data_expl=explode("-",$validate_date);
												$val_data_aa=$val_data_expl[0];
												$val_data_mm=$val_data_expl[1];
												$val_data_expl1=explode(" ",$val_data_expl[2]);
												$val_data_gg=$val_data_expl1[0];
												$val_data_expl2=explode(":",$val_data_expl1[1]);
												$val_data_ora=$val_data_expl2[0];
												$val_data_min=$val_data_expl2[1];
												$validate_date=$val_data_gg."/".$val_data_mm."/".$val_data_aa;
											} else $validate_date="";

											$attach=0;
											$pict="./data/mathePlatform/SNA/attach/{$qstId}.{$fileExt}";
											if (file_exists($pict)) $attach=1;

											?>
											<tr>
												<td style="font-size: 0.9em;">
													<input type="checkbox" name="qst<?=$qstId?>" value="1" <?php if (strrpos($videoQuestions,"_".$qstId."_")) echo "checked=\"checked\"";?> />
													<!-- <p style="font-size: 0.8em;"><?=$date?></p>
													<p style="padding-top: 5px">Code:<br /><strong>SNA<?=$qstId?></strong></p>
													<p style="padding-top: 5px">Level:<br /><strong><?=$level?></strong></p> -->
												</td>
												<td style="font-size: 0.9em;line-height: 1.0em;">
													<?php if ($topicTr) {?><p style="padding: 0 0 10px 0;font-size: 0.9em;color: #999;">Topic: <?=$topicTr?></p><?php }?>
													<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($question)?></div>
													<?php if ($attach) {?><p style="padding: 10px 0 10px 0;">Attachment: <a href="<?=$pict?>" target="_blank" style="font-size: 1.0em;color: #900;"><?=$fileName?></a></p><?php }?>

													<div id="<?=$qstId?>_ansBlk" style="display: none;">
														<div style="float: left;width: 500px;margin-top: 5px;padding: 5px;border: solid 1px #090;">
															<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #090;">Answer 1: TRUE</p>
															<p><?=nl2br($answer1)?></p>
														</div>
														<div style="float: left;width: 500px;margin-top: 5px;padding: 5px;border: solid 1px #900;">
															<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 2: FALSE</p>
															<p><?=nl2br($answer2)?></p>
														</div>
														<div class="clear"></div>
														<div style="float: left;width: 500px;margin-top: 5px;padding: 5px;border: solid 1px #900;">
															<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 3: FALSE</p>
															<p><?=nl2br($answer3)?></p>
														</div>
														<div style="float: left;width: 500px;margin-top: 5px;padding: 5px;border: solid 1px #900;">
															<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 4: FALSE</p>
															<p><?=nl2br($answer4)?></p>
														</div>
														<div class="clear"></div>
													</div>
												</td>
												<td style="text-align: right;">
													<a href="javascript: void()" onclick="showhidd('<?=$qstId?>_ansBlk');">show answers</a><br />
												</td>
											</tr>
											<?php 
											$count+=1;
										}
										?>
										</tbody>
									</table>					
									</div>

									<?php if ($pagine>1) include('./impianto/paginazione.php'); //paginazione?>
								
								<?php } else {?>	
									<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">There is no approved questions</p>
								<?php }?>
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
						</div>
						

						<!-- <div class="signup_submit" style="padding-left: 70px;">
							<a href="./MP_LECT_SNA_videoLesManage.php"><button type="button" class="abort" />Abort</button></a>
							<input type="submit" value="Proceed" class="proceed" style="margin-left: 20px;" />
						</div> -->
						
						<?php if ($fromPage=="edit") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoLesEdit.php?id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } elseif ($fromPage=="valedit" OR $fromPage=="toggle") {?>
							<div class="signup_submit" style="width: 240px;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoLesValidateEdit.php?from=<?=$fromPage?>&id_act=<?=$vidId?>"><button type="button" class="abort" style="margin: 0 0 0 0;font-size: 1.5em;padding: 5px 20px;" />Abort</button></a>
								<input type="submit" value="SAVE" class="proceed" style="margin: 0 0 0 20px;font-size: 1.5em;padding: 5px 20px;" />
							</div>
						<?php } else {?>
							<div class="signup_submit" style="width: auto;margin: 25px auto;">
								<a href="./MP_LECT_SNA_videoLesManage.php<?=$queryStr?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a>
								<input type="submit" name="save" value="SAVE" class="proceed" style="width: 150px;margin-left: 100px;font-size: 1.3em;padding: 5px 20px;" />
								<input type="submit" name="examine" value="SEND FOR VALIDATION" class="proceed" style="width: 250px;margin-left: 5px;font-size: 1.3em;padding: 5px 20px;" />
							</div>
						<?php }?>





					</form>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>