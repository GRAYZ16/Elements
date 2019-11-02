<?php

    function getDevice($addr)
    {
      require(dirname(__DIR__, 1)."/config.php");
      include(LIBRARY_PATH . "/sqlInterface.php");

      $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
      $db->connect();
      $db->queryParams("SELECT * FROM device WHERE mac_address=$1;", array($addr));

      echo '<p><b> Device Name: </b>' . $db->queryData[0]['device_name'] . "</p>";
      echo '<p><b> Device Description: </b>' . $db->queryData[0]['device_description'] . "</p>";
      echo '<p><b> Number of Sensors: </b>' . $db->queryData[0]['sensor_count'] . "</p>";
      echo '<p><b> Elements Node: </b>' . $db->queryData[0]['node_id'] . "</p>";

      $db->queryParams("SELECT COUNT(*) FROM data WHERE mac_address=$1;", array($addr));
      echo '<p><b> Number of Database Records: </b>' . $db->queryData[0]['count'] . "</p>";
    }
