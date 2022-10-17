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

?>

					<p class="rsvPage_Title">Topics and Subtopics</p>
					<p class="rsvPage_Title1">Assign Topic and SubTopic to Lecturer</p>

					<?php 
					$sqlP = "
						SELECT *,
							p.id AS lectId,
							p.name AS lectName, 
							p.surname AS lectSurname, 
							q.email AS lectEmail, 
							q.field_of_research AS lectFieldOfResearch, 
							q.subject_taught AS lectSubjectTaught, 
							q.years_of_experience AS lectYearsOfExperience, 
							q.profile AS lectProfile, 
							q.uni_department AS lectUniDepartment, 
							q.uni_city AS lectUniCity, 
							q.uni_address AS lectUniAddress, 
							k.name AS lectUniName, 
							k.country AS lectUniCountry 
						FROM platform__user AS p 
						LEFT JOIN platform__lecturers AS q 
						ON p.id=q.id_lect 
						LEFT JOIN platform__university AS k 
						ON q.uni_name=k.id 
						WHERE (p.typology='lecturer' AND p.profile='admin') 
						ORDER BY surname ASC";
					$resultP=mysqli_query($conn,$sqlP);
					if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

					?>
					<div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> admins</p>
						<div class="clear"></div>
					</div>

					<table class="table table-hover">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit">Admin Name</th>
								<th class="tdtit">Topic / SubTopic to evaluate</th>
								<th class="tdtit"></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$count=1;
						while ($row=mysqli_fetch_array($resultP)) { 

							//$pict_id=$row["id"];
							$lectId=$row["lectId"];
							$lectName=$row["lectName"];
							$lectSurname=$row["lectSurname"];
							$lectEmail=$row["lectEmail"];
							$lectFieldOfResearch=$row["lectFieldOfResearch"];
							$lectSubjectTaught=$row["lectSubjectTaught"];
							$lectYearsOfExperience=$row["lectYearsOfExperience"];
							$lectProfile=$row["lectProfile"];
							$lectUniName=$row["lectUniName"];
							$lectUniCountry=$row["lectUniCountry"];
							$lectUniDepartment=$row["lectUniDepartment"];
							$lectUniCity=$row["lectUniCity"];
							$lectUniAddress=$row["lectUniAddress"];

							$lectName.=" ".$lectSurname;
							$uniAddress=$lectUniAddress." - ".$lectUniCity." (".$lectUniCountry.")";
							?>
							<tr>
								<td style="font-size: 0.9em;"><?=$count?></td>
								<td style="font-size: 0.9em;">
									<p style="font-size: 1.1em;font-weight: 400;"><?=$lectName?></p>
									<p style="font-style: italic;"><?=$lectUniName?> (<?=$lectUniCountry?>)</p>
								</td>
								<td>
								
								
								
									<?php 
									if ($lectId==37) {
										echo "all topics/subtopics";
									} else {

										$tpoSTR="";
										$sqlL1 = "
											SELECT * 
											FROM  platform__lecturers 
											WHERE (id_lect='$lectId') 
											LIMIT 1";
										$resultL1=mysqli_query($conn,$sqlL1);
																					
										while ($rowL1=mysqli_fetch_array($resultL1)) { 
											$tpoSTR=$rowL1["topic_permission"];
										}

										if ($tpoSTR) {
											$sqlS1 = "
												SELECT *
												FROM platform__topic 
												WHERE hidden=0 
												ORDER BY name ASC";
											$resultS1=mysqli_query($conn,$sqlS1);
											if ($resultS1) $totale=mysqli_num_rows($resultS1); else $totale=0;

											while ($rowS1=mysqli_fetch_array($resultS1)) { 
												$topicId=$rowS1["id"];
												$topicName=$rowS1["name"];

												$checkedRs="";
													$checkSTR="_top".$topicId."_";
													$find=strpos($tpoSTR, $checkSTR);
													if ($find) {?><p>- <?=$topicName?></p><?php }

												$sqlS2 = "
													SELECT *
													FROM platform__subtopic 
													WHERE (id_top=$topicId AND hidden=0) 
													ORDER BY name ASC";
												$resultS2=mysqli_query($conn,$sqlS2);
												
												$k=1;
												while ($rowS2=mysqli_fetch_array($resultS2)) { 
													$subtopicId=$rowS2["id"];
													$subtopicName=$rowS2["name"];
													
													$slqQst1="
														SELECT *
														FROM platform__SNA__questions 
														WHERE topic=$topicId AND subtopic=$subtopicId";
													$resultQst1=mysqli_query($conn,$slqQst1);
													if ($resultQst1) $totqst1=mysqli_num_rows($resultQst1); else $totqst1=0;
													
													$checkedRs1="";
														$checkSTR1="_sub".$topicId."|".$subtopicId."_";
														$find1=strpos($tpoSTR, $checkSTR1);
														if ($find1) {?><p style="padding-left: 25px;"><?=$subtopicName?></p><?php }
												}
											}
										}
									}
									?>
								</td>
								<td>
									<?php if ($lectId!=37) {?>
										<a href="./MP_LECT_topicAssignEdit.php?lectId=<?=$lectId?>">edit</a>
									<?php }?>
								</td>
							</tr>
							<?php 
							$count+=1;
						}
						?>
						</tbody>
					</table>					

					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>