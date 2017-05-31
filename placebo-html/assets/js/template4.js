/**
* @author dhsign
* @copyright Copyright (c) 2015 dhsign
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

    "use strict";
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['BMI', 'Normal', 'Overweight', 'Obese', { role: 'annotation' } ],
        ['BMI for 2014', 30, 36, 34, ''],
      ]);

      var options = {
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '100%' },

        colors:['#eb1c28','#2684db','#80b355'],
        fontName: "Merriweather,sans-serif",
        isStacked: true,
      };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
        function resizeHandler () {
        chart.draw(data, options);
    }
    if (window.addEventListener) {
        window.addEventListener('resize', resizeHandler, false);
    }
    else if (window.attachEvent) {
        window.attachEvent('onresize', resizeHandler);
    }
    };