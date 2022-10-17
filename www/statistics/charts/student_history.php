<?php
include('./statistics/database.php');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<canvas id="performace_chart"></canvas>

<script>
 function colorFromString(text, opacity = 0.5, magicNumbers = [709,337,101,1009]) {
     return 'rgba(' +
            magicNumbers.slice(0,3)
                        .map(p => text.charCodeAt(p % text.length -1) *  magicNumbers[3] % 255)
                        .join(",") +
            `,${opacity})`;
 }
 
 var raw_data = <?php mathe_data("studentHistory", $key = "date", ARRAY_PRINT_MODE, $prepared = ["i", [$usrId]]); ?>;

 var topics = Array.from(raw_data.filter(data => data["topic"] !== "")
                                 .reduce( (acc, val) => acc.add(val["topic"]), new Set()));
 
 var ctx = document.getElementById("performace_chart").getContext('2d');
 var chart = new Chart(ctx, {
     type: 'line',
     
     data: {
         labels: raw_data.map(e => e["date"]),
         datasets: topics.map(topic => {

             return {
                 data: raw_data.filter(data => data["topic"] === topic)
                               .map(data => { return {x: data["date"], y: data["correct"]}}),
                 label: topic,
                 backgroundColor: colorFromString(topic, 0.5),
                 borderColor:     colorFromString(topic, 1)
             }
         })
     },
     
     options: {
         title:{display: true, text: "Your Performace based on Self Need Assessments"},
         scales: {
	     xAxes: [{
		 display: true,
		 scaleLabel: {
		     display: true,
                     labelString: "Self Examination Dates"
		 }
	     }],
	     yAxes: [{
		 display: true,
		 scaleLabel: {
		     display: true,
		     labelString: "Percentage of Correct answers"
		 }
	     }]
	 }
         /*   scales:{
          *    xAxis:{scaleLabel:{display:true, labelString:"Examination Dates"}},
          *    yAxis:{scaleLabel:{display:true, labelString:"Percentage of Correct answers"}}} */
     }
 });

</script>


