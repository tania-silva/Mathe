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

//print_r($_POST);

$srcTopic=$_POST["srcTopic"];
if (!$srcTopic) $srcTopic=$_GET["srcTopic"];
$srcSubTopic=$_POST["srcSubTopic"];
if (!$srcSubTopic) $srcSubTopic=$_GET["srcSubTopic"];

$act=$_GET["act"];
$lectId=$_GET["lectId"];

$newKeyword=Pulisci_INS($_POST["newKeyword"]);

if ($_GET["act"]=="nKW" AND $newKeyword AND $srcTopic) {
	
	if (!$srcSubTopic) $srcSubTopic=0;

	$sql = "
		INSERT INTO `platform__keywords` 
		(`id_top`, `id_sub`, `name`)  
		VALUES ('$srcTopic', '$srcSubTopic', '$newKeyword')";
	$result=mysqli_query($conn,$sql);
	
	$redirectUrl="./MP_LECT_keywordsManage.php?srcTopic=".$srcTopic."&srcSubTopic=".$srcSubTopic;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";

}

if ($_GET["act"]=="mKW" AND $srcTopic) {
	
	if (!$srcSubTopic) $srcSubTopic=0;

	foreach ($_POST as $chiave => $valore) {
		if (substr($chiave,0,4)=="KWUP") {
			$keyIdCicled=str_replace("KWUP","",$chiave);
			$keyHiddenValue=$_POST["KWHI".$keyIdCicled];
			if (!$keyHiddenValue) $keyHiddenValue=0;

			if ($valore) {
				$sql = "
					UPDATE `platform__keywords` 
					SET 
						name='$valore', 
						hidden=$keyHiddenValue
					WHERE id=$keyIdCicled";
				$result=mysqli_query($conn,$sql);
			}
		}

		//echo $sql."<br />";

		$sql="";
		$keyIdCicled="";
		$keyHiddenValue="";
	}

	$redirectUrl="./MP_LECT_keywordsManage.php?srcTopic=".$srcTopic."&srcSubTopic=".$srcSubTopic;

	echo "<SCRIPT LANGUAGE=JAVASCRIPT>";
	echo "document.location.href='".$redirectUrl."';";
	echo "</SCRIPT>";
}

$checkSubTopic=0;
if ($srcTopic) {

	$sql = "
		SELECT * 
		FROM platform__topic
		WHERE (hidden=0 AND id=$srcTopic) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$topicName=$row["name"];
	}

	$sqlCheck = "
		SELECT *
		FROM platform__subtopic 
		WHERE (hidden=0 AND id_top=$srcTopic)";
	$resultCheck=mysqli_query($conn,$sqlCheck);
	if ($resultCheck) $checkSubTopic=mysqli_num_rows($resultCheck);
}

if ($srcSubTopic) {

	$sql = "
		SELECT * 
		FROM platform__subtopic
		WHERE (hidden=0 AND id=$srcSubTopic) 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	
	while ($row=mysqli_fetch_array($result)) { 
		$subTopicName=$row["name"];
		$subTopicName=" / ".$subTopicName;
	}
}
?>

					<p class="rsvPage_Title">Manage Keywords</p>
					<p class="rsvPage_Title1">MathE Platform</p>

					<?php 

					$sqlP = "
						SELECT *
						FROM platform__topic 
						WHERE hidden=0 
						ORDER BY name ASC";
					$resultP=mysqli_query($conn,$sqlP);
					if ($resultP) $totale=mysqli_num_rows($resultP); else $totale=0;

					?>
					<!-- <div style="margin: 25px 0 5px 5px;">
						<p style="float: right;width: 300px;padding: 0 10px 0 0;text-align: right;">Found <?=$totale?> keyword(s)</p>
						<div class="clear"></div>
					</div>
					<div class="clear"></div> -->

					<form method="post" action="./MP_LECT_keywordsManage.php" style="margin: 25px 0 0 0;padding: 10px;font-size: 0.9em;background-color: #e1f7ff;border: solid 1px #00AEEF;border-radius: 5px;">
						<p style="float: left;width: 60px;font-size: 0.9em;">Search By:</p>
						<div style="float: left;width: 250px;">
							Topic:<br />
							<select name="srcTopic" onchange="subTopic2(this.options[this.selectedIndex].value);document.getElementById('pageBlk').style.display='none';">
								<option value="">All Topics</option>
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
									?><option value="<?=$topId?>" <?php if ($srcTopic==$topId) echo "selected";?>><?=$topName?></option><?php 
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
								<select name="srcSubTopic" style="width: 250px;" onchange="document.getElementById('pageBlk').style.display='none';">
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
										?><option value="<?=$subtopicId?>" <?php if ($srcSubTopic==$subtopicId) echo "selected";?>><?=$subtopicName?></option><?php 
									}
									?>
								</select>
							</div>
						</div>
						<div style="float: right;width: 100px;margin-right: 10px;">
							<a href="./MP_LECT_SNA_questionManage.php"><button type="button" class="abort" />All</button></a>
							<input type="submit" value="filter" class="filter" />
						</div>
						<div class="clear"></div>

					</form>


					<?php if (($srcTopic AND $checkSubTopic==0) OR ($srcTopic AND $srcSubTopic)) {?>

						<div id="pageBlk" class="signup_field_ext"  style="margin: 25px 0 5px 5px;padding: 25px 0;border: solid 1px #00aeef;border-radius: 10px;">
							
							<div style="margin-bottom: 25px;text-align: center;font-size: 1.1em;">
								<p>These are the keywords of</p>
								<p style="font-size: 1.4em;font-weight: 400;"><?=$topicName?><?=$subTopicName?></p>
							</div>

							<form method="post" action="./MP_LECT_keywordsManage.php?act=nKW&srcTopic=<?=$srcTopic?>&srcSubTopic=<?=$srcSubTopic?>" enctype="multipart/form-data">
								<div style="width: 700px;padding: 0 10px 0 50px;">
									<div>
										<input type="text" name="newKeyword" value="" style="display: inline;width: 400px;padding: 5px;" /><input type="submit" name="save" value="ADD NEW KEYWORD" class="proceed" style="display: inline;width: 200px;margin-left: 10px;padding: 5px;" />
									</div>
								</div>
								<div class="clear"></div>
							</form>

							<p style="padding: 25px 15px 0 50px;font-size: 1.2em;">In order to edit the name of a keyword, change the name and click on save.</p>
							<form method="post" action="./MP_LECT_keywordsManage.php?act=mKW&srcTopic=<?=$srcTopic?>&srcSubTopic=<?=$srcSubTopic?>" enctype="multipart/form-data" style="display: block;margin-top: 5px;padding: 0 0 20px 50px;">
								<table class="table table-hover">
									<thead>
										<tr>
											<th></th>
											<th>hidden</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (!$srcSubTopic) {
											$sql = "
												SELECT *, p.id AS topicId, q.id AS keyId, p.name AS topicName, q.name AS keyName, q.hidden AS keyHidden  
												FROM platform__topic as p 
												LEFT JOIN platform__keywords as q 
												ON (p.id=q.id_top AND q.id_sub=0)
												WHERE (p.hidden=0 AND q.id_top=$srcTopic AND q.id_sub=0) 
												ORDER BY keyName ASC";
											$result=mysqli_query($conn,$sql);

											while ($row=mysqli_fetch_array($result)) { 
												$topicId=($row["topicId"]);
												$topicName=($row["topicName"]);
												$keyId=($row["keyId"]);
												$keyName=($row["keyName"]);
												$keyHidden=($row["keyHidden"]);
												if ($keyHidden==1) $inpDisabled="color: #777;background-color: #ccc;"; else $inpDisabled="";
												?>
												<tr>
													<td><input type="text" name="KWUP<?=$keyId?>" value="<?=$keyName?>" <?php if ($keyHidden==1) echo "readonly=\"readonly\"";?> style="display: inline;width: 550px;<?=$inpDisabled?>" /></td>
													<td><input type="checkbox" name="KWHI<?=$keyId?>" value="1" <?php if ($keyHidden==1) echo "checked=\"checked\"";?> style="display: inline;width: 25px;" /></td>
												</tr>
												<?php 
											}
										} else {
											$sql = "
												SELECT *, p.id AS topicId, q.id AS keyId, p.name AS topicName, q.name AS keyName, q.hidden AS keyHidden  
												FROM platform__subtopic as p 
												LEFT JOIN platform__keywords as q 
												ON (p.id=q.id_sub)
												WHERE (p.hidden=0 AND q.id_sub=$srcSubTopic) 
												ORDER BY keyName ASC";
											$result=mysqli_query($conn,$sql);

											while ($row=mysqli_fetch_array($result)) { 
												$subTopicId=($row["topicId"]);
												$topicName=($row["topicName"]);
												$keyId=($row["keyId"]);
												$keyName=($row["keyName"]);
												$keyHidden=($row["keyHidden"]);
												if ($keyHidden==1) $inpDisabled="color: #bbb;background-color: #eee;"; else $inpDisabled="";
												?>
												<tr>
													<td><input type="text" name="KWUP<?=$keyId?>" value="<?=$keyName?>" <?php if ($keyHidden==1) echo "readonly=\"readonly\"";?> style="display: inline;width: 550px;<?=$inpDisabled?>" /></td>
													<td><input type="checkbox" name="KWHI<?=$keyId?>" value="1" <?php if ($keyHidden==1) echo "checked=\"checked\"";?> style="display: inline;width: 25px;" /></td>
												</tr>
												<?php 
											}

										}
										?>
									</tbody>
								</table>
								<div class="clear"></div>

								<div class="signup_submit" style="padding-left: 70px;">
									<!-- <a href="./MP_LECT_SNA_videoLesManage.php"><button type="button" class="abort" />Abort</button></a> -->
									<input type="submit" value="Save" class="proceed" style="margin-left: 120px;" />
								</div>
							</form>
						</div>

					<?php }?>


					
					
					

			


			<!-- INCOLLA END -->
		</div> <!-- rsv_crp -->
	</div> <!-- cnt1 -->
</div> <!-- container -->
<?php include('bottom.php'); ?>