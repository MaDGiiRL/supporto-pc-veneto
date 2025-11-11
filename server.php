<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$public = __DIR__ . '/public';
$file = $public . $uri;

if ($uri !== '/' && file_exists($file) && is_file($file)) {
    return readfile($file);
}
require $public . '/index.php';
