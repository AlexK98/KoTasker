<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('debug', false);

require_once 'app/config/_defines.php';
require 'app/lib/AutoLoader.php';

//=================================================

$router = new \app\lib\Router();
$router->start();