<?php
    require_once("./resources/config.php");
    require_once(LIBRARY_PATH . "/templateFunctions.php");

    $page = $_GET['page'] ?? "home";
    $request = $_GET['request'] ?? "None";

    switch ($request) {
      case 'getDevice':
        require_once(LIBRARY_PATH . "/getDevice.php");
        getDevice($_GET['addr']);
        break;

      case 'export':
        require_once(LIBRARY_PATH . "/exportData.php");

      case 'None':
        renderLayoutWithContentFile($page . ".php");
        break;

      default:
        // code...
        break;
    }
