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

//////////////////////////////////   sanitize var $_get e $_post /////////////////////
$DS=DIRECTORY_SEPARATOR;
$root=".".$DS;
//require_once($root."lib".$DS."htmlpurifier".$DS."library".$DS."HTMLPurifier.auto.php");
//require_once($root."lib".$DS."sanitize".$DS."sanitizeAll.lib.php");
// -------------------------------   verifica dell'upload
require_once($root."lib".$DS."upload".$DS."conf".$DS."config.php");
require_once($root."lib".$DS."upload".$DS."classes".$DS."class.check.php");
//////////////////////////////////   sanitize var get e post /////////////////////

$assId=Pulisci_INS($_GET["assId"]);
$qstNb=Pulisci_INS($_GET["qstNb"]);
$qstId=Pulisci_INS($_GET["qstId"]);

if ($_GET["act"]=="reg" AND $usrId AND $assId AND $qstNb AND $qstId) {


	/* Cancello la vecchia domanda se presente */
	$sql = "
		SELECT * 
		FROM platform__SFA__assestment 
		WHERE id='$assId' 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	if (strlen($qstNb)==1) $qstNb="0".$qstNb;
	while ($row=mysqli_fetch_array($result)) { 
		$qstIdBefore=$row["qst".$qstNb];
	}

	if ($qstIdBefore) {

		$sql = "
			SELECT *
			FROM platform__SFA__assquestions 
			WHERE (id='$qstIdBefore' AND id_lect=$usrId) 
			LIMIT 1";
		$result=mysqli_query($conn,$sql);

		while ($row=mysqli_fetch_array($result)) { 
			$fileExt=$row["file_ext"];
		}
		
		$sql = "
			DELETE 
			FROM `platform__SFA__assquestions` 
			WHERE (id='$qstIdBefore' AND id_ass=$assId AND id_lect=$usrId)";
		$result=mysqli_query($conn,$sql);

		/* Cancello il file associat0 */
		$pict="./data/mathePlatform/SFA/assAttach/{$qstIdBefore}.{$fileExt}";
		if(file_exists($pict)) unlink($pict);

	}


	/* Ricavo i dati della domanda da importare */
	$sql = "
		SELECT * 
		FROM platform__SFA__questions 
		WHERE id='$qstId' 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$description=$row["description"];
		$topic=$row["topic"];
		$subTopic=$row["subtopic"];
		$question=addslashes($row["question"]);
		$level=$row["level"];
		$answer1=addslashes($row["answer1"]);
		$answer2=addslashes($row["answer2"]);
		$answer3=addslashes($row["answer3"]);
		$answer4=addslashes($row["answer4"]);
		$fileName=$row["file_name"];
		$fileExt=$row["file_ext"];
	}

	/* Copio la domanda nella nuova tabella */
	$sql = "
		INSERT INTO `platform__SFA__assquestions` 
		(`id_lect`, `id_ass`, `point`, `description`, `topic`, `subtopic`, `question`, `level`, `answer1`, `answer2`, `answer3`, `answer4`, `file_name`, `file_ext`)  
		VALUES ('$usrId', '$assId', '1', '$description', '$topic', '$subTopic', '$question', '$level', '$answer1', '$answer2', '$answer3', '$answer4', '$fileName', '$fileExt')";
	$result=mysqli_query($conn,$sql);
	$qstIdNew=mysqli_insert_id($conn);

	$fileAllegato="./data/mathePlatform/SFA/attach/{$qstId}.{$fileExt}";
	if (file_exists($fileAllegato)) {
		// Copio l'allegato
		//$path=ereg_replace("MP_LECT_SFA_assessmentNew1.php","",$_SERVER["PATH_TRANSLATED"]);
		
		$originale = "./data/mathePlatform/SFA/attach/".$qstId.".".$fileExt; 
		$copia = "./data/mathePlatform/SFA/assAttach/".$qstIdNew.".".$fileExt; 

		copy($originale, $copia); 
		chmod($copia, 0777);
	}


	if (strlen($qstNb)==1) $qstNb="0".$qstNb;
	$sql = "
		UPDATE `platform__SFA__assestment` 
		SET 
			qst{$qstNb}='$qstIdNew'
		WHERE (id=$assId AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);

	if ($result) $rst="OK"; else $rst="KO";

	// Redirect
	$redirectUrl="./MP_LECT_SFA_assessmentNew1.php?assId=".$assId."&msg=".$rst;
	echo "<script language=javascript>document.location.href='{$redirectUrl}'</script>";
	die();

} else {


	$sql = "
		SELECT * 
		FROM platform__SFA__assestment
		WHERE (id='$assId' AND id_lect=$usrId) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$titleSFA=$row["title"];
		$description=$row["description"];
		$FA_date=$row["FA_date"];
		$duration=$row["duration"];
		$status=$row["status"];
		$qst01FA=$row["qst01"];
		$qst02FA=$row["qst02"];
		$qst03FA=$row["qst03"];
		$qst04FA=$row["qst04"];
		$qst05FA=$row["qst05"];
		$qst06FA=$row["qst06"];
		$qst07FA=$row["qst07"];
		$qst08FA=$row["qst08"];
		$qst09FA=$row["qst09"];
		$qst10FA=$row["qst10"];
		$qst11FA=$row["qst11"];
		$qst12FA=$row["qst12"];
		$qst13FA=$row["qst13"];
		$qst14FA=$row["qst14"];
		$qst15FA=$row["qst15"];
		$qst16FA=$row["qst16"];
		$qst17FA=$row["qst17"];
		$qst18FA=$row["qst18"];
		$qst19FA=$row["qst19"];
		$qst20FA=$row["qst20"];
	}

	$FA_date=Date("Y-m-d H:i:s",strtotime($FA_date));
	$date = date_create($FA_date, timezone_open('UTC'));
	$Dt1=$date->format('Y-m-d H:i:s');
	date_timezone_set($date, timezone_open($uniTimezone));
	$FA_date=$date->format('Y-m-d H:i:s');
								
	if ($FA_date!="" AND $FA_date!="0000-00-00 00:00:00") {
		$ins_data_expl=explode("-",$FA_date);
		$ins_data_aa=$ins_data_expl[0];
		$ins_data_mm=$ins_data_expl[1];
		$ins_data_expl1=explode(" ",$ins_data_expl[2]);
		$ins_data_gg=$ins_data_expl1[0];
		$ins_data_expl2=explode(":",$ins_data_expl1[1]);
		$ins_data_ora=$ins_data_expl2[0];
		$ins_data_min=$ins_data_expl2[1];
		$FA_date=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa." ".$ins_data_ora.":".$ins_data_min;
	} else $FA_date="";



	if ($status) $statusTr="<span style=\"font-size: 1.2em;font-weight: 600;color: #070;\">PUBLISHED</span>";
	else $statusTr="<span style=\"font-size: 1.2em;font-weight: 600;color: #c00;\">NOT PUBLISHED</span>";
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

					<div class="signup_submit" style="padding: 0 0 10px 0;">
						<p style="float: left;width: 300px;padding: 50px 10px 0 0;"></p>
						<p style="float: right;width: 113px;padding: 0 10px 0 0;"><a href="./MP_LECT_SFA_assessmentManage.php"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a></p>
						<div class="clear"></div>
					</div>

					<div style="margin: 20px 0;padding: 10px;background-color: #e1f8ff;border-radius: 10px;">
						<p style="padding: 0 0 10px 0;"><strong>Status:</strong> <?=$statusTr?></p>
						<p style="padding: 0;font-size: 1.2em;font-weight: 600;"><strong><?=nl2br($titleSFA)?></strong></p>
						<p style="padding: 0 0 10px 0;font-size: 1.0em;font-weight: 200;font-style: italic;line-height: 1.2em;"><em><?=nl2br($description)?></em></p>
						<p><strong>Date and Time:</strong> <?=$FA_date?></p>
						<p><strong>Duration:</strong> <?=$duration?> minutes</p>
						<p style="margin-top: -20px;text-align: right;"><a href="./MP_LECT_SFA_assessmentEdit.php?assId=<?=$assId?>">edit</a></p>
					</div>

					<!-- <p>Please choose the questions</p> -->		
					
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit" style="text-align: center;">Point</th>
								<th class="tdtit" style="width: 100%;">Question</th>
								<th class="tdtit"></th>
							</tr>
						</thead>
						<tbody>
							<?php for ($k=1;$k<=20;$k++) {
								$qstId="";
								$point="";
								$description="";
								$topic="";
								$subTopic="";
								$question="";
								$level="";
								$answer1="";
								$answer2="";
								$answer3="";
								$answer4="";
								$fileName="";
								$fileExt="";
								
								if (strlen($k)==1) $kcorr="0".$k; else  $kcorr=$k;
								$silly=${"qst".$kcorr."FA"};
								if ($silly) {

//									$sql = "
//										SELECT *, p.id AS qstId 
//										FROM platform__SFA__questions AS p 
//										WHERE (p.id='$silly') 
//										LIMIT 1";
//									$result=mysqli_query($conn,$sql);

									$sql = "
										SELECT *, p.id AS qstId, q.name AS topicName, k.name AS subTopicName  
										FROM platform__SFA__assquestions AS p 
										LEFT JOIN platform__topic AS q 
										ON p.topic=q.id 
										LEFT JOIN platform__subtopic AS k 
										ON p.subtopic=k.id 
										WHERE (p.id='$silly') 
										LIMIT 1";
									$result=mysqli_query($conn,$sql);

									while ($row=mysqli_fetch_array($result)) { 
										$qstId=$row["qstId"];
										$point=$row["point"];
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
									}

									//if ($point=="0.00") $point="1.00";

									$topicTr=$topic;
									if ($subTopic) $topicTr.=" / ".$subTopic;

									$attach=0;
									$pict="./data/mathePlatform/SFA/assAttach/{$qstId}.{$fileExt}";
									if (file_exists($pict)) $attach=1;

									$lnk1="./MP_LECT_SFA_assessmentNew2.php?assId=".$assId."&qstNb=".$k;
									$lnk2="./MP_LECT_SFA_assessmentQstEdit.php?assId=".$assId."&qstNb=".$k."&qstId=".$qstId;
									$lnk3="./MP_LECT_SFA_assessmentQstDelete.php?assId=".$assId."&qstNb=".$k."&qstId=".$qstId;
								}
								
								$param=$assId."|".$qstId."|".$usrId;
								?>
								<tr>
									<td style="font-size: 0.9em;">
										<p style="padding-top: 10px;"><strong style="display: block;width: 20px;padding: 1px 0;font-size: 1.0em;color: #fff;text-align: center;border: solid 1px #c00;border-radius: 100px;background-color: #c00;"><?=$k?></strong></p>
									</td>
									<td style="font-size: 0.9em;">
										<?php if ($qstId) {?><p style="padding-top: 5px"><input type="text"  name="<?=$qstId?>point" value="<?=$point?>" onchange="qstPoint('<?=$param?>',this.value);" style="display: block;margin: 0 auto;width: 60px;height: 30px;font-size: 1.4em;color: #444;text-align: center;border: solid 2px #ccc;" /></p><?php }?>
									</td>
									<td style="font-size: 0.9em;line-height: 1.0em;">
										<?php if ($qstId) {?>
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
										<?php }?>
									</td>
									<td style="text-align: right;">
										<?php if ($qstId) {?>
											<!-- <?php if ($validate==0 OR $validate==2) {?><a href="<?=$lnk3?>">delete</a> / <a href="<?=$lnk1?>">edit</a><br /><?php }?> -->
											<a href="<?=$lnk3?>">delete</a> / <a href="<?=$lnk1?>">change</a><br />
											<a href="<?=$lnk2?>">edit question</a><br /><br />
											<a href="javascript: void()" onclick="showhidd('<?=$qstId?>_ansBlk');">show answers</a><br />
										<?php } else {?>
											<div style="width: 90px;padding: 10px 5px;font-weight: 400;text-align: center;border: solid 1px #c00;">
												<p><a href="./MP_LECT_SFA_assessmentNew2.php?assId=<?=$assId?>&qstNb=<?=$k?>" style="color: #c00;">CHOOSE QUESTION</a></p>
											</div>
										<?php }?>
									</td>
								</tr>
							<?php }?>
						</tbody>
					</table>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>