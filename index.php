<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('STATE_COMPLETED', 'completed');
define('STATE_ACTIVE', 'active');

define('COLUMN_ID', 'id');
define('COLUMN_NAME', 'username');
define('COLUMN_EMAIL', 'email');
define('COLUMN_STATE', 'state');
define('DIR_ASCEND', 'ASC');
define('DIR_DESCEND', 'DESC');
define('ITEMS_PER_PAGE', 3);

define('COOKIE_LIFETIME', 31536000);

define('FIELD_REQUIRED', 'Fields can not be empty.');

define('debug', false);

require 'app/lib/AutoLoader.php';

//=================================================

$router = new \app\lib\Router();
$router->start();