<?php

use Mosquitto\Client;

$mid = 0;
$c = new Mosquitto\Client("PHP");
$c->onLog('var_dump');
$c->onConnect(function() use ($c, &$mid) {
    $mid = $c->publish("mgdm/test", "Hello", 2);
});

$c->onPublish(function($publishedId) use ($c, $mid) {
    if ($publishedId == $mid) {
        $c->disconnect();
    }
});

$c->connect("localhost");
$c->loopForever();

echo "Finished";
