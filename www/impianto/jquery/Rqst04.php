<?php include('../inc/function.php'); //FUNZIONI PHP


if(isset($_GET["rqst"])) $rqst=$_GET["rqst"];
if(isset($_GET["param"])) $param=$_GET["param"];

$paramAr=explode("|", $param);
$assId=$paramAr[0];
$usrId=$paramAr[1];

if ($rqst==1) {
	
	$sql = "
		SELECT * 
		FROM platform__SFA__subscription 
		WHERE (id_ass='$assId' AND id_stud='$usrId')
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$assStudStatus=$row["status"];
	}

	if (!$assStudStatus) {
		$assStudStatus=1;
		$button="<button type=\"button\" class=\"verde\" style=\"width: 80px;\" />accepted</button>";
	} elseif ($assStudStatus==1) {
		$assStudStatus=2;
		$button="<button type=\"button\" class=\"grigio\" style=\"width: 80px;\" />rejected</button>";
	} else {
		$assStudStatus=1;
		$button="<button type=\"button\" class=\"verde\" style=\"width: 80px;\" />accepted</button>";
	}
	
	$sql = "
		UPDATE `platform__SFA__subscription` 
		SET 
			status='$assStudStatus'
		WHERE (id_ass='$assId' AND id_stud='$usrId')";
	$result=mysqli_query($conn,$sql);

	echo $button;
}