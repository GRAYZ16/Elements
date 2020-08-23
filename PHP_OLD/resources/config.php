<?php
/*
  Configuration file for the Elements Web-Server. This file and its directory
  should be placed outside the apache base directory when used in production.
  For ease of use, it is included as a subdirectory to ease development
*/

$config = array(
  "db" => array(
    "dbname" => "elements",
    "username" => "elements",
    "password" => "elements14",
    "host" => "localhost"
  ),
  "paths" => array(
      "resources" => $_SERVER["DOCUMENT_ROOT"] . "/resources",
      "images" =>array(
        "content" => $_SERVER["DOCUMENT_ROOT"] . "/img/content",
        "layout" => $_SERVER["DOCUMENT_ROOT"] . "/img/layout")
  )
);

defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("NODE_ID")
    or define("NODE_ID", "1");

/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);
