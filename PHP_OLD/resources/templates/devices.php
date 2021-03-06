<h1>Connected Devices</h1>
<div class='card-container'>
<?php
require(dirname(__DIR__, 1)."/config.php");
include(LIBRARY_PATH . "/sqlInterface.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT * FROM device WHERE node_id=$1;", array(1));

  $deviceData = $db->queryData;


  foreach ($deviceData as $row)
  {
    echo '<div id="' . $row['device_name'] . '"class="card" data-toggle="modal" data-target="#infoModal" data-source="#' . $row['device_name'] . '"style="width: 15rem">';
    echo '<div class="card-body">';
    echo "\t<h4 class='card-title overflow'>".  $row['device_name'] ."</h4>";
    echo "\t<p class='card-subtitle'>". $row['mac_address'] ."</p>";
    echo "\t<p class='card-text overflow device-description'>". $row['device_description'] ."</p>";
    echo "\t<p class='card-text'><b>Sensors: </b>". $row['sensor_count'] ."</p>";

    $db->queryParams(  "select datetime from (select mac_address, datetime, row_number() over(partition by mac_address order by datetime desc) as rn from data) t where t.rn = 1 AND mac_address=$1;"
      , array($row['mac_address']));

    $date = strtotime($db->queryData[0]['datetime']);

    if($date > strtotime('-1 day', strtotime(date('Y-m-d H:i:s.u'))) && ! is_null($db->queryData[0]['datetime']))
    {
      echo '<span style="color: transparent;  text-shadow: 0 0 0 lightgreen; ">&#9899;</span>';
    }
    else
    {
      echo '<span style="color: transparent;  text-shadow: 0 0 0 darkred; ">&#9899;</span>';
    }

    echo "</div>";
    echo "</div>";
  }

 ?>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Device Info</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div id="infoModalContent" class="modal-body">
      ...
    </div>
    <div class="modal-footer">
      <a href="# "role="button" id='btnReport' class="btn btn-primary">Device Report</a>
      <a href="# "role="button" id='btnExport' class="btn btn-primary">Export Data</a>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
<script src="./js/deviceClicked.js" charset="utf-8"></script>
