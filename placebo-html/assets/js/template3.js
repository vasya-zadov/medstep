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
          ['Capacity', 'Percentage'],
          ['In-Patient', 37],
          ['Out-Patient', 43],
          ['Other', 20],
        ]);

      var options = {
          pieHole: 0.3,
          legend: 'none',
          fontName: "Merriweather,sans-serif",
          backgroundColor: 'transparent',
          pieSliceTextStyle: {
            color: '#fff',
          },

          slices: {
            0: { color: '#2184df' },
            1: { color: '#e91c2d'},
            2: { color: '#80b335', tooltip: { trigger: 'none' } }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart4'));
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
    }