<?php
require __DIR__ . '/../vendor/autoload.php';

function getEnvironmentVariable($key) {
    Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();
    if(array_key_exists($key, $_SERVER)) {
        return $_SERVER[$key];
    }
    $var = getenv($key);
    if($var) {
        return $var;
    }
    error_log("Environment variable $key was not set.");
    return false;
}
