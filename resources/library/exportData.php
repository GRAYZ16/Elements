<?php

  require(dirname(__DIR__, 1)."/config.php");
  include(LIBRARY_PATH . "/sqlInterface.php");
  include(LIBRARY_PATH . "/downloadFunctions.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  $db->queryParams("SELECT datetime, value, index FROM data WHERE mac_address=$1;", array($_GET['addr']));

  arrayToCSV($db->queryData);
  exit();
