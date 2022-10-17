<?php include('../inc/function.php'); //FUNZIONI PHP


if(isset($_GET["rqst"])) $rqst=$_GET["rqst"];
if(isset($_GET["param"])) $param=$_GET["param"];
if(isset($_GET["point"])) $point=$_GET["point"];

$paramAr=explode("|", $param);
$assId=$paramAr[0];
$qstId=$paramAr[1];
$usrId=$paramAr[2];

if ($rqst==1) {
	$sql = "
		UPDATE `platform__SFA__assquestions` 
		SET 
			point='$point'
		WHERE (id=$qstId AND id_ass=$assId AND id_lect=$usrId)";
	$result=mysqli_query($conn,$sql);
}