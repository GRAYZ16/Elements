<?php
    require_once("./resources/config.php");
    require_once(LIBRARY_PATH . "/templateFunctions.php");

    $page = $_GET['page'] ?? "home";


    renderLayoutWithContentFile($page . ".php");
