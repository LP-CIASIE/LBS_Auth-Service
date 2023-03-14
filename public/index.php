<?php

require_once "../src/vendor/autoload.php";

$c = new \MongoDB\Client("mongodb://mongo:27017");
$db = $c->catalogue;
$sandwichesDb = $db->sandwiches;