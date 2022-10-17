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

$act=$_GET["act"];
$lectId=$_GET["lectId"];

$newTopicName=Pulisci_INS($_POST["newTopicName"]);

if ($_GET["act"]=="nTP" AND $newTopicName) {

	$sql = "
		INSERT INTO `platform__topic` 
		(`name`)  
		VALUES ('$newTopicName')";
	$result=mysqli_query($conn,$sql);
	
	$redirectUrl="./MP_LECT_topicManage.php";

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

}
?>

					<p class="rsvPage_Title">Topics and Subtopics</p>
					<p class="rsvPage_Title1">Manage Topics/Subtopics</p>

					<p style="padding: 15px 5px 0 0;font-size: 1.2em;">It is not possible to delete a subtopic if there are questions related to it.</p>
					<p style="padding: 0 5px 0 0;font-size: 1.2em;">It is not possible to delete a topic if it includes subtopics or there are questions related to it.</p>

					<?php 

					$sqlP = "
						SELECT *
						FROM platform__topic 
						WHERE hidden=0 
						ORDER BY name ASC";
					$resultP=mysqli_query($conn,$sqlP);
					if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

					?>
					<div style="margin: 25px 0 5px 5px;">
						<form method="post" action="./MP_LECT_topicManage.php?act=nTP" enctype="multipart/form-data">
							<div style="float: left;width: 550px;padding: 0 10px 0 0;text-align: right;">
								<div><input type="text" name="newTopicName" value="" style="width: 350px;padding: 5px;" /><input type="submit" name="save" value="ADD NEW TOPIC" class="proceed" style="width: 150px;margin-left: 10px;padding: 5px;" /></div>
							</div>
							<div style="float: right;width: 100px;padding: 10px 0 0 0;text-align: right;">Found <?=$totale?> topics</div>
							<div class="clear"></div>
						</form>
					</div>

					<table class="table table-hover" style="margin-top: 35px;">
						<thead>
							<tr>
								<th class="tdtit"></th>
								<th class="tdtit">Name</th>
								<th class="tdtit">Subtopic</th>
								<th class="tdtit"></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count=1;
							while ($row=mysqli_fetch_array($resultP)) { 
								$topicId=$row["id"];
								$topicName=$row["name"];

								$slqQst="
									SELECT *
									FROM platform__SNA__questions 
									WHERE topic=$topicId AND subtopic=0";
								$resultQst=mysqli_query($conn,$slqQst);
								if ($resultQst) $totqst=mysqli_num_rows($resultQst); else $totqst=0;

								$slqQst11="
									SELECT *
									FROM platform__SNA__questions 
									WHERE topic=$topicId";
								$resultQst11=mysqli_query($conn,$slqQst11);
								if ($resultQst11) $totqstdel=mysqli_num_rows($resultQst11); else $totqstdel=0;

								$slqQst12="
									SELECT *
									FROM platform__subtopic 
									WHERE id_top=$topicId";
								$resultQst12=mysqli_query($conn,$slqQst12);
								if ($resultQst12) $totqstdel1=mysqli_num_rows($resultQst12); else $totqstdel1=0;

								if (!$totqstdel AND !$totqstdel1) $imgDel="<a href='./MP_LECT_topicDelete.php?act=delTP&idTP={$topicId}'><img src='./impianto/img/delete.jpg' width='15' height='15' alt='Delete Topic' title='Delete Topic' /></a>";
								else $imgDel="<img src='./wiztr.gif' width='15' height='15' alt='' />";
								?>
								<tr>
									<td style="font-size: 0.9em;"><?=$count?></td>
									<td style="font-size: 0.9em;">
										<p style="font-size: 1.1em;font-weight: 400;"><?=$imgDel?> <?=$topicName?> <span style="font-size: 0.8em;color: #999;">(<?=$totqst?>)</span></p>
									</td>
									<td>
										<?php 
											$sqlSP = "
												SELECT *
												FROM platform__subtopic 
												WHERE (id_top=$topicId AND hidden=0) 
												ORDER BY name ASC";
											$resultSP=mysqli_query($conn,$sqlSP);
											
											$k=1;
											while ($rowSP=mysqli_fetch_array($resultSP)) { 
												$subtopicId=$rowSP["id"];
												$subtopicName=$rowSP["name"];
												
												$slqQst1="
													SELECT *
													FROM platform__SNA__questions 
													WHERE topic=$topicId AND subtopic=$subtopicId";
												$resultQst1=mysqli_query($conn,$slqQst1);
												if ($resultQst1) $totqst1=mysqli_num_rows($resultQst1); else $totqst1=0;

												if (!$totqst1) $imgDel1="<a href='./MP_LECT_topicDelete.php?act=delTP&idSTP={$subtopicId}'><img src='./impianto/img/delete.jpg' width='10' height='10' alt='Delete Subtopic' title='Delete Subtopic' /></a>";
												else $imgDel1="<img src='./wiztr.gif' width='10' height='10 alt='' />";

												?><p><?=$imgDel1?> <?=$subtopicName?> <span style="font-size: 0.8em;color: #999;">(<?=$totqst1?>)</span></p><?php 

												$k+=1;
											}

										?>
									</td>
									<td><a href="./MP_LECT_topicEdit.php?topicId=<?=$topicId?>">edit</a></td>
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