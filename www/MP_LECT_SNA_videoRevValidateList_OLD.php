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

$srcTopic=$_POST["srcTopic"];
if (!$srcTopic) $srcTopic=$_GET["srcTopic"];
$srcSubTopic=$_POST["srcSubTopic"];
if (!$srcSubTopic) $srcSubTopic=$_GET["srcSubTopic"];

/* Impongo di visualizzare soltanto quelle da valutare */
$srcValidation=4;

$queryStr="page={$page}&srcValidation={$srcValidation}&from=valedit";

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

					<p class="rsvPage_Title">Validate Video Reviews</p>
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

					// Filtro per topic/subtopic
					if ($srcTopic OR $srcSubTopic) {
						if ($srcTopic) $where.="p.topic=$srcTopic AND ";
						if ($srcSubTopic) $where.="p.subtopic=$srcSubTopic AND ";
					} else {
						//if ($tpoSTR AND $usrId==26) {
						if ($tpoSTR) {

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
					$where=substr($where,0,-5);
					$where.=")";


					$sqlP = "
						SELECT *, p.id AS vidId  
						FROM platform__SNA__VID_reviews AS p 
						WHERE p.validate=4 
						#$where 
						ORDER BY p.date ASC";
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
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> Video Reviews</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>








					<?php if ($usrId==26) {?>
					<form method="post" action="./MP_LECT_SNA_videoRevValidateList.php" style="padding: 10px;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
						<p style="float: left;width: 70px;">Search By:</p>
						<div style="float: left;width: 360px;">
							Topic:<br />
							<select name="srcTopic" onchange="subTopic31(this.options[this.selectedIndex].value,'<?=$tpoSTR?>');">
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
						
						<a href="./MP_LECT_SNA_questionValidateList.php"><button type="button" class="abort" style="margin-left: 190px;" />All</button></a>
						<input type="submit" value="filter" class="filter" />
						
						<div class="clear"></div>

					</form>
					<?php }?>














					<?php if ($totale>0) {?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="tdtit"></th>
									<th class="tdtit"></th>
									<th class="tdtit" style="width: 100%;">Video</th>
									<th class="tdtit"></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$count=1;
							while ($row=mysqli_fetch_array($resultP)) { 

								$vidId=$row["vidId"];
								$videoTitle=$row["title"];
								$videoAuthor=$row["author"];
								$videoDescription=$row["description"];
								$videoLink=$row["link"];
								$videoLang=$row["languages"];
								$fileExt=$row["file_ext"];
								$date=$row["date"];
								$validate=$row["validate"];
								$validate_date=$row["validate_date"];
								$validate_by=$row["validate_by"];
								$chk_topic=$row["topic"];
								$chk_subtopic=$row["subtopic"];
								$chk_keywords=$row["keywords"];
								$chk_questions=$row["questions"];

								$alarm=0;
								if ((!$chk_topic OR $chk_topic=="key_") AND (!$chk_subtopic OR $chk_subtopic=="key_")) $alarm=1;
								if (!$chk_keywords OR $chk_keywords=="key_") $alarm=1;
								if (!$chk_questions OR $chk_questions=="key_") $alarm=1;

								$puntini="";
								if (strlen($videoDescription)>250) $puntini="...";
								$videoDescription=substr($videoDescription,0,250).$puntini;

								$videoPreview="";
								if (strpos($videoLink, "/")===False AND strlen($videoLink)==11) {
									// E' stato inserito il codice di 11 caratteri di YouTube
									$youtubeCode=$videoLink;
									$videoPreview="<iframe width='200' height='113' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
								} elseif (strpos($videoLink, "youtu.be")>0) {
									// E' stato inserito il link per la condivisione di Youtube
									$youtubeCode=substr($videoLink,-11);
									$videoPreview="<iframe width='200' height='113' src='https://www.youtube.com/embed/".$youtubeCode."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
								} else {
									$icon="./impianto/img/notAvailable.jpg";
									if (file_exists("./data/mathePlatform/SNA/vdReviews/".$vidId.".".$fileExt)) $icon="./data/mathePlatform/SNA/vdReviews/$vidId.$fileExt";
									$videoPreview="<div style=\"display: block;width: 200px;height: 113px;background: url(".$icon.") #fff no-repeat 0 0;background-size: 200px auto;\"></div>";
								}

								$lnk1="./MP_LECT_SNA_videoRevValidateEdit.php?id_act=".$vidId."&".$queryStr;
								$lnk3="./MP_LECT_SNA_videoRevValidateResponse.php?id_act=".$vidId."&".$queryStr;

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

								?>
								<tr>
									<td style="font-size: 0.9em;">
										<!-- <p style="font-size: 0.8em;"><?=$date?></p> -->
										<p style="padding-top: 5px">Code:<br /><strong>VRE<?=$vidId?></strong></p>
										<?php if ($alarm==1) {?><p style="margin: 15px 0 0 10px;width: 5px;height: 5px;background-color: #900;border-radius: 10px;">&nbsp;</p><?php }?>
									</td>
									<td style="font-size: 0.9em;">
										<p style="padding-top: 5px"><?=$videoPreview?></p>
									</td>
									<td style="font-size: 0.9em;line-height: 1.0em;">
										<div style="font-size: 1.1em;font-weight: 500;line-height: 1.3em;"><?=nl2br($videoTitle)?></div>
										<div style="padding-top: 2px;font-size: 0.9em;line-height: 1.3em;"><em><?=$videoAuthor?></em></div>
										<div style="padding-top: 5px;font-size: 0.8em;line-height: 1.3em;"><?=$videoDescription?></div>
									</td>
									<td style="text-align: right;">
										<div style="width: 90px;margin: 0 0 15px 5px;">
											<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #259425;text-align: center;border: solid 1px #259425;">
												<?php if ($validate==4) {?><a href="<?=$lnk3?>" style="color: #259425;">EXAMINE VIDEO REVIEW</a><?php }?>
											</div>
										</div>
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
						<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">No video reviews to examine</p>
					<?php }?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>