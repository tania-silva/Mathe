<?php include('top.php'); ?>
<?php include('./impianto/inc/protectedGuest.php'); //Se non loggato esci...?>
<link rel="stylesheet" href="./impianto/css/mathePlatform.css">
<div class="container" id="sottomenu">
	<div id="cnt1" class="row">

		<div id="rsv_menu" class="col-md-2">
			<?php //include('./impianto/rsv_menu.php'); //Menu?>
			<?php  include('./impianto/spallaSx_STUD.php'); // funzioni PHP ?>
		</div>
		<div id="rsv_crp" class="col-md-10">
			<hr />					
			<!-- INCOLLA START -->





<?php 

$page=1;
if (isset($_GET["page"])) $page=$_GET["page"];

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

					<p class="rsvPage_Title">List of Final Assessments</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

					
					<?php 

					$sql = "
						SELECT *, 
							k.id AS uniId, 
							k.name AS uniName 
						FROM platform__user as p 
						LEFT JOIN platform__students as q 
							ON p.id=q.id_stud 
						LEFT JOIN platform__lecturers as b 
							ON p.id=b.id_lect 
						LEFT JOIN platform__university as k 
							ON (q.uni_name=k.id OR b.uni_name=k.id) 
						WHERE p.id='$usrId' 
						LIMIT 1";
					$result=mysqli_query($conn,$sql);

					while ($row=mysqli_fetch_array($result)) { 
						$uniId=$row["uniId"];
						$uniName=$row["uniName"];
					}
						
						
					$sqlP = "
						SELECT *, 
							p.id AS assId, 
							k.name AS lectName, 
							k.surname AS lectSurname,
							p.status AS assPublished, 
							g.status AS assSubscription
						FROM platform__SFA__assestment as p 
						LEFT JOIN platform__lecturers as q 
							ON p.id_lect=q.id_lect
						LEFT JOIN platform__user as k 
							ON k.id=q.id_lect
						LEFT JOIN platform__SFA__subscription as g 
							ON (g.id_ass=p.id AND id_stud=$usrId) 
						WHERE (
							q.uni_name=$uniId AND 
							p.status=1 AND 
							(g.status=1 OR g.status=2 OR g.status=0) 
						) ORDER BY FA_date DESC";
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
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> assessment/s</p>
						<div class="clear"></div>
					</div>

					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit" style="width: 100%;">Final Assessment</th>
								<th class="tdtit" style="padding-right: 15px;text-align: right;">Subscriptions</th>
								<th class="tdtit" style="padding-right: 15px;text-align: right;">Result</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$count=1;
						while ($row=mysqli_fetch_array($resultP)) { 

							$assId=$row["assId"];
							$assTitle=$row["title"];
							$assDescription=$row["description"];
							$assDate=$row["FA_date"];
							$assDuration=$row["duration"];
							$assPublished=$row["assPublished"];
							$assSubscription=$row["assSubscription"];
							$lectName=$row["lectName"];
							$lectSurname=$row["lectSurname"];
							
							if (strlen($assDescription)>150) $assDescription=substr($assDescription,0,150)."...";
	
							$statusTr="<span style=\"font-size: 1.0em;font-weight: 600;color: #070;\">COOMING SOON</span>";

							if ($assSubscription==1) $assSubscriptionTr="<span style=\"color: #090;font-weight: 400;\">Accepted</span>";
							elseif ($assSubscription==2) $assSubscriptionTr="<span style=\"color: #999;font-weight: 400;\">Not Accepted</span>";
							else $assSubscriptionTr="<span style=\"color: #900;font-weight: 400;\">Waiting Response</span>";

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

							$lnk1="./MP_STUD_SFA_assessmentResult.php?assId=".$assId;

							/* Calcolo risultato */

							if ($status=="expired") {
								$sql8 = "
									SELECT * 
									FROM platform__SFA__assanswer 
									WHERE id_stud=$usrId AND id_ass=$assId
									LIMIT 1";
								$result8=mysqli_query($conn,$sql8);

								while ($row8=mysqli_fetch_array($result8)) { 
									$totpoint=$row8["totpoint"];
									$assProtected=$row8["protected"];
								}
							}

							if ($assProtected) $assSubscriptionTr="";

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
											<div style="width: 90px;padding: 10px 5px;font-weight: 400;color: #999;text-align: center;border: solid 1px #999;">
												<p>IN PROGRESS</p>
												<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
											</div>
										<?php } else {?>
											<div style="width: 90px;padding: 10px 5px;font-weight: 600;color: #999;text-align: center;border: solid 1px #999;">
												<p>DONE</p>
												<p style="font-size: 0.8em;font-weight: 400;"><?=$assDate?><br />(<?=$assDuration?> minutes)</p>
											</div>
										<?php }?>
									</div>
								</td>
								<td style="font-size: 0.9em;line-height: 1.0em;">
									<div style="font-size: 1.0em;">Lecturer: <?=$lectName?> <?=$lectSurname?></div>
									<p style="padding: 10px 0 10px 0;font-size: 1.3em;"><?=$assTitle?></p>
									<div style="font-size: 1.0em;"><?=nl2br($assDescription)?></div>
								</td>
								<td style="padding-right: 15px;text-align: right;">
									<p style="padding-top: 5px;"><?=$assSubscriptionTr?></p>
								</td>
								<td style="padding-right: 10px;text-align: right;">
									<?php 
									if ($status=="expired") {
										?>
										<p style="padding-top: 5px;font-size: 1.5em;font-weight: 600;"><?=$totpoint?></p>
										<p style="padding: 5px 0 0 0;"><a href="<?=$lnk1?>">details</a></p>
										<?php 
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

					<?php if ($pagine>1) {?>
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
					<?php }?>

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>