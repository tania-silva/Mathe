<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sna_questions.csv"');
include_once('../impianto/inc/function.php');
include("./database.php");

mathe_data("sna_question", $key = "", $mode = CSV_PRINT_MODE);

?>
