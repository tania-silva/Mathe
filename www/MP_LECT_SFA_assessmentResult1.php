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
$stuId=Pulisci_INS($_GET["stuId"]);

// Ricavo i dati dello Studente
					
	$sql = "
		SELECT *, 
			p.id AS rqstId, 
			p.id_stud AS studId, 
			q.name AS studName, 
			q.surname AS studSurname, 
			p.status AS assRqstStatus, 
			b.email AS studEmail, 
			b.uni_department AS studUniDepartment, 
			b.usn AS studUsn 
		FROM platform__SFA__subscription as p 
		LEFT JOIN platform__user as q 
			ON p.id_stud=q.id 
		LEFT JOIN platform__students as b 
			ON p.id_stud=b.id_stud 
		WHERE (p.id_ass=$assId AND q.id=$stuId) 
		ORDER BY p.status ASC, q.surname DESC";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$studName=$row["studName"];
		$studSurname=$row["studSurname"];
		$RqstStatus=$row["assRqstStatus"];
		$studEmail=$row["studEmail"];
		$studUniDepartment=$row["studUniDepartment"];
		$studUsn=$row["studUsn"];
	}

// FINE Ricavo i dati dello Studente
	
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

/* Ricavo dati dell'esame */
$sql = "
	SELECT * 
	FROM platform__SFA__assanswer 
	WHERE id_stud=$stuId AND id_ass=$assId
	LIMIT 1";
$result=mysqli_query($conn,$sql);

while ($row=mysqli_fetch_array($result)) { 
	$qst01=$row["qst01"];
	$qst02=$row["qst02"];
	$qst03=$row["qst03"];
	$qst04=$row["qst04"];
	$qst05=$row["qst05"];
	$qst06=$row["qst06"];
	$qst07=$row["qst07"];
	$qst08=$row["qst08"];
	$qst09=$row["qst09"];
	$qst10=$row["qst10"];
	$qst11=$row["qst11"];
	$qst12=$row["qst12"];
	$qst13=$row["qst13"];
	$qst14=$row["qst14"];
	$qst15=$row["qst15"];
	$qst16=$row["qst16"];
	$qst17=$row["qst17"];
	$qst18=$row["qst18"];
	$qst19=$row["qst19"];
	$qst20=$row["qst20"];
	$totPoint=$row["totpoint"];
	$endTime=$row["endtime"];
}

if ($endTime) {
	$endTime=Date("Y-m-d H:i:s",strtotime($endTime));
	$endDate = date_create($endTime, timezone_open('UTC'));
	date_timezone_set($endDate, timezone_open($uniTimezone));
	$endTime=$endDate->format('d/m/Y H:i');
} else $endTime="";

$qstAr = array($qst01, $qst02, $qst03, $qst04, $qst05, $qst06, $qst07, $qst08, $qst09, $qst10, $qst11, $qst12, $qst13, $qst14, $qst15, $qst16, $qst17, $qst18, $qst19, $qst20);

// Conto le domande
foreach ($qstAr as $question) {
	$questionSplit=explode("|",$question);
	$qstIdcicl=$questionSplit[0];
	if ($qstIdcicl) $qstNb+=1;
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

					<p class="rsvPage_Title">Results of Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					<div class="signup_submit" style="padding: 0 0 10px 0;">
						<p style="float: left;width: 300px;padding: 50px 10px 0 0;"></p>
						<p style="float: right;width: 113px;padding: 0 10px 0 0;"><a href="./MP_LECT_SFA_assessmentResult.php?assId=<?=$assId?>"><button type="button" class="abort" style="width: 100px;padding: 5px;" />Exit</button></a></p>
						<div class="clear"></div>
					</div>

					<div style="margin: 20px 0;padding: 10px;background-color: #e1f8ff;border-radius: 10px;">
						<p style="padding: 0 0 10px 0;"><strong>Status:</strong> <?=$statusTr?></p>
						<p style="padding: 0;font-size: 1.2em;font-weight: 600;"><strong><?=nl2br($titleSFA)?></strong></p>
						<p style="padding: 0 0 10px 0;font-size: 1.0em;font-weight: 200;font-style: italic;line-height: 1.2em;"><em><?=nl2br($description)?></em></p>
						<p><strong>Date and Time:</strong> <?=$FA_date?></p>
						<p><strong>Duration:</strong> <?=$duration?> minutes</p>
					</div>


					<div style="padding: 30px 0 0 0;">
						<div style="float: left;width: 450px;padding: 0 0 0 20px;font-size: 1.2em;text-align: left;border-right: solid 1px #444;">
							<p style="font-size: 1.3em;font-weight: 400;"><?=$studName?> <?=$studSurname?></p>
							<p><a href="mailto:<?=$studEmail?>"><?=$studEmail?></a></p>
							<p>USN: <?=$studUsn?></p>
							<p><?=$studUniDepartment?></p>
						</div>
						<div style="float: right;width: 250px;padding: 0 0 0 0;font-size: 1.2em;text-align: center;">
							<p style="font-size: 2.3em;">Score: <strong><?=$totPoint?></strong></p>
							<p>on a total number of <?=$qstNb?> questions.</p>
							<?php if ($endTime) {?><p>submitted <?=$endTime?></p><?php }?>
						</div>
						<div class="clear"></div>
					</div>



				
					<?php 
					$k=1;
					foreach ($qstAr as $question) {
						$questionSplit=explode("|",$question);
						$qstId=$questionSplit[0];
						$ansNb=$questionSplit[1];

						if ($qstId) { 

							$sql = "
								SELECT * 
								FROM platform__SFA__assquestions 
								WHERE id=$qstId
								LIMIT 1";
							$result=mysqli_query($conn,$sql);
							
							while ($row=mysqli_fetch_array($result)) { 
								$description=$row["description"];
								$questionX=$row["question"];
								$answer1X=$row["answer1"];
								$answer2X=$row["answer2"];
								$answer3X=$row["answer3"];
								$answer4X=$row["answer4"];
								$fileNameX=$row["file_name"];
								$fileExtX=$row["file_ext"];
								$dateX=$row["date"];
							}

							$answersArX = array("1||§§".$answer1X, "2||§§".$answer2X, "3||§§".$answer3X, "4||§§".$answer4X);
							shuffle($answersArX);

							$attachX=0;
							$pictX="./data/mathePlatform/SFA/assAttach/{$qstId}.{$fileExtX}";
							if (file_exists($pictX)) $attachX=1;

							$qstArray=$qstAr[$k-1];
							$ansRegAr=explode("|", $qstArray);
							$ansReg=$ansRegAr[1];

							?>
			
							<p style="padding: 30px 0 0 18px;font-size: 1.3em;font-weight: 400;color: #999;text-align: left;">Question <?=$k?></p>
							<div class="signup_field_ext">
								<div class="data" style="margin: 0 30px 0 0;padding: 10px;color: #009;background-color: #edf3fe;border-radius: 5px;">
									<div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($questionX)?></div>
									<?php if ($attachX) {?><p style="padding: 10px 0 10px 0;">Attachment: <a href="<?=$pictX?>" target="_blank" style="font-size: 1.0em;color: #900;"><?=$fileNameX?></a></p><?php }?>
								</div>
							</div>
							<?php 
							$h=1;
							foreach ($answersArX as $answerX) {
								$AnswerSplitX=explode("||§§",$answerX);
								$ansNbX=$AnswerSplitX[0];
								$ansValueX=$AnswerSplitX[1];

								$ansChoose=0;
								$bgColor="transparent";
								if ($ansReg==$ansNbX) {
									if ($ansNbX==1) {
										$bgColor="#d6f5da";
										$ansTr="CORRECT";
										$ansPict="./impianto/img/qstExact.png";
									} else {
										$bgColor="#fcbaba";
										$ansTr="WRONG";
										$ansPict="./impianto/img/qstWrong.png";
									}
									?>
										<div class="signup_field_ext" style="margin-left: 20px;">
											<p style="font-size: 1.0em;font-weight: 400;color: #999;">The answer is <?=$ansTr?>:</p>
											<div class="data" style="margin: 5px 30px 0 0px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;background-color: <?=$bgColor?>;border-radius: 5px;border-width: 0 0 1px 1px;">
												<img src="<?=$ansPict?>" alt="" width="50" height="50" style="float: left;margin: 0 10px 0 0;" /><div style="font-size: 1.1em;line-height: 1.3em;"><?=nl2br($ansValueX)?></div><div class="clear"></div>
											</div>
										</div>
									<?php 
								}
								?>
								<?php 
								$h+=1;
							}

							if ($ansReg=="0") {
								?>
									<div class="signup_field_ext" style="margin-left: 20px;">
										<p style="font-size: 1.0em;font-weight: 400;color: #999;">The answer is WRONG:</p>
										<div class="data" style="margin: 5px 30px 0 0px;padding: 10px;color: #444;border: solid 1px #ccc;border-width: 0 0 1px 1px;background-color: #fcbaba;border-radius: 5px;border-width: 0 0 1px 1px;">
											<img src="./impianto/img/qstWrong.png" alt="" width="50" height="50" style="float: left;margin: 0 10px 0 0;" /><div style="font-size: 1.1em;line-height: 1.3em;">I DON'T KNOW</div><div class="clear"></div>
										</div>
									</div>
								<?php 
							}
							?>




							<?php 
						}
						$k+=1;
					}
					?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>