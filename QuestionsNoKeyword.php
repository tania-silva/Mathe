<?php include('www/impianto/inc/function.php'); ?>

<?php 
$idQuestion = [];
$idQuestionk = [];

$sql="
SELECT `id` FROM `platform__sna__questions`";
$sqlResult=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($sqlResult)) { 
    array_push($idQuestion, $row1["id"]);
}

$sql="
SELECT DISTINCT `id_sna_question` FROM platform_keyword_snaquestion";
$sqlResult=mysqli_query($conn,$sql);

while ($row1=mysqli_fetch_array($sqlResult)) { 
    array_push($idQuestionk, $row1["id_sna_question"]);
}

$result = array_diff($idQuestion, $idQuestionk);
foreach($result as $r){
    var_dump($r.";");
}

?>