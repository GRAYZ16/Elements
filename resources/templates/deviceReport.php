

<?php
  require(dirname(__DIR__, 1)."/config.php");
  include(LIBRARY_PATH . "/sqlInterface.php");

  $addr = $_GET['addr'];

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT * FROM device WHERE mac_address=$1;", array($addr));

  $deviceMeta = $db->queryData[0];

  echo '<h1>' . $deviceMeta['device_name'] .  ' <small class="text-muted">(' . $deviceMeta['mac_address'] . ')</small>' . '</h1>';
  ?>
  <h2>Device Description</h2>
  <p><?php echo $deviceMeta['device_description']?> </p>
  <h2>Recent Recordings</h2>

  <?php
    $db->queryParams("SELECT datetime, index, value FROM data WHERE mac_address=$1 LIMIT 10;", array($addr));
    $recordings = $db->queryData;
    ?>
    <table class='table table-sm table-responsive-sm table-bordered table-hover table-striped'>
      <tr>
        <th>Timestamp</th>
        <th>Index</th>
        <th>Value</th>
      </tr>
    <?php
    echo "<tbody>";
    foreach ($recordings as $row)
    {
      echo '<tr>';
      echo '<td>' . $row['datetime'] . '</td>';
      echo '<td>' . $row['index'] . '</td>';
      echo '<td>' . $row['value'] . '</td>';
      echo "</tr>";
    }

    echo "</tbody>";
    ?>
  </table>
  <h2>Metrics</h2>

  <div id = "c1" style="display: none; width:50%; float:left;">
    <canvas id="mycanvas1"></canvas>
    <button id="save1" class="btn btn-primary" type="button">Save</button>
    <button id="line1" class="btn btn-secondary" type="button">Line Graph</button>
    <button id="bar1" class="btn btn-secondary" type="button">Bar Graph</button>

  </div>

  <div id = "c2" style="display: none; width:50%; float:right;">
    <canvas id="mycanvas2"></canvas>
    <button id="save2" class="btn btn-primary" type="button">Save</button>
    <button id="line2" class="btn btn-secondary" type="button">Line Graph</button>
    <button id="bar2" class="btn btn-secondary" type="button">Bar Graph</button>
  </div>

  <div id = "c3" style="display: none; width:50%; float:left;">
    <canvas id="mycanvas3"></canvas>
    <button id="save3" class="btn btn-primary" type="button">Save</button>
    <button id="line3" class="btn btn-secondary" type="button">Line Graph</button>
    <button id="bar3" class="btn btn-secondary" type="button">Bar Graph</button>
  </div>

    <div id = "c4" style="display: none; width:50%; float:right;">
      <canvas id="mycanvas4"></canvas>
      <button id="save4" class="btn btn-primary" type="button">Save</button>
      <button id="line4" class="btn btn-secondary" type="button">Line Graph</button>
      <button id="bar4" class="btn btn-secondary" type="button">Bar Graph</button>
    </div>

<?php

  $db->queryParams("SELECT device_name, sensor_count FROM device WHERE mac_address=$1;", array($addr));

  $sensorCount = $db->queryData[0]["sensor_count"];
  $sensorName = $db->queryData[0]["device_name"];

// For each sensor in the device mac adress loop through (generate this many graphs)
  for ($i = 0; $i <= $sensorCount-1; $i++){

    // SELECT date time and value from data for sensor (loops through each sensor)
    $db->queryParams("SELECT datetime, value  FROM data WHERE mac_address=$1 AND index = $2;", array($addr, $i));


    // Encode into $myJSON json format
    $myJSON[$i] = json_encode($db->queryData);
    //print_r($db->queryData[0]);
  };
 ?>



<script>
// Setup Number of sensors for a device
var sensorLength = <?php echo $sensorCount ?>;

// Setup Device Name of Page
var sensorName = <?php echo "'$sensorName'" ?>;

// Loop for however many sensors the device has
 for (var i = 0; i < sensorLength+1; i++){
   // For first sensor, draw graph/setup data
   if (i == 1){
     var ar = <?php if ($sensorCount >= 1)
                    {
                      echo $myJSON[0];
                    }
                    else {
                      echo 0;
                    }
                    ?>;
     var arrayLength = ar.length;
     // Format datetime
     for (var j = 0; j < arrayLength; j++) {
        ar[j].datetime = ar[j].datetime.split(".")[0];
      }

      // Create initial empty chart
      var ctx_live = document.getElementById("mycanvas1");

      var chart1 = document.getElementById("c1");
      chart1.style.display = 'block';


      var config = {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          data: [],
          borderWidth: 1,
          borderColor:'#00c0ef',
          label: 'liveCount',
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: "Sensor 1",
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [ {
    display: true,
    scaleLabel: {
      display: true,
      labelString: 'value'
    }
  } ]
        }
      }
    };
      var canvas = $('#mycanvas1').get(0);
      var myChart = new Chart(ctx_live, config);

        // Listener for line and bar graph buttons
        $("#line1").click(function(){
          change('line');
        });

        $("#bar1").click(function(){
          change('bar');
        });

        // Changes Graph Plot Type
        function change(newType) {
          var ctx = document.getElementById("mycanvas1");

          // Remove the old chart and all its event handles
          if (myChart) {
            myChart.destroy();
          }

          // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
          var temp = jQuery.extend(true, {}, config);
          temp.type = newType;
          myChart = new Chart(ctx, temp);
          };


      // save as image
      $("#save1").click(function() {
        $("#mycanvas1").get(0).toBlob(function(blob) {
          saveAs(blob, "chart_1");
        });
      });


      // logic to get new data
      var getData = function() {
          for (var i = 0; i < arrayLength; i++) {
            // add new label and data point to chart's underlying data structures
            myChart.data.labels.push(ar[i].datetime);
            myChart.data.datasets[0].data.push(ar[i].value);
          }
          // re-render the chart
          myChart.update();
      };
      getData();
   }

   else if (i == 2){
     var ar2 = <?php if ($sensorCount >= 2)
                    {echo $myJSON[1];
                    }
                    else {
                      echo 0;
                    }
                    ?>;
     var arrayLength2 = ar2.length;

     for (var j = 0; j < arrayLength2; j++) {
       ar2[j].datetime = ar2[j].datetime.split(".")[0];
      }

      // create initial empty chart
      var ctx_live = document.getElementById("mycanvas2");
      var chart2 = document.getElementById("c2");
      chart2.style.display = 'block';

      var config2 = {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          data: [],
          borderWidth: 1,
          borderColor:'#00c0ef',
          label: 'liveCount',
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: "Sensor 2",
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [ {
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'value'
            }
          } ]
        }
      }
    };

      var myChart2 = new Chart(ctx_live, config2);
      var canvas = $('#mycanvas2').get(0);

        // Listener for line and bar graph buttons
        $("#line2").click(function(){
          change('line');
        });

        $("#bar2").click(function(){
          change('bar');
        });

        // Changes Graph Plot Type
        function change(newType) {
          var ctx = document.getElementById("mycanvas2");

          // Remove the old chart and all its event handles
          if (myChart2) {
            myChart2.destroy();
          }

          // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
          var temp = jQuery.extend(true, {}, config2);
          temp.type = newType;
          myChart2 = new Chart(ctx, temp);
          };


      // save as image
      $("#save2").click(function() {
        $("#mycanvas2").get(0).toBlob(function(blob) {
          saveAs(blob, "chart_2");
        });
      });

      // logic to get new data
      var getData = function() {
          for (var i = 0; i < arrayLength2; i++) {
            // add new label and data point to chart's underlying data structures
            myChart2.data.labels.push(ar2[i].datetime);
            myChart2.data.datasets[0].data.push(ar2[i].value);
          }
          // re-render the chart
          myChart2.update();
      };
      getData();
   }

   else if (i == 3){
       var ar3 = <?php if ($sensorCount >= 3)
                      {echo $myJSON[2];
                      }
                      else {
                        echo 0;
                      }
                      ?>;
      var arrayLength3 = ar3.length;

      for (var j = 0; j < arrayLength3; j++) {
        ar3[j].datetime = ar3[j].datetime.split(".")[0];
       }

       // create initial empty chart
       var ctx_live = document.getElementById("mycanvas3");

       var chart3 = document.getElementById("c3");
       chart3.style.display = 'block';

       var config3 = {
       type: 'bar',
       data: {
         labels: [],
         datasets: [{
           data: [],
           borderWidth: 1,
           borderColor:'#00c0ef',
           label: 'liveCount',
         }]
       },
       options: {
         responsive: true,
         title: {
           display: true,
           text: "Sensor 3",
         },
         legend: {
           display: false
         },
         scales: {
           yAxes: [ {
             display: true,
             scaleLabel: {
               display: true,
               labelString: 'value'
             }
           } ]
         }
       }
     };

       var myChart3 = new Chart(ctx_live, config3);
       var canvas = $('#mycanvas3').get(0);

         // Listener for line and bar graph buttons
         $("#line3").click(function(){
           change('line');
         });

         $("#bar3").click(function(){
           change('bar');
         });

         // Changes Graph Plot Type
         function change(newType) {
           var ctx = document.getElementById("mycanvas3");

           // Remove the old chart and all its event handles
           if (myChart3) {
             myChart3.destroy();
           }

           // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
           var temp = jQuery.extend(true, {}, config3);
           temp.type = newType;
           myChart3 = new Chart(ctx, temp);
           };
           // save as image
      $("#save3").click(function() {
        $("#mycanvas3").get(0).toBlob(function(blob) {
          saveAs(blob, "chart_3");
        });
      });

       // logic to get new data
       var getData = function() {
           for (var i = 0; i < arrayLength3; i++) {
             // add new label and data point to chart's underlying data structures
             myChart3.data.labels.push(ar3[i].datetime);
             myChart3.data.datasets[0].data.push(ar3[i].value);
           }
           // re-render the chart
           myChart3.update();
       };
       getData();

   }

   else if (i == 4){
       var ar4 = <?php if ($sensorCount >= 4)
                      {echo $myJSON[3];
                      }
                      else {
                        echo 0;
                      }
                      ?>;
      var arrayLength4 = ar4.length;

      for (var j = 0; j < arrayLength4; j++) {
        ar4[j].datetime = ar4[j].datetime.split(".")[0];
       }

       // create initial empty chart
       var ctx_live = document.getElementById("mycanvas4");

       var chart3 = document.getElementById("c4");
       chart3.style.display = 'block';

       var config2 = {
       type: 'bar',
       data: {
         labels: [],
         datasets: [{
           data: [],
           borderWidth: 1,
           borderColor:'#00c0ef',
           label: 'liveCount',
         }]
       },
       options: {
         responsive: true,
         title: {
           display: true,
           text: "Sensor 4",
         },
         legend: {
           display: false
         },
         scales: {
           yAxes: [ {
             display: true,
             scaleLabel: {
               display: true,
               labelString: 'value'
             }
           } ]
         }
       }
     };

       var myChart4 = new Chart(ctx_live, config4);
       var canvas = $('#mycanvas4').get(0);

         // Listener for line and bar graph buttons
         $("#line4").click(function(){
           change('line');
         });

         $("#bar4").click(function(){
           change('bar');
         });

         // Changes Graph Plot Type
         function change(newType) {
           var ctx = document.getElementById("mycanvas4");

           // Remove the old chart and all its event handles
           if (myChart4) {
             myChart4.destroy();
           }

           // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
           var temp = jQuery.extend(true, {}, config4);
           temp.type = newType;
           myChart4 = new Chart(ctx, temp);
           };

             // save as image
        $("#save4").click(function() {
          $("#mycanvas4").get(0).toBlob(function(blob) {
            saveAs(blob, "chart_4");
          });
        });

       // logic to get new data
       var getData = function() {
           for (var i = 0; i < arrayLength4; i++) {
             // add new label and data point to chart's underlying data structures
             myChart4.data.labels.push(ar4[i].datetime);
             myChart4.data.datasets[0].data.push(ar4[i].value);
           }
           // re-render the chart
           myChart4.update();
       };
       getData();

   }
  }
</script>
