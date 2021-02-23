<?php

//error_reporting(E_ALL);
header('Access-Control-Request-Methods: GET, POST, OPTIONS, DELETE, PUT, PATCH');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type');

require __DIR__ . '/bootstrap/bootstrap.php';
processRoute();