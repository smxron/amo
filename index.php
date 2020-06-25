<?php

include_once __DIR__ . '/vendor/autoload.php';

use App\Component\Router;
session_start();

define("ROOT", dirname(__FILE__));
$router = new Router();
$router->run();