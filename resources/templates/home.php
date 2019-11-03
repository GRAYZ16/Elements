<!-- content -->
<head>
  <meta charset="utf-8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="https://cdn.rawgit.com/eligrey/canvas-toBlob.js/master/canvas-toBlob.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>

  <h2 id="deviceName"> Device Name </h2>
  <body>
  </body>


  <div id = "c1" style="display: none; width:50%; float:left;">
    <canvas id="mycanvas1"></canvas>
    <button id="save1" type="button">Save</button>
    <button id="line1" type="button">Line Graph</button>
    <button id="bar1" type="button">Bar Graph</button>

  </div>


  <div id = "c2" style="display: none; width:50%; float:right;">
    <canvas id="mycanvas2"></canvas>
    <button id="save2" type="button">Save</button>
    <button id="line2" type="button">Line Graph</button>
    <button id="bar2" type="button">Bar Graph</button>
  </div>

  <div id = "c3" style="display: none; width:50%; float:left;">
    <canvas id="mycanvas3"></canvas>
    <button id="save3" type="button">Save</button>
    <button id="line3" type="button">Line Graph</button>
    <button id="bar3" type="button">Bar Graph</button>
  </div>

    <div id = "c4" style="display: none; width:50%; float:right;">
      <canvas id="mycanvas4"></canvas>
      <button id="save4" type="button">Save</button>
      <button id="line4" type="button">Line Graph</button>
      <button id="bar4" type="button">Bar Graph</button>
    </div>

</head>

<?php
require(dirname(__DIR__, 1)."/config.php");
include(LIBRARY_PATH . "/sqlInterface.php");
//require_once(LIBRARY_PATH . "/getSensor.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT value FROM data WHERE index=$1 LIMIT 10;", array(1));
  //print_r($db->queryData);

  // Controls what device to show!
  $addr = 'dc:4f:22:1d:a6:ce';


  $db->queryParams("SELECT device_name, sensor_count FROM device WHERE mac_address=$1;", array($addr));

  $sensorCount = $db->queryData[0]["sensor_count"];
  $sensorName = $db->queryData[0]["device_name"];

// For each sensor in the device mac adress loop through (generate this many graphs)
  for ($i = 0; $i <= $sensorCount-1; $i++){

    // SELECT date time and value from data for sensor (loops through each sensor)
    $db->queryParams("SELECT datetime, value  FROM data WHERE mac_address=$1 AND index = $i;", array($addr));


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
document.getElementById("deviceName").innerHTML = sensorName;

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
