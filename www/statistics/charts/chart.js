var ctx = document.getElementById("chart").getContext('2d');
chart_question_use = Object.keys(question_use)
  .map(e => question_use[e]);
var chart = new Chart(ctx, {
  type: 'pie',

  data: {
    labels: chart_question_use.map(e => e.question),
    datasets: [{
      data: chart_question_use.map(e => e.use_count),
      backgroundColor: chart_question_use
        .map(e => e.question)
        .map(e => `rgb(${(e.charCodeAt(0) * 2) % 255}, ${(2 * e.charCodeAt(1)) % 255}, ${e.charCodeAt(2) % 255})`)
    }]
  },

  options: {
    legend: {
      display: false
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var label = data.datasets[tooltipItem.datasetIndex].label || '';
          document.getElementById('legend').innerHTML = `Question: ${data.labels[tooltipItem.index]};`;
          return `Uses: ${data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]}`;
        }
      }
    }
  }
});

var ctx2 = document.getElementById("chart2").getContext('2d');
var advanced_topic_question_count = topic_question_count.filter( e => e.level == "Advanced");
var advanced_topic_use_count = topic_use_count.filter( e => e.level == "Advanced");
var basic_topic_question_count = topic_question_count.filter( e => e.level == "Basic");
var basic_topic_use_count = topic_use_count.filter( e => e.level == "Basic");
var labels_topic_question_count = Array.from(new Set(topic_question_count.map(e => e.name)));
var chart = new Chart(ctx2, {
  type: 'bar',

  data: {
    labels: labels_topic_question_count,
    datasets: [
      {
        label: "# Advanced Questions",
        data: labels_topic_question_count.map(label => {
          let data = advanced_topic_question_count.find(e => e.name === label);
          if ( data !== undefined ){
            return parseInt(data['question_count']);
          } else {
            return 0;
          }
        }),
        backgroundColor: 'red'
      },
      {
        label: "# Advanced Usage",
        data: labels_topic_question_count.map(label => {
          let data = advanced_topic_use_count.find(e => e.name === label);
          if ( data !== undefined ){
            return parseInt(data['use_count']);
          } else {
            return 0;
          }
        }),
        backgroundColor: 'pink'
      },
      {
        label: "Basic",
        data: labels_topic_question_count.map(label => {
          let data = basic_topic_question_count.find(e => e.name === label);
          if ( data !== undefined ){
            return parseInt(data['question_count']);
          } else {
            return 0;
          }
        }),
        backgroundColor: 'blue'
      },
      {
        label: "# Basic Usage",
        data: labels_topic_question_count.map(label => {
          let data = basic_topic_use_count.find(e => e.name === label);
          if ( data !== undefined ){
            return parseInt(data['use_count']);
          } else {
            return 0;
          }
        }),
        backgroundColor: 'cyan'
      }]
  },

  options: {
    tooltips: {
      callbacks: {
      }
    }
  }
});
