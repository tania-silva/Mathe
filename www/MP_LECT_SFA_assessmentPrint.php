<?php
include('./impianto/inc/function.php'); // funzioni PHP
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$siteTitle?></title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
    <link href="css/menu/examples.css" rel="stylesheet">
    <link href="css/menu/navigation.css" rel="stylesheet">
	
	<!-- Reserved Area -->
	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap" rel="stylesheet">
	<script type="text/javascript" src="./impianto/js/script.js"></script>
    <link href="./impianto/css/reservedArea.css" rel="stylesheet">
	<?php include_once("./impianto/addons/ckeditor/ckeditor.php") ;?>
    <script type="text/javascript" src="./impianto/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="./impianto/addons/ckfinder/ckfinder.js"></script>
    
    <script type="text/javascript" src="js/menu/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="js/menu/navigation.js"></script>
    <script type="text/javascript" src="js/menu/examples.js"></script>
    
</head>

<body>

<?php include('./impianto/inc/protectedGuest.php'); //Se non loggato esci...?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">





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
		(`id_lect`, `id_ass`, `description`, `topic`, `subtopic`, `question`, `level`, `answer1`, `answer2`, `answer3`, `answer4`, `file_name`, `file_ext`)  
		VALUES ('$usrId', '$assId', '$description', '$topic', '$subTopic', '$question', '$level', '$answer1', '$answer2', '$answer3', '$answer4', '$fileName', '$fileExt')";
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
	

					<p class="rsvPage_Title1">Student Final Assessment</p>


					<div style="margin: 20px 0;padding: 10px;background-color: #e1f8ff;border-radius: 10px;">
						<p style="padding: 0 0 10px 0;"><strong>Status: Done</strong></p>
						<p style="padding: 0;font-size: 1.2em;font-weight: 600;"><strong><?=nl2br($titleSFA)?></strong></p>
						<p style="padding: 0 0 10px 0;font-size: 1.0em;font-weight: 200;font-style: italic;line-height: 1.2em;"><em><?=nl2br($description)?></em></p>
						<p><strong>Date and Time:</strong> <?=$FA_date?></p>
						<p><strong>Duration:</strong> <?=$duration?> minutes</p>
					</div>

					<!-- <p>Please choose the questions</p> -->		
					
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit" style="text-align: center;">Point</th>
								<th class="tdtit" style="width: 100%;">Question</th>
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

								if ($qstId) {
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

											<div id="<?=$qstId?>_ansBlk" style="display: block;">
												<div style="display: block;margin-top: 5px;padding: 5px;border: solid 1px #090;">
													<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #090;">Answer 1: TRUE</p>
													<p><?=nl2br($answer1)?></p>
												</div>
												<div style="display: block;margin-top: 5px;padding: 5px;border: solid 1px #900;">
													<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 2: FALSE</p>
													<p><?=nl2br($answer2)?></p>
												</div>
												<div class="clear"></div>
												<div style="display: block;margin-top: 5px;padding: 5px;border: solid 1px #900;">
													<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 3: FALSE</p>
													<p><?=nl2br($answer3)?></p>
												</div>
												<div style="display: block;margin-top: 5px;padding: 5px;border: solid 1px #900;">
													<p style="padding: 0 0 5px 0;font-size: 0.9em;font-weight: 400;color: #900;">Answer 4: FALSE</p>
													<p><?=nl2br($answer4)?></p>
												</div>
												<div class="clear"></div>
											</div>
										<?php }?>
									</td>
								</tr>
								<?php 
								}
							}
							?>
						</tbody>
					</table>
