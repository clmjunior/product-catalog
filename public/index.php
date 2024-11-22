<?php
use app\routes\Router;

header('Content-type: text/html; charset=UTF-8');

require "../vendor/autoload.php";

Router::execute();



