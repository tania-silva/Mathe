<!doctype html>
<?php
/* include("data.php"); */
include("../database.php");
?>
<html>
    <head>
	    <title>Charts</title>
	    <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

        <script>
         var question_use = <?php mathe_data("question_use"); ?>;
         var topic_question_count = <?php mathe_data("topic_question_count", "id", ARRAY_PRINT_MODE); ?>;
         var topic_use_count = <?php mathe_data("topic_use_count", "id", ARRAY_PRINT_MODE); ?>;
         var student_topic_evaluation = <?php mathe_data("student_topic_evaluation", "id_stud"); ?>;
        </script>
        <div class="chart_div">
            <p>Question Usage</p>
            <canvas id="chart"></canvas>
            <p id="legend"></p>
        </div>

        <div class="chart_div">
            <p>Topic Usage</p>
            <canvas id="chart2"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script  src="charts/chart.js"></script>
    </body>
</html>
