<?php
include('./top.php'); // funzioni PHP
?>


<?php 

$msg=$_GET["msg"];
$topicGet=Pulisci_INS($_GET["topic"]);
$subTopicGet=Pulisci_INS($_GET["subtopic"]);
$levelGet=Pulisci_INS($_GET["level"]);

if ($_GET["act"]=="reg" AND $usrId) {

	$topic=Pulisci_INS($_POST["topic"]);
	$subTopic=Pulisci_INS($_POST["subtopic"]);
	$level=Pulisci_INS($_POST["level"]);
	$date=Date("Y-m-d H:i:s");

	$where="WHERE (validate=1 AND ";
	if ($topic) $where.="topic=$topic AND ";
	if ($subTopic) $where.="subtopic=$subTopic AND ";
	if ($level) $where.="level='$level' AND ";
	$where=substr($where,0,-5);
	$where.=")";

	//$where="";

	$sql = "
		SELECT * 
		FROM platform__SNA__questions 
		".$where."  
		ORDER BY rand() 
		LIMIT 7";
	$result=mysqli_query($conn,$sql);
	$totale=mysqli_num_rows($result);

	if ($totale>0) {
		$k=1;
		while ($row=mysqli_fetch_array($result)) { 
			${"qst0".$k}=$row["id"];
			$k+=1;
		}

		$sql = "
			INSERT INTO `platform__SNA__assestment` 
			(`id_stud`, `date`, `topic`, `subtopic`, `level`, `qst01`, `qst02`, `qst03`, `qst04`, `qst05`, `qst06`, `qst07`)  
			VALUES ('$usrId', '$date', '$topic', '$subTopic', '$level', '$qst01', '$qst02', '$qst03', '$qst04', '$qst05', '$qst06', '$qst07')";
		$result=mysqli_query($conn,$sql);
		$assId=mysqli_insert_id($conn);

		header("location: ./STAS_SNA_quiz.php?assId=".$assId); 
		die();
	} else {
		header("location: ./STAS_SNA.php?msg=K0&topic=".$topic."&subtopic=".$subTopic."&level=".$level); 
		die();
	}

}
?>
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
	<main>

        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title">
                        <h1>Final Assessment</h1>
                    </div>
                </div>
            </div>
        </section>
	
	
        <!-- Blog detail -->
        <section class="single section-padding-large">
            <div class="container">
                <div class="row">
			<div class="col-1"></div>
			
                    <div class="col-10">
                        <div class="single-content">
							
							<nav aria-label="breadcrumb">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item">Student's Assessment</li>
								</ul>
							</nav>
				
							<h2 class="single-title">
								This toolkit allows teachers to elaborate Final Assessments for their students on the topics they wish to evaluate. Students can apply when a Final Assessment is available for a course they attend. In order to see the list of the available final assessments, please log in.
							</h2>

							
							<br /><br />

			
							<!-- <div class="info">
								<div class="entry">
									<span class="categories">
										<i class="fas fa-tag"></i>Final Assessment
									</span>
								</div>
							</div> -->
				
				<!-- START contenuto pagina -->
				
                                <div id="page_crp" style="padding-top: 15px;">
					<?php  if ($_SESSION["guest"]) {

						$sql = "
							SELECT *, 
								k.id AS uniId, 
								k.name AS uniName, 
								k.timezone AS uniTimezone 
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
							$uniTimezone=$row["uniTimezone"];
						}
						
						
						$sql = "
							SELECT *, 
								p.id AS assId, 
								k.name AS lectName, 
								k.surname AS lectSurname
							FROM platform__SFA__assestment as p 
							LEFT JOIN platform__lecturers as q 
								ON p.id_lect=q.id_lect
							LEFT JOIN platform__user as k 
								ON k.id=q.id_lect
							WHERE (
								q.uni_name=$uniId AND 
								p.status=1 AND 
								p.FA_date>=CURDATE() 
							) ORDER BY FA_date DESC";
						$result=mysqli_query($conn,$sql);
						$assNb=mysqli_num_rows($result);

						if ($assNb>0) {

							while ($row=mysqli_fetch_array($result)) { 
								$assId=$row["assId"];
								$titleSFA=$row["title"];
								$description=$row["description"];
								$FA_date=$row["FA_date"];
								$duration=$row["duration"];
								$assStatus=$row["status"];
								$lectName=$row["lectName"];
								$lectSurname=$row["lectSurname"];

							
								if (strlen($description)>200) $description=substr($description,0,200)."...";


								$dateHStart=Date("H:i",strtotime($FA_date));
								$dateHStop=Date("H:i",strtotime($FA_date." + ".$duration." minutes"));


								$FA_date=Date("Y-m-d H:i:s",strtotime($FA_date));
								$date = date_create($FA_date, timezone_open('UTC'));
								$Dt1=$date->format('Y-m-d H:i:s');
								date_timezone_set($date, timezone_open($uniTimezone));
								$FA_date=$date->format('Y-m-d H:i:s');
								$FA_dateHStart=$date->format('H:i');
								$FA_dateHStop=Date("H:i",strtotime($FA_date." + ".$duration." minutes"));
								$dateCrf=Date("Y-m-d",strtotime($FA_date));

								date_default_timezone_set('UTC');
								$todayUTC=Date("Y-m-d",time());
								$todayHIUTC=Date("H:i",time());
								date_default_timezone_set($uniTimezone);


								//$today=Date("Y-m-d");
								if ($dateCrf>$todayUTC) $status="valid";
								elseif ($dateCrf==$todayUTC) $status="inprogress";
								else $status="expired";
								

								//echo $todayHIUTC." - ".$dateHStart;

								//echo $todayHIUTC." - ".$dateHStart;
								
								
								//$todayH=Date("H:i");
								if ($todayHIUTC<$dateHStart) $statusH="early";
								if ($todayHIUTC>=$dateHStart AND $todayHIUTC<$dateHStop) $statusH="inprogress";
								if ($todayHIUTC>=$dateHStop) $statusH="late";
								
								if ($FA_date!="" AND $FA_date!="0000-00-00 00:00:00") {
									$ins_data_expl=explode("-",$FA_date);
									$ins_data_aa=$ins_data_expl[0];
									$ins_data_mm=$ins_data_expl[1];
									$ins_data_expl1=explode(" ",$ins_data_expl[2]);
									$ins_data_gg=$ins_data_expl1[0];
									$ins_data_expl2=explode(":",$ins_data_expl1[1]);
									$ins_data_ora=$ins_data_expl2[0];
									$ins_data_min=$ins_data_expl2[1];
									$FA_date="<strong>".$ins_data_gg."/".$ins_data_mm."/".$ins_data_aa."</strong><br />h. ".$ins_data_ora.":".$ins_data_min;
								} else $FA_date="";

								$serverDateUTC=$todayUTC." ".$todayHIUTC;

								$serverDateUTC=Date("Y-m-d H:i:s",strtotime($serverDateUTC));
								$serverDate = date_create($serverDateUTC, timezone_open('UTC'));
								$Dt1=$serverDate->format('Y-m-d H:i:s');
								date_timezone_set($serverDate, timezone_open($uniTimezone));
								$serverDateUTC=$serverDate->format('d-m-Y H:i:s');

								?>
									<table class="table table-hover">
										<thead>
											<tr>
												<th class="tdtit">Lecturer</th>
												<th class="tdtit">Title</th>
												<th class="tdtit">Date</th>
												<th class="tdtit"></th>
												<th class="tdtit"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="5" style="font-size: 0.8em;text-align: right;">Server time <?=$serverDateUTC?></td>
											</tr>
											<tr>
												<td>
													<p><?=$lectName?> <?=$lectSurname?></p>
												</td>
												<td>
													<p style="font-size: 0.9em;color: #999;"><?=$uniName?></p>
													<p><strong><?=nl2br($titleSFA)?></strong></p>
													<p style="padding-top: 5px;font-size: 0.9em;line-height: 1.2em;"><em><?=$description?></em></p>
												</td>
												<td style="font-size: 0.8em;">
													<p><?=$FA_date?></p>
													<p><?=$duration?> minutes</p>
												</td>
												<td>
													<?php  
													if ($usrTypology=="student") {

														$sql1 = "
															SELECT * 
															FROM platform__SFA__subscription 
															WHERE (id_ass='$assId' AND id_stud='$usrId')
															LIMIT 1";
														$result1=mysqli_query($conn,$sql1);
														$assStudNb=mysqli_num_rows($result1);

														while ($row1=mysqli_fetch_array($result1)) { 
															$assStudStatus=$row1["status"];
														}

														if ($assStudNb) {
															if ($assStudStatus==1) $assRequest=2; // Il professore ha accettato la richiesta
															elseif ($assStudStatus==2) $assRequest=3; // Il professore NON ha accettato la richiesta
															else $assRequest=1; // Il professore non ha ancora valutato la richiesta
														} else $assRequest=0; // Lo studente non si  ancora registrato


														$sql2 = "
															SELECT *
															FROM platform__SFA__assanswer
															WHERE (id_ass=$assId AND id_stud=$usrId)
															LIMIT 1";
														$result2=mysqli_query($conn,$sql2);

														while ($row2=mysqli_fetch_array($result2)) { 
															$assProtected=$row2["protected"];
														}

														


														if ($status=="inprogress") {
															if ($statusH=="early") {
																?><p><button type="button" class="arancio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />START AT <?=$FA_dateHStart?></button></p><?php 
															}
															if ($statusH=="inprogress") {
																if ($assStudStatus==1) {
																	if ($assProtected==1) {
																		?><p><button type="button" class="grigio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />ON EVALUATION</button></p><?php 
																	} else {
																		?><p><a href="./STAS_FA_quiz.php?assId=<?=$assId?>"><button type="button" class="verde" style="width: 100px;margin: 0;padding: 5px;" />START ASSESSMENT</button></a></p><?php 
																	}
																} else {
																	?><p><button type="button" class="grigio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />IN PROGRESS</button></p><?php 
																}
															}
															if ($statusH=="late") {
																?><p><button type="button" class="blu" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />FINISHED<br />AT <?=$FA_dateHStop?></button></p><?php 
															}
														}

														//echo $statusH;
													} else {
														if ($status=="valid") {
															?><p><button type="button" class="verde" style="width: 100px;margin: 0;padding: 5px;font-size: 0.7em;cursor: auto;" />REGISTRATIONS ARE OPEN</button></p><?php 
														}
														if ($status=="inprogress") {
															if ($statusH=="early") {
																?><p><button type="button" class="arancio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />START AT <?=$FA_dateHStart?></button></p><?php 
															}
															if ($statusH=="inprogress") {
																?><p><button type="button" class="grigio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />IN PROGRESS</button></p><?php 
															}
															if ($statusH=="late") {
																?><p><button type="button" class="blu" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />FINISHED<br />AT <?=$FA_dateHStop?></button></p><?php 
															}
														}
													}
													?>
												</td>
												<td>
													<?php  
													if ($usrTypology=="student") {

														$sql1 = "
															SELECT * 
															FROM platform__SFA__subscription 
															WHERE (id_ass='$assId' AND id_stud='$usrId')
															LIMIT 1";
														$result1=mysqli_query($conn,$sql1);
														$assStudNb=mysqli_num_rows($result1);

														while ($row1=mysqli_fetch_array($result1)) { 
															$assStudStatus=$row1["status"];
														}

														if ($assStudNb) {
															if ($assStudStatus==1) $assRequest=2; // Il professore ha accettato la richiesta
															elseif ($assStudStatus==2) $assRequest=3; // Il professore NON ha accettato la richiesta
															else $assRequest=1; // Il professore non ha ancora valutato la richiesta
														} else $assRequest=0; // Lo studente non si  ancora registrato


														$sql2 = "
															SELECT *
															FROM platform__SFA__assanswer
															WHERE (id_ass=$assId AND id_stud=$usrId)
															LIMIT 1";
														$result2=mysqli_query($conn,$sql2);

														while ($row2=mysqli_fetch_array($result2)) { 
															$assProtected=$row2["protected"];
														}

														


														if ($status=="valid" OR $status=="inprogress") {
															?><div style="padding: 0 0 5px 0;"><?php 
															if (!$assRequest) {
																?><p><a href="./STAS_FA_assConfirm.php?assId=<?=$assId?>"><button type="button" class="giallo" style="width: 100px;margin: 0;padding: 5px;" />ASK TO PARTICIPATE</button></a></p><?php 
															} else {
																if ($assStudStatus==2) {
																	?><p><button type="button" class="abort" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />NOT ACCEPTED</button></p><?php 
																} elseif ($assStudStatus==1) {
																	?><p><button type="button" class="verde" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />ACCEPTED</button></p><?php 
																} else {
																	?><p><button type="button" class="arancio" style="width: 100px;margin: 0;padding: 5px;cursor: auto;" />WAITING RESPONSE</button></p><?php 
																}
															}
															?></div><?php 
														}

														//echo $statusH;
													}
													?>
												</td>
											</tr>
										</tbody>
									</table>
								<?php 
							}

						} else {
							/* Non ci sono esami in corso */
							?><p style="padding: 25px 0 0 0;font-size: 1.4em;color: #900;text-align: center;">Sorry, there aren't final assessment in this period.</p><?php 

						}
													
						
						?>

					<?php } else {?>
							<style>
								input.submit {
									padding: 1px 15px;
									font-size: 1em;
									font-weight: 400;
									color: #fff;
									text-align: center;

									/* verde */
									border-top: 1px solid #ccc;
									background: #006600;
									background: -webkit-gradient(linear, left top, left bottom, from(#33cc33), to(#006600));
									background: -webkit-linear-gradient(top, #33cc33, #006600);
									background: -moz-linear-gradient(top, #33cc33, #006600);
									background: -ms-linear-gradient(top, #33cc33, #006600);
									background: -o-linear-gradient(top, #33cc33, #006600);

									-webkit-border-radius: 6px;
									-moz-border-radius: 6px;
									border-radius: 6px;
								}

							</style>

							<div style="padding: 35px 0 35px 0;font-size: 1.2em;text-align: center;">
								<p style>To make an assessment you need to login:</p>
								<form method="post" action="./impianto/inc/check_mathePlatform.php" style="padding: 15px 0 15px 0;">
									<input type="text" id="usr" name="usr" value="" placeholder="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_username.png') #f6f6f6 no-repeat 5px 8px;" />
									<input type="password" id="psw" name="psw" value="" placeholder="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" style="display: block;width: 250px;margin: 10px auto;padding: 2px 5px 2px 25px;font-size: 0.9em;color: #666;border: solid 1px #d3d3d3;border-radius: 7px;background: url('./impianto/img/icone/ra_password.png') #f6f6f6 no-repeat 5px 8px;" />
									<input type="submit" class="submit" value="Login" style="display: block;width: 250px;margin: 10px auto;" />
								</form>
								<p>If you do not have username and password, please <a href="./MP_signIn.php">register to the portal</a>.</p>
							</div>
							<hr />
							<div style="float: left;width: 450px;margin-right: 100px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div style="float: left;width: 450px;margin-bottom: 25px;">
								<p>Video tutorial for lecturers on how to register</p>
								<iframe width="450" height="253" src="https://www.youtube.com/embed/W9CuBl97SRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div class="clear"></div>
							<div style="padding-top: 5px;"><a href="./files/MathE_Guidebook.pdf" class="nw"><img src="./impianto/img/pdf1.png" width="50" height="50" border="0" alt="" /></a> For more information, please consult the <a href="./files/MathE_Guidebook.pdf" class="nw">MathE Guidebook</a></div>
							<hr />

					<?php }?>
				</div> <!-- page_crp -->
				
				<!-- END contenuto pagina -->
				
				
			</div> <!-- single-content -->
		    </div>
			
			<div class="col-1"></div>
		</div>
	    </div>
	</section>
	</main>
			    
			    
    <!-- Footer page -->
	<?php include('./impianto/piede.php'); //PIEDE?>

    <!-- Back to top -->
    <div id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- JS -->

    <!-- Jquery and Boostrap library -->
    <script src="vendor/bootstrap/js/popper.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="js/theme-map.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.js"></script>
    <script src="js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="vendor/slick/slick.min.js"></script>
    <script src='vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="js/validate-form.js"></script>
    <script src="js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script> 
</body>
</html>
