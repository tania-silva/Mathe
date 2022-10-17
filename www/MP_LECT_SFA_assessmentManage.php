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
$srcValidation=$_POST["srcValidation"];
if (!$srcValidation) $srcValidation=$_GET["srcValidation"];

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

					<p class="rsvPage_Title">Manage Your Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					
					<?php 
//					$where=" WHERE (p.id_lect=$usrId AND ";
//					if ($srcLevel) $where.="p.level='$srcLevel' AND ";
//					if ($srcTopic) $where.="p.topic=$srcTopic AND ";
//					if ($srcValidation) {
//						if ($srcValidation==3) $where.="p.validate=0 AND ";
//						else $where.="p.validate=$srcValidation AND ";
//					}
//					$where=substr($where,0,-5);
//					$where.=")";

					$sqlP = "
						SELECT * 
						FROM platform__SFA__assestment
						WHERE (id_lect=$usrId) 
						ORDER BY FA_date DESC";
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
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> assessment</p>
						<!-- <p style="float: right;width: 300px;padding: 0 0 0 0;text-align: right;"><a href="./MP_LECT_SFA_questionAdd.php" class="bt_css1">Insert new Question</a></p> -->
						<div class="clear"></div>
					</div>

					<?php if ($totale>0) {?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="tdtit"></th>
									<th class="tdtit" style="width: 100%;">Final Assessment</th>
									<th class="tdtit" style="padding-right: 15px;text-align: right;">Subscriptions</th>
									<th class="tdtit"></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$count=1;
							while ($row=mysqli_fetch_array($resultP)) { 

								$assId=$row["id"];
								$assTitle=$row["title"];
								$assDescription=$row["description"];
								$assDate=$row["FA_date"];
								$assDuration=$row["duration"];
								$assStatus=$row["status"];

								if (strlen($assDescription)>150) $assDescription=substr($assDescription,0,150)."...";
		
								if ($assStatus) $statusTr="<span style=\"font-size: 1.0em;font-weight: 600;color: #070;\">PUBLISHED</span>";
								else $statusTr="<span style=\"font-size: 1.0em;font-weight: 600;color: #c00;\">NOT PUBLISHED</span>";

								$assDate=Date("Y-m-d H:i:s",strtotime($assDate));
								$date = date_create($assDate, timezone_open('UTC'));
								$Dt1=$date->format('Y-m-d H:i:s');
								date_timezone_set($date, timezone_open($uniTimezone));
								$assDate=$date->format('Y-m-d H:i:s');
								$dateCrf=Date("Y-m-d",strtotime($assDate));

								date_default_timezone_set('UTC');
								$todayUTC=Date("Y-m-d",time());
								date_default_timezone_set($uniTimezone);

								if ($dateCrf>$todayUTC) $status="valid";
								elseif ($dateCrf==$todayUTC) $status="inprogress";
								else $status="expired";

								if ($assDate!="" AND $assDate!="0000-00-00 00:00:00") {
									$ins_data_expl=explode("-",$assDate);
									$ins_data_aa=$ins_data_expl[0];
									$ins_data_mm=$ins_data_expl[1];
									$ins_data_expl1=explode(" ",$ins_data_expl[2]);
									$ins_data_gg=$ins_data_expl1[0];
									$ins_data_expl2=explode(":",$ins_data_expl1[1]);
									$ins_data_ora=$ins_data_expl2[0];
									$ins_data_min=$ins_data_expl2[1];
									$assDate=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa." ".$ins_data_ora.":".$ins_data_min;
								} else $assDate="";

								$lnk1="MP_LECT_SFA_assessmentNew1.php?assId=".$assId;
								$lnk2="MP_LECT_SFA_assessmentDelete.php?assId=".$assId;
								$lnk3="MP_LECT_SFA_assessmentSubscriptions.php?assId=".$assId;
								$lnk4="MP_LECT_SFA_assessmentResult.php?assId=".$assId;
								$lnk5="MP_LECT_SFA_assessmentPrint.php?assId=".$assId;

								$assProtected=0;
								$sql8 = "
									SELECT * 
									FROM platform__SFA__assanswer 
									WHERE (id_ass=$assId AND protected=1)
									LIMIT 1";
								$result8=mysqli_query($conn,$sql8);
								$assProtected=mysqli_num_rows($result8);

								?>
								<tr>
									<td style="font-size: 0.9em;">
										<div style="width: 90px;">
											<?php if ($status=="valid") {?>
												<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #090;text-align: center;border: solid 1px #090;">
													<p style=""><?=$statusTr?></p>
													<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
												</div>
											<?php } elseif ($status=="inprogress") {?>
												<?php if ($assStatus==1) {?>
													<div style="width: 90px;padding: 10px 5px;font-weight: 400;color: #999;text-align: center;border: solid 1px #999;">
														<p>IN PROGRESS</p>
														<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
													</div>
												<?php } else {?>
													<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #999;text-align: center;border: solid 1px #999;">
														<p style=""><?=$statusTr?></p>
														<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
													</div>
												<?php }?>
											<?php } else {?>
												<?php if ($assStatus==1) {?>
													<?php if ($assProtected) {?>
														<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #aaa;text-align: center;border: solid 1px #aaa;">
															<p>DONE</p>
															<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
														</div>
													<?php } else {?>
														<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #900;text-align: center;border: solid 1px #900;">
															<p>EXPIRED</p>
															<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
														</div>
													<?php }?>
												<?php } else {?>
													<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #900;text-align: center;border: solid 1px #900;">
														<p style=""><?=$statusTr?></p>
														<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
													</div>
												<?php }?>
											<?php }?>
										</div>
										<!-- <p>Code:<br /><strong>ASS<?=$assId?></strong></p><br /> -->
										<!-- <p style="padding-top: 10px"><?=$statusTr?></p> -->
									</td>
									<td style="font-size: 0.9em;line-height: 1.0em;">
										<!-- <?php if ($assDate) {?><p style="padding: 0 0 10px 0;font-size: 0.9em;color: #999;"><?=$assDate?> (<?=$assDuration?> minutes)</p><?php }?> -->
										<p style="padding: 10px 0 10px 0;font-size: 1.3em;"><?=$assTitle?></p>
										<div style="font-size: 1.0em;line-height: 1.3em;"><?=nl2br($assDescription)?></div>
									</td>
									<td style="padding-right: 15px;text-align: right;">
										<!-- STUDENT COL -->
										<?php 
										$waiting=0;
										$approved=0;
										$rejected=0;
										
										$sql = "
											SELECT *, 
												SUM(if(status = '0', 1, 0)) AS waiting,  
												SUM(if(status = '1', 1, 0)) AS approved, 
												SUM(if(status = '2', 1, 0)) AS rejected 
											FROM platform__SFA__subscription 
											WHERE (id_ass='$assId')";
										$result=mysqli_query($conn,$sql);
										$assRqstNb=mysqli_num_rows($result);

										while ($row=mysqli_fetch_array($result)) { 
											$waiting=$row["waiting"];
											$approved=$row["approved"];
											$rejected=$row["rejected"];
										}
										if (!$waiting) $waiting=0;
										if (!$approved) $approved=0;
										if (!$rejected) $rejected=0;
										?>
										<?php if ($waiting) {?><p style="color: #c00;">Waiting: <?=$waiting?></p><?php }?>
										<?php if ($approved) {?><p style="color: #090;">Accepted: <?=$approved?></p><?php }?>
										<?php if ($rejected) {?><p style="color: #aaa;">Rejected: <?=$rejected?></p><?php }?>
									</td>
									<td style="text-align: right;">
										<strong>EX<?=$assId?></strong><br /><br />
										<?php 
										if ($assStatus!=1) {
											// NON pubblicati
											?><a href="<?=$lnk1?>">edit</a><br /><a href="<?=$lnk2?>">delete</a><br /><?php 
										} else {
											// pubblicati
											if ($status=="valid") {
												?><a href="<?=$lnk1?>">edit</a><br /><a href="<?=$lnk3?>">participants</a><br /><?php 
											} elseif ($status=="inprogress") {
												if ($assProtected) {
													?><!-- <a href="<?=$lnk1?>">edit</a><br /> --><a href="<?=$lnk3?>">participants</a><br /><a href="<?=$lnk4?>">result</a><br /><?php 
												} else {
													?><!-- <a href="<?=$lnk1?>">edit</a><br /> --><a href="<?=$lnk3?>">participants</a><br /><?php 
												}
											} else { // expired
												if ($assProtected) {
													?><a href="<?=$lnk5?>" target="_blank">print</a><br /><a href="<?=$lnk4?>">result</a><br /><?php 
												} else {
													?><!-- <a href="<?=$lnk1?>">edit</a><br /> --><a href="<?=$lnk2?>">delete</a><br /><?php 
												}
											}
										}
										?>
									</td>
								</tr>
								<?php 
								$count+=1;
							}
							?>
							</tbody>
						</table>					

						<!-- <?php if ($pagine>1) {?>
							<div class="pageNav">
								<?php 
								for ($i=1;$i<=$pagine;$i++) {
									$str_query="&srcLevel=".$srcLevel."&srcTopic=".$srcTopic."&srcValidation=".$srcValidation;
									$str_pas=basename($_SERVER['PHP_SELF'])."?page=".$i.$str_query;
									if ($i==$page) {
										echo "<a class='sel' href='./".$str_pas."'>".$i."</a>";
									} else {
										echo "<a href='./".$str_pas."'>".$i."</a>";
									}
								}
								?>
								<div class="clear"></div>
							</div>
						<?php }?> -->
						<?php if ($pagine>1) include('./impianto/paginazione.php'); //paginazione?>
					
					<?php } else {?>	
						<p style="padding: 25px 0 0 0;font-size: 1.5em;font-weight: 400;color: #090;text-align: center;">No assessment to examine</p>
					<?php }?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>