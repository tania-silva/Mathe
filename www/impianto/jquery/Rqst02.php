<?php include('../inc/function.php'); //FUNZIONI PHP


if(isset($_GET["rqst"])) $rqst=$_GET["rqst"];
if(isset($_GET["idTop"])) $idTop=$_GET["idTop"];


if ($rqst==1) {
	$sql = "
		SELECT * 
		FROM platform__subtopic 
		WHERE (id_top=$idTop AND hidden=0) 
		ORDER BY name ASC";
	$result=mysqli_query($conn,$sql);
	$totale=mysqli_num_rows($result);

	if ($totale>0) {
		?><select name="subtopic" style="width: 250px;">
				<option value="">All Subtopics</option>
				<?php
				while ($row=mysqli_fetch_array($result)) { 
					$subtopicId=($row["id"]);
					$subtopicName=($row["name"]);


					$sql1 = "
						SELECT * 
						FROM platform__SFA__questions 
						WHERE (subtopic=$subtopicId AND validate=1)";
					$result1=mysqli_query($conn,$sql1);
					$qstNb1=mysqli_num_rows($result1);

					?><option value="<?=$subtopicId?>"><?=$subtopicName?> (<?=$qstNb1?>)</option><?php
				}
		?></select><?php
	} else echo "&nbsp;";
} elseif ($rqst==2) {
	$sql = "
		SELECT * 
		FROM platform__subtopic 
		WHERE (id_top=$idTop AND hidden=0) 
		ORDER BY name ASC";
	$result=mysqli_query($conn,$sql);
	$totale=mysqli_num_rows($result);

	if ($totale>0) {
		?><select name="subtopic" style="width: 250px;">
				<option value="">All Subtopics</option>
				<?php
				while ($row=mysqli_fetch_array($result)) { 
					$subtopicId=($row["id"]);
					$subtopicName=($row["name"]);


					$sql1 = "
						SELECT * 
						FROM platform__SFA__questions 
						WHERE (subtopic=$subtopicId AND validate=1)";
					$result1=mysqli_query($conn,$sql1);
					$qstNb1=mysqli_num_rows($result1);


					if ($qstNb1>0) {
						?><option value="<?=$subtopicId?>"><?=$subtopicName?> (<?=$qstNb1?>)</option><?php
					}
				}
		?></select><?php
	} else echo "&nbsp;";

}
?>