<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
          [{v:'Mike', f:'Mr Lombe Paul Okpara<div style="color:red; font-style:italic">(CEO)</div>'},
           '', 'The President'],
          [{v:'Jim', f:'Mr Nicholas Mungo<div style="color:red; font-style:italic">General Manager</div>'},
           'Mike', 'VP'],         
           ['Isac Zulu<div style="color:red; font-style:italic">Service Delivery Manager</div>', 'Jim', ''],
            ['Priscilla Zingoni<div style="color:red; font-style:italic">Commercial Manager</div>', 'Jim', ''],
            ['Jimmy Mashinkila<div style="color:red; font-style:italic">Business Development Manager</div>', 'Jim', ''],
            ['Chris Kamtumwa<div style="color:red; font-style:italic">Innovation Manager</div>', 'Mike', ''],
            ['Brian Chanda<div style="color:red; font-style:italic">Sales Manager</div>', 'Jim', ''],
            ['Monica Okpara<div style="color:red; font-style:italic">Admin and Finance Manager</div>', 'Mike', ''],
            ['Vanwick Zulu<div style="color:red; font-style:italic">Media</div>', 'Mike', '']
        ]);

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
        
      }
   </script>
    </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>
