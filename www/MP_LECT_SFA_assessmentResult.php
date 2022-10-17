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
<style>
button.abort {
	float: left;
	width: auto;
	margin: 10px 5px 0 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* rosso */
	border-top: 1px solid #ccc;
	background: #d22d39;
	background: -webkit-gradient(linear, left top, left bottom, from(#fb040b), to(#c20338));
	background: -webkit-linear-gradient(top, #fb040b, #c20338);
	background: -moz-linear-gradient(top, #fb040b, #c20338);
	background: -ms-linear-gradient(top, #fb040b, #c20338);
	background: -o-linear-gradient(top, #fb040b, #c20338);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.rosso {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* rosso */
	border-top: 1px solid #ccc;
	background: #d22d39;
	background: -webkit-gradient(linear, left top, left bottom, from(#fb040b), to(#c20338));
	background: -webkit-linear-gradient(top, #fb040b, #c20338);
	background: -moz-linear-gradient(top, #fb040b, #c20338);
	background: -ms-linear-gradient(top, #fb040b, #c20338);
	background: -o-linear-gradient(top, #fb040b, #c20338);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.verde {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* verde */
	border-top: 1px solid #ccc;
	background: #175c14;
	background: -webkit-gradient(linear, left top, left bottom, from(#5eac28), to(#175c14));
	background: -webkit-linear-gradient(top, #5eac28, #175c14);
	background: -moz-linear-gradient(top, #5eac28, #175c14);
	background: -ms-linear-gradient(top, #5eac28, #175c14);
	background: -o-linear-gradient(top, #5eac28, #175c14);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.blu {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* blu */
	border-top: 1px solid #ccc;
	background: #0c2eb8;
	background: -webkit-gradient(linear, left top, left bottom, from(#2e55f1), to(#0c2eb8));
	background: -webkit-linear-gradient(top, #2e55f1, #0c2eb8);
	background: -moz-linear-gradient(top, #2e55f1, #0c2eb8);
	background: -ms-linear-gradient(top, #2e55f1, #0c2eb8);
	background: -o-linear-gradient(top, #2e55f1, #0c2eb8);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.giallo {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #444;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* giallo */
	border-top: 1px solid #ccc;
	background: #d5d500;
	background: -webkit-gradient(linear, left top, left bottom, from(#ffff66), to(#d5d500));
	background: -webkit-linear-gradient(top, #ffff66, #d5d500);
	background: -moz-linear-gradient(top, #ffff66, #d5d500);
	background: -ms-linear-gradient(top, #ffff66, #d5d500);
	background: -o-linear-gradient(top, #ffff66, #d5d500);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.arancio {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* arancio */
	border-top: 1px solid #ccc;
	background: #d55000;
	background: -webkit-gradient(linear, left top, left bottom, from(#ec5800), to(#d55000));
	background: -webkit-linear-gradient(top, #ec5800, #d55000);
	background: -moz-linear-gradient(top, #ec5800, #d55000);
	background: -ms-linear-gradient(top, #ec5800, #d55000);
	background: -o-linear-gradient(top, #ec5800, #d55000);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

button.grigio {
	width: auto;
	margin: 0;
	padding: 5px 10px;
	font-family: 'Oswald', sans-serif;
	font-size: 0.8em;
	font-weight: 400;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	border: none;
	vertical-align: top;
	cursor: pointer;

	/* grigio */
	border-top: 1px solid #ccc;
	background: #666;
	background: -webkit-gradient(linear, left top, left bottom, from(#ccc), to(#666));
	background: -webkit-linear-gradient(top, #ccc, #666);
	background: -moz-linear-gradient(top, #ccc, #666);
	background: -ms-linear-gradient(top, #ccc, #666);
	background: -o-linear-gradient(top, #ccc, #666);

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
}

</style>

					<p class="rsvPage_Title">Results of Assessment</p>
					<p class="rsvPage_Title1">Student Final Assessment</p>

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
						<p style="margin-top: -20px;text-align: right;">download result <a href="./MP_LECT_SFA_assessmentExport1.php?assId=<?=$assId?>">csv</a> - <a href="./MP_LECT_SFA_assessmentExport.php?assId=<?=$assId?>">txt</a></p>
					</div>

					<?php 
//					$sql = "
//						SELECT *, p.id AS rqstId, p.id_stud AS studId 
//						FROM platform__SFA__subscription as p 
//						LEFT JOIN platform__user as q 
//							ON p.id_stud=q.id 
//						WHERE (p.id_ass=$assId) 
//						ORDER BY p.status ASC, q.surname DESC";
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
						WHERE (p.id_ass=$assId AND p.status=1) 
						GROUP BY p.id_stud 
						ORDER BY p.status ASC, q.surname DESC";
					$result=mysqli_query($conn,$sql);
					if ($result) $totale=mysqli_num_rows($result); else $totale=0;
					
					?>
					<div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> subscription</p>
						<div class="clear"></div>
					</div>


					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit">Student</th>
								<th class="tdtit" style="text-align: right;">Results</th>
								<th class="tdtit"></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count=1;
							while ($row=mysqli_fetch_array($result)) { 
//								$rqstId=$row["rqstId"];
//								$studId=$row["studId"];
//								$studName=$row["name"];
//								$studSurname=$row["surname"];
//								$RqstStatus=$row["status"];
								$rqstId=$row["rqstId"];
								$studId=$row["studId"];
								$studName=$row["studName"];
								$studSurname=$row["studSurname"];
								$RqstStatus=$row["assRqstStatus"];
								$studEmail=$row["studEmail"];
								$studUniDepartment=$row["studUniDepartment"];
								$studUsn=$row["studUsn"];

								if ($RqstStatus==1) $RqstStatusTr="<button type=\"button\" class=\"verde\" style=\"width: 80px;cursor: default;\" />accepted</button>"; // Il professore ha accettato la richiesta
								elseif ($RqstStatus==2) $RqstStatusTr="<button type=\"button\" class=\"grigio\" style=\"width: 80px;cursor: default;\" />rejected</button>"; // Il professore NON ha accettato la richiesta
								else $RqstStatusTr="<button type=\"button\" class=\"rosso\" style=\"width: 80px;cursor: default;\" />waiting</button>"; // Il professore non ha ancora valutato la richiesta


								$lnk1="./MP_LECT_SFA_assessmentResult1.php?assId=".$assId."&stuId=".$studId;

								$param=$assId."|".$studId;


								$assResult="";
								$assProtected="";
								$sql8 = "
									SELECT * 
									FROM platform__SFA__assanswer 
									WHERE (id_ass=$assId AND id_stud=$studId)
									LIMIT 1";
								$result8=mysqli_query($conn,$sql8);

								while ($row8=mysqli_fetch_array($result8)) { 
									$assResult=$row8["totpoint"];
									$assProtected=$row8["protected"];
									$endTime=$row8["endtime"];
								}

								if ($endTime!="" AND $endTime!="0000-00-00 00:00:00") {
									$endTime=Date("Y-m-d H:i:s",strtotime($endTime));
									$endDate = date_create($endTime, timezone_open('Europe/Rome'));
									date_timezone_set($endDate, timezone_open($uniTimezone));
									$endTime=$endDate->format('Y-m-d H:i:s');

									//if ($studId==997) echo $endTime."<br />";
							
									$ins_data_expl=explode("-",$endTime);
									$ins_data_aa=$ins_data_expl[0];
									$ins_data_mm=$ins_data_expl[1];
									$ins_data_expl1=explode(" ",$ins_data_expl[2]);
									$ins_data_gg=$ins_data_expl1[0];
									$ins_data_expl2=explode(":",$ins_data_expl1[1]);
									$ins_data_ora=$ins_data_expl2[0];
									$ins_data_min=$ins_data_expl2[1];
									$endTime=$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa." ".$ins_data_ora.":".$ins_data_min;
								} else $endTime="";


								?>
								<tr>
									<td style="font-size: 0.9em;text-align: center;">
										<div id="blkRqst<?=$rqstId?>"><?=$RqstStatusTr?></div>
									</td>
									<td style="padding-top: 5px;font-size: 0.9em;">
										<p style="font-size: 1.3em;font-weight: 400;"><?=$studName?> <?=$studSurname?></p>
										<p><a href="mailto:<?=$studEmail?>"><?=$studEmail?></a></p>
										<p>USN: <?=$studUsn?></p>
										<p><?=$studUniDepartment?></p>
									</td>
									<td style="padding-top: 5px;font-size: 1.2em;font-weight: 600;color: #999;">
										<?php if ($assProtected) {?>
											<?=$assResult?><br /> 
											<?php if ($endTime) {?><em style="font-size: 0.7em;font-weight: normal;font-style: normal;">(submitted <?=$endTime?>)</em><?php }?>
										<?php }?>
									</td>
									<td style="padding-top: 5px;font-size: 0.9em;">
										<?php if ($assProtected) {?><a href="<?=$lnk1?>">details</a><br /><?php }?>
									</td>
								</tr>
								<?php 
							}
							?>
						</tbody>
					</table>					

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>