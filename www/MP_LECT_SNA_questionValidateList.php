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

$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];

$srcLevel=$_POST["srcLevel"];
if (!$srcLevel) $srcLevel=$_GET["srcLevel"];
$srcTopic=$_POST["srcTopic"];
if (!$srcTopic) $srcTopic=$_GET["srcTopic"];
$srcSubTopic=$_POST["srcSubTopic"];
if (!$srcSubTopic) $srcSubTopic=$_GET["srcSubTopic"];
//$srcValidation=$_POST["srcValidation"];
//if (!$srcValidation) $srcValidation=$_GET["srcValidation"];

/* Impongo di visualizzare soltanto quelle da valutare */
$srcValidation=4;

$queryStr="page={$page}&srcLevel={$srcLevel}&srcTopic={$srcTopic}&srcSubTopic={$srcSubTopic}&srcValidation={$srcValidation}";

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

					<p class="rsvPage_Title">Validate Questions</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php 
					$tpoSTR="";
					$sqlL1 = "
						SELECT * 
						FROM  platform__lecturers 
						WHERE (id_lect='$usrId') 
						LIMIT 1";
					$resultL1=mysqli_query($conn,$sqlL1);
																
					while ($rowL1=mysqli_fetch_array($resultL1)) { 
						$tpoSTR=$rowL1["topic_permission"];
					}

					$where=" WHERE (p.validate=4 AND ";
					if ($srcLevel) $where.="p.level='$srcLevel' AND ";

//					// Filtro per topic/subtopic
//					if ($srcTopic OR $srcSubTopic) {
//						if ($srcTopic) $where.="p.topic=$srcTopic AND ";
//						if ($srcSubTopic) $where.="p.subtopic=$srcSubTopic AND ";
//					} else {
//						if ($tpoSTR) {
//
//							$where.="(";
//							$tpoSTR1=substr($tpoSTR,4);
//							$tpoSTR_Ar=explode("_",$tpoSTR1);
//
//							foreach( $tpoSTR_Ar as $valore) {  
//								$strTopID="";
//								$tpo=substr($valore,0,3);
//								if ($tpo=="top") {
//									$strTopID=substr($valore,3);
//									if ($strTopID) $where.="(p.topic=$strTopID AND p.subtopic=0) OR ";
//								}
//								if ($tpo=="sub") {
//									$strSubtop=substr($valore,3);
//									$strSubtop_ar=explode("|",$strSubtop);
//
//									if ($strSubtop) $where.="(p.topic=$strSubtop_ar[0] AND p.subtopic=$strSubtop_ar[1]) OR ";
//								}
//							}
//							$where=substr($where,0,-4);
//							$where.=") AND ";
//
//						}
//					}
//					$where=substr($where,0,-5);
//					$where.=")";





					$where=" WHERE (p.validate=4 AND ";
					if ($srcLevel) $where.="p.level='$srcLevel' AND ";

					// Filtro per topic/subtopic
					if ($srcTopic AND $srcSubTopic) {
						
						if ($srcTopic) $where.="p.topic=$srcTopic AND ";
						if ($srcSubTopic) $where.="p.subtopic=$srcSubTopic AND ";
					
					} else {
						
						if ($tpoSTR) {
							if ($srcTopic) {
								$where.="p.topic=$srcTopic AND ";
								
								$where.="(";
								$tpoSTR1=substr($tpoSTR,4);
								$tpoSTR_Ar=explode("_",$tpoSTR1);

								foreach( $tpoSTR_Ar as $valore) {  
									$strTopID="";
									$tpo=substr($valore,0,3);
									if ($tpo=="sub") {
										$strSubtop=substr($valore,3);
										$strSubtop_ar=explode("|",$strSubtop);

										if ($strSubtop_ar[0]==$srcTopic) $where.="p.subtopic=$strSubtop_ar[1] OR ";
									}
								}
								$where=substr($where,0,-4);
								$where.=") AND ";
							
							} else {

								$where.="(";
								$tpoSTR1=substr($tpoSTR,4);
								$tpoSTR_Ar=explode("_",$tpoSTR1);

								foreach( $tpoSTR_Ar as $valore) {  
									$strTopID="";
									$tpo=substr($valore,0,3);
									if ($tpo=="top") {
										$strTopID=substr($valore,3);
										if ($strTopID) $where.="(p.topic=$strTopID AND p.subtopic=0) OR ";
									}
									if ($tpo=="sub") {
										$strSubtop=substr($valore,3);
										$strSubtop_ar=explode("|",$strSubtop);

										if ($strSubtop) $where.="(p.topic=$strSubtop_ar[0] AND p.subtopic=$strSubtop_ar[1]) OR ";
									}
								}
								$where=substr($where,0,-4);
								$where.=") AND ";
							}
						}
					}
					$where=substr($where,0,-5);
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

					$q_pag=10; //quanti per pagina
					$pagine1=bcdiv($totale,$q_pag,3);
					$pagine = ceil($pagine1); //arrotonda all'intero maggiore
					$page_from=($page-1)*$q_pag;

					$sqlP = $sqlP." LIMIT ".$page_from.",".$q_pag.";";
					$resultP=mysqli_query($conn,$sqlP);
					?>
	
					<div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> questions</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>
					<form method="post" action="./MP_LECT_SNA_questionValidateList.php" style="padding: 10px;font-size: 0.9em;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
						<p style="float: left;width: 70px;font-size: 0.9em;">Search By:</p>
						<div style="float: left;width: 120px;">
							Level:<br />
							<select name="srcLevel">
								<option value="">All Level</option>
								<option value="Basic" <?php if ($srcLevel=="Basic") echo "selected";?>>Basic</option>
								<option value="Advanced" <?php if ($srcLevel=="Advanced") echo "selected";?>>Advanced</option>
							</select>
						</div>
						<div style="float: left;width: 240px;">
							Topic:<br />
							<select name="srcTopic" onchange="subTopic3(this.options[this.selectedIndex].value,'<?=$tpoSTR?>');">
								<option value="">All Topic</option>
								<?php 
								$sql = "
									SELECT * 
									FROM platform__topic
									WHERE hidden=0 
									ORDER BY name ASC";
								$result=mysqli_query($conn,$sql);
								
								while ($row=mysqli_fetch_array($result)) { 
									$topId=$row["id"];
									$topName=$row["name"];

									if ($tpoSTR) {
										$checkedRs="";
										$checkSTR="_top".$topId."_";
										$checkSTR1="_sub".$topId."|";
										$find=strpos($tpoSTR, $checkSTR);
										$find1=strpos($tpoSTR, $checkSTR1);
										if ($find OR $find1) {
											?><option value="<?=$topId?>" <?php if ($srcTopic==$topId) echo "selected";?>><?=$topName?></option><?php 
										}
									} else {
										?><option value="<?=$topId?>" <?php if ($srcTopic==$topId) echo "selected";?>><?=$topName?></option><?php 
									}
								}
									
								$sql = "
									SELECT * 
									FROM platform__subtopic 
									WHERE (id_top=$srcTopic AND hidden=0) 
									ORDER BY name ASC";
								$result=mysqli_query($conn,$sql);
								$nSubTopic=mysqli_num_rows($result);
								?>
							</select>
							<?php if ($srcSubTopic OR $nSubTopic) $dsplSubTopic="block"; else $dsplSubTopic="none"; ?>
							<div id="subtopic" style="display: <?=$dsplSubTopic?>;float: left;margin: 10px 0 0 0;">
								<!-- SubTopic Area -->
								SubTopic:<br />
								<select name="srcSubTopic" style="width: 250px;">
									<option value="">All SubTopics</option>
									<?php 
									$sql = "
										SELECT * 
										FROM platform__subtopic 
										WHERE (id_top=$srcTopic AND hidden=0) 
										ORDER BY name ASC";
									$result=mysqli_query($conn,$sql);
									
									while ($row=mysqli_fetch_array($result)) { 
										$subtopicId=($row["id"]);
										$subtopicName=($row["name"]);

										if ($tpoSTR) {
											$checkedRs1="";
											$checkSTR1="_sub".$srcTopic."|".$subtopicId."_";
											$find2=strpos($tpoSTR, $checkSTR1);
											if ($find2) {
												?><option value="<?=$subtopicId?>" <?php if ($srcSubTopic==$subtopicId) echo "selected";?>><?=$subtopicName?></option><?php 
											}
										} else {
											?><option value="<?=$subtopicId?>" <?php if ($srcSubTopic==$subtopicId) echo "selected";?>><?=$subtopicName?></option><?php 
										}
									}
									?>
								</select>
							</div>
						</div>
						<!-- <div style="float: left;width: 190px;">
							Validation:<br />
							<select name="srcValidation">
								<option value="">All Validation</option>
								<option value="3" <?php if ($srcValidation==3) echo "selected";?>>WAITING FOR VALIDATION</option>
								<option value="1" <?php if ($srcValidation==1) echo "selected";?>>VALIDATED</option>
								<option value="2" <?php if ($srcValidation==2) echo "selected";?>>NOT VALIDATED</option>
							</select>
						</div> -->
						
						<a href="./MP_LECT_SNA_questionValidateList.php"><button type="button" class="abort" style="margin-left: 190px;" />All</button></a>
						<input type="submit" value="filter" class="filter" />
						
						<div class="clear"></div>

					</form>


					<?php if ($totale>0) {?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="tdtit"></th>
									<th class="tdtit" style="width: 100%;">Question</th>
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
								$lnk3="./MP_LECT_SNA_questionValidateResponse.php?id_act=".$qstId."&".$queryStr;

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
										<!-- <p style="font-size: 0.8em;"><?=$date?></p> -->
										<p style="padding-top: 5px">Code:<br /><strong>SNA<?=$qstId?></strong></p>
										<p style="padding-top: 5px">Level:<br /><strong><?=$level?></strong></p>
										<!-- <p style="padding-top: 5px">Topic:<br /><strong><?=$topic?></strong></p>
										<?php if ($subTopic) {?><p style="padding-top: 5px">SubTopic:<br /><strong><?=$subTopic?></strong></p><?php }?> -->
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
										<div style="width: 90px;margin: 0 0 15px 5px;">
											<!-- <?php if ($validate==1) {?>
												<div style="width: 90px;padding: 10px 5px;color: #090;text-align: center;border: solid 1px #090;">
													<p style="font-weight: 600;">VALIDATED</p>
													<p style="font-size: 0.8em;font-weight: 200;"><?=$validate_date?></p>
													<?php if ($valName) {?><p style="font-size: 0.8em;font-weight: 200;">by <?=$valName?></p><?php }?>
												</div>
											<?php } elseif ($validate==2) {?>
												<div style="width: 90px;padding: 10px 5px;color: #900;text-align: center;border: solid 1px #900;">
													<p style="font-weight: 600;">NOT VALIDATED</p>
													<p style="font-size: 0.8em;font-weight: 200;"><?=$validate_date?></p>
													<?php if ($valName) {?><p style="font-size: 0.8em;font-weight: 200;">by <?=$valName?></p><?php }?>
												</div>
											<?php } else {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #ffcc00;text-align: center;border: solid 1px #ffcc00;">
													<p>WAITING FOR VALIDATION</p>
												</div>
											<?php }?> -->
											<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #259425;text-align: center;border: solid 1px #259425;">
												<?php if ($validate==4) {?><a href="<?=$lnk3?>" style="color: #259425;">EXAMINE QUESTION</a><?php }?>
											</div>
										</div>
										<!-- <a href="javascript: void()" onclick="showhidd('<?=$qstId?>_ansBlk');">show answers</a><br /> -->
									</td>
								</tr>
								<?php 
								$count+=1;
							}
							?>
							</tbody>
						</table>					


						<?php if ($pagine>1) include('./impianto/paginazione.php'); //paginazione?>
					
					<?php } else {?>	
						<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">No question to examine</p>
					<?php }?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>