<?php

// Serve gli asset statici direttamente
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$publicPath = __DIR__ . '/public';
$filePath = $publicPath . $uri;

if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    return readfile($filePath);
}

// Bootstrap Laravel come fa public/index.php
require $publicPath . '/index.php';
