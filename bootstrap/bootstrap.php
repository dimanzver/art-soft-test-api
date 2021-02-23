<?php

spl_autoload_register(function ($class) {
    $file = preg_replace('/^App\//', '', str_replace('\\', '/', $class));
    $file = dirname(__DIR__) . '/' . $file . '.php';
    if(file_exists($file))
        include $file;
});

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/router.php';
require_once __DIR__ . '/helpers.php';
