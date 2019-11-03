<?php

  function getSensorDataAsJSON($macAddress, $sensorIndex, $startDatetime, $endDatetime)
  {
    require(dirname(__DIR__, 1)."/config.php");

    $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
    $db->connect();
    $db->queryParams("SELECT datetime, value  FROM data WHERE mac_address=$1 AND index = $2 AND datetime BETWEEN $3 and $4;", array($macAddress, $sensorIndex, $startDatetime, $endDatetime));
    return $db->queryData;
  }
