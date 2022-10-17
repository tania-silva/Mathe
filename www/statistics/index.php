<?php include("database.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Demo</title>
        <link rel="stylesheet" href="style.css">
        <style>body { font-family: system-ui; margin: 20px 50px; }</style>
    </head>
    <body>
        <div>
            <h2>Question Statistics</h2>
            <table id="question_table"> </table>
        </div>
        <div>
            <h2>Topic Statistics</h2>
            <table id="topic_table"> </table>
        </div>

        <script src="simple-datatables.js"></script>
        <script>
         {
             var tableConfig = {perPage: 5}
             var DataTables = {todo: [], tables: []};

		     let raw_data = <?php mathe_data("questions", $key = "question_id", $mode = ARRAY_PRINT_MODE) ?>;
             let data = {
                 headings: [
                     'Question',
                     'Level',
                     '#Correct',
                     '#Wrong',
                     '#Answers',
                 ],
		         data: raw_data.map(q => [q.question, q.level, q.correct_guesses, q.wrong_guesses, q.answer_count])
             };
		     let config = {data, ...tableConfig, filters: {"Level": ["Advanced", "Basic"]}};
             DataTables.todo.push([document.getElementById("question_table"), config]);
         }
        </script>
        <script>
         {
             let raw_data = <?php mathe_data("topics", $key = "question_id", $mode = ARRAY_PRINT_MODE) ?>;
             let data = {
                 headings: [
                     'Topic Name',
                     'Topic Level',
                     'Number of Correct Guesses',
                     'Number of Wrong Guesses',
                     'Number of Answers',
                 ],
                 data: raw_data.map(q => [q.name, q.level, q.correct_guesses, q.wrong_guesses, q.answer_count])
             };
             let config = { data, ...tableConfig };
             DataTables.todo.push([document.getElementById("topic_table"), config]);
         }
        </script>
        <script>
         window.onload = () => {
             DataTables.tables = DataTables.todo.map(([table, config]) => {
                 return datatable =  new simpleDatatables.DataTable(table, config);
             });
         };
        </script>

    </body>
</html>
