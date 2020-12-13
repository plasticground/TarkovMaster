<?php

use App\Models\Request;
use App\Services\RedirectService;

require_once "vendor/autoload.php";
require_once "_helper.php";


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

session_start();

$request = [
    'post' => $_POST,
    'get' => $_GET,
    'server' => $_SERVER,
    'session' => $_SESSION,
    'cookie' => $_COOKIE,
    'env' => $_ENV,
    'files' => $_FILES,
    'request' => $_REQUEST,
];

$request = new Request($request, $_SERVER['REQUEST_METHOD']);

//$debug = new \App\Services\DebugWindow($request);
//$debug->print();

$RS = new RedirectService($uri, $request);
$RS->start();

//$debug = new \App\Services\DebugWindow($request);
//$debug->print();

