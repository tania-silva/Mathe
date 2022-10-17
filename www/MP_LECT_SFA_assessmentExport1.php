<?php
include('./impianto/inc/function.php'); // connessione

$assId=$_GET["assId"];

$sql = "
	SELECT *
	FROM `platform__SFA__assanswer` 
	WHERE `id_ass`=$assId";
$result=mysqli_query($conn,$sql);
$nStudents=mysqli_num_rows($result);

$sql = "
	SELECT *
	FROM `platform__SFA__assestment` 
	WHERE `id`=$assId
	LIMIT 1";
$result=mysqli_query($conn,$sql);
$find=mysqli_num_rows($result);

if($find>0){
	
	$nQst=0; // Numero di domande dell'esame
	while ($row=mysqli_fetch_array($result)) {
		$exDate=$row["FA_date"];
		for ($k=1; $k<=20; $k++) {
			if (strlen($k)<2) $k="0".$k;
			$qst{$k}=$row['qst'.$k];
			if ($qst{$k}) 	$nQst+=1;
		}
	}

	$exDate=date("Y_m_d",strtotime($exDate));

	$delimiter = ";";
	$filename = "EX".$assId."_".$exDate.".csv";
	
	//create a file pointer
	$f = fopen('php://memory', 'w');


	//output each row of the data, format line as csv and write to file pointer

	// INTESTAZIONE (prima riga)
	$sql = "
		SELECT *
		FROM `platform__SFA__assestment`
		WHERE id=$assId 
		LIMIT 1";
	$result=mysqli_query($conn,$sql);

	$strArray="EX".$assId.",";
	while ($row=mysqli_fetch_array($result)) {

		for ($k=1; $k<=$nQst; $k++) {
			if (strlen($k)<2) $k="0".$k;
			$qst{$k}=$row['qst'.$k];
			if ($qst{$k}) 	{
				$strArray.="SFA".$qst{$k}.",";
			}
		}
	}

	$strArray=substr($strArray,0,-1);
	$fields = array($strArray);
	fputcsv($f, $fields, $delimiter);

	// RISULTATI (righe successive)
	$result=mysqli_query($conn,"set platform__SFA__assanswer 'utf8'");
	$sql = "
		SELECT *
		FROM `platform__SFA__assanswer` AS p 
		LEFT JOIN platform__user AS q 
		ON p.id_stud=q.id 
		WHERE p.id_ass=$assId";
	$result=mysqli_query($conn,$sql);

	$strArray="";
	while ($row=mysqli_fetch_array($result)) {
		$stuId=$row["id_stud"];
		$stuName=$row["name"];
		$stuSurname=$row["surname"];

		$strArray="'".$stuName." ".$stuSurname."',";
		for ($k=1; $k<=$nQst; $k++) {
			if (strlen($k)<2) $k="0".$k;
			$qst{$k}=$row['qst'.$k];
			if ($qst{$k}) 	{
				$qstAr=explode("|",$qst{$k});
				$qstId="SFA".$qstAr[0];
				$qstAns=$qstAr[1];
				$strArray.=$qstAns.",";
			}
		}

		$strArray=substr($strArray,0,-1);
		//$strArray = str_replace('"', '', $strArray);
		$fields = array($strArray);
		//fputcsv(STDOUT, implode(',', $fields)."\n");
		fputcsv($f, $fields, $delimiter);

	}

	//move back to beginning of file
	fseek($f, 0);
	
	//set headers to download file rather than displayed
	header("Content-Encoding: utf-8");
//	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Type: application/text");
	header('Content-Disposition: attachment; filename="'.$filename.'";');
	
	//output all remaining data on a file pointer
	fpassthru($f);
}
?>
