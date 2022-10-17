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

$srcValidation=$_POST["srcValidation"];
if (!$srcValidation) $srcValidation=$_GET["srcValidation"];

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

					<p class="rsvPage_Title">Manage Your Video Reviews</p>
					<p class="rsvPage_Title1">Student Need Assessment</p>

					<?php 
					$where=" WHERE (p.id_lect=$usrId AND ";
					if ($srcValidation) {
						if ($srcValidation==3) $where.="p.validate=0 AND ";
						else $where.="p.validate=$srcValidation AND ";
					}
					$where=substr($where,0,-5);
					$where.=")";

					$sqlP = "
						SELECT *, p.id AS vidId  
						FROM platform__SNA__VID_reviews AS p 
						$where 
						ORDER BY p.date DESC";
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
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> video reviews</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SNA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>
	
					<form method="post" action="./MP_LECT_SNA_videoRevManage.php" style="padding: 10px;font-size: 0.9em;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
						<p style="float: left;width: 60px;font-size: 0.9em;">Search By:</p>
						<div style="float: left;width: 190px;">
							Validation:<br />
							<select name="srcValidation">
								<option value="">All Status</option>
								<option value="3" <?php if ($srcValidation==3) echo "selected";?>>IN PROGRESS</option>
								<option value="4" <?php if ($srcValidation==4) echo "selected";?>>WAITING FOR VALIDATION</option>
								<option value="1" <?php if ($srcValidation==1) echo "selected";?>>VALIDATED</option>
								<option value="2" <?php if ($srcValidation==2) echo "selected";?>>NOT VALIDATED</option>
							</select>
						</div>
						<div style="float: right;width: 100px;margin-right: 10px;">
							<a href="./MP_LECT_SNA_videoRevManage.php"><button type="button" class="abort" />All</button></a>
							<input type="submit" value="filter" class="filter" />
						</div>
						<div class="clear"></div>

					</form>


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

								//$pict_id=$row["id"];
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
									if (file_exists("./data/mathePlatform/SNA/vdReviews/".$vidId.".jpg")) $icon="./data/mathePlatform/SNA/vdReviews/$vidId.jpg";
									$videoPreview="<div style=\"display: block;width: 200px;height: 113px;background: url(".$icon.") #fff no-repeat 0 0;background-size: 200px auto;\"></div>";
								}



								$lnk1="./MP_LECT_SNA_videoRevEdit.php?id_act=".$vidId."&".$queryStr;
								$lnk3="./MP_LECT_SNA_videoRevDelete.php?id_act=".$vidId."&".$queryStr;

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
											<?php if ($validate==1) {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #090;text-align: center;border: solid 1px #090;">
													<p style="">VALIDATED</p>
													<p style="font-size: 0.8em;font-weight: 400;"><?=$validate_date?></p>
													<!-- <p>by <?=$validate_by?></p> -->
												</div>
											<?php } elseif ($validate==2) {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #900;text-align: center;border: solid 1px #900;">
													<p>NOT VALIDATED</p>
													<p style="font-size: 0.8em;font-weight: 400;"><?=$validate_date?></p>
													<!-- <p>by <?=$validate_by?></p> -->
												</div>
											<?php } elseif ($validate==4) {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #ffcc00;text-align: center;border: solid 1px #ffcc00;">
													<p>WAITING FOR VALIDATION</p>
												</div>
											<?php } else {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 400;color: #999;text-align: center;border: solid 1px #999;">
													<p>IN PROGRESS</p>
												</div>
											<?php }?>
										</div>
										<?php if ($validate==0 OR $validate==2) {?><a href="<?=$lnk3?>">delete</a> / <a href="<?=$lnk1?>">edit</a><br /><?php }?>
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
						<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">No one video reviews</p>
					<?php }?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>