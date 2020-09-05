<?php

define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
// echo "_SERVER['SCRIPT_NAME']:    " . $_SERVER["SCRIPT_NAME"] . "<br>";
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
require(ROOT . 'Config/core.php');
// echo "WEBROOT: " . WEBROOT . "<br>ROOT:  " . ROOT;
require(ROOT . 'router.php');
require(ROOT . 'request.php');
require(ROOT . 'dispatcher.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();

?>