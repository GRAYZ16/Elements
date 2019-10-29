<h1>Connected Devices</h1>
<?php
require(dirname(__DIR__, 1)."/config.php");
include(LIBRARY_PATH . "/sqlInterface.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT * FROM device WHERE node_id=$1;", array(1));

  foreach (pg_fetch_all($db->queryData) as $row)
  {
    echo '<div class="card" style="width: 15rem">';
    echo '<div class="card-body">';
    echo "\t<h4 class='card-title'>".  $row['mac_address'] ."</h4>";
    echo "\t<p class='card-subtitle'>". $row['device_description'] ."</p>";
    echo "\t<p class='card-text'><b>Sensors: </b>". $row['sensor_count'] ."</p>";
    echo "</div>";
    echo "</div>";
  }

 ?>