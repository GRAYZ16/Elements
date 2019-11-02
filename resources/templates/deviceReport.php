<?php
  require(dirname(__DIR__, 1)."/config.php");
  include(LIBRARY_PATH . "/sqlInterface.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT * FROM device WHERE mac_address=$1;", array($_GET['addr']));

  $deviceMeta = $db->queryData[0];

  echo '<h1>' . $deviceMeta['device_name'] .  ' <small class="text-muted">(' . $deviceMeta['mac_address'] . ')</small>' . '</h1>';
  ?>
  <h2>Device Description</h2>
  <p><?php echo $deviceMeta['device_description']?> </p>
  <h2>Recent Recordings</h2>

  <?php
    $db->queryParams("SELECT datetime, index, value FROM data WHERE mac_address=$1 LIMIT 10;", array($_GET['addr']));
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
  <p>GRAPHS HERE</p> 
