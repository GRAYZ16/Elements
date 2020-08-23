<h1>Settings</h1>

<?php
  require(dirname(__DIR__, 1)."/config.php");
  include(LIBRARY_PATH . "/sqlInterface.php");

  $db = new SqlInterface($config["db"]["host"], $config["db"]["dbname"], $config["db"]["username"], $config["db"]["password"]);
  $db->connect();

  if(isset($_GET))
  {
    if(!empty($_GET['device']))
    {
      $db->queryParams("DELETE FROM device WHERE mac_address=$1;", array($_GET['device']));
      echo '<p style="color: darkred" class="lead">Action Completed</p>';
    }
  }
  ?>

<span>
  <h4>Delete Device:</h4>
  <form id="delete" action="index.php" method="get">
    <select name="device" class="form-control">
      <option>Default select</option>
      <?php

      $db->queryParams("SELECT mac_address, device_name FROM device WHERE node_id=$1;", array(1));

      foreach ($db->queryData as $row)
      {
        echo '<option value="' . $row['mac_address'] . '">';
        echo $row['device_name'] . '(' . $row['mac_address'] . ')';
        echo '</option>';
      }
       ?>
    </select>
    <input style="margin-top: 10px" class='btn btn-primary' type="submit" onclick="return confirm('Are you sure you want to DELETE this device?')">
    <input type="hidden" name='page', value='settings'>
  </form>
</span>
