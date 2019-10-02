<!-- content -->
<h2> Welcome to the Home Page of the Elements Dashboard </h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<?php
require(dirname(__DIR__, 1)."/config.php");
include(LIBRARY_PATH . "/sqlInterface.php");

if(isset($config))
{
  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();
  echo "<p>" . pg_fetch_result($db->query("SELECT version();"),0,0) . "</p>";
}

 ?>
