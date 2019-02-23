<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'admin') {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<!--
This is diagnosis page report
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        ?>
        
        
        
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Diagnosis', 'Percentage'],
          ["Default", 100],
          ["Flu (influenza) symptoms", 80],
          ["Allergy symptoms", 45],
          ["Malaise and fatigue", 50],
          ['Back pain', 55],
          ['Cold symptoms', 65],
          ['HIV symptoms', 35],
          ['STD symptoms (men)', 40],
          ['STD symptoms (women)', 25],
          ['Swollen Eyes', 35],
          ['Pregnancy symptoms', 60]
        ]);

        var options = {
          title: 'Diagnosis',
          width: 750,
          legend: { position: 'none' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          bar: { groupWidth: "50%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
        
    </head>
    <body onload="myFunction()">
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2"></div>

                <div class="panel panel-default col-lg-8" style="border: solid; margin-top: 0px">
                    <div class="panel-body">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">Diagnosis Bar Chart Report</h4>
                        </div>
                        <p></p>
                        <div id="top_x_div" style="width: 50%; height: 300px;"></div>
                        <br>
                        <br>
                  </div>
                </div>
            </div>
         </div>
        
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </body>
    </body>
</html>
