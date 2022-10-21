<?php

declare(strict_types=1);
define('_DIR_ROOT_', __DIR__ . "/app/");
define("_DIR_VIEW_",__DIR__."/app/src/View/");
require_once __DIR__ . '/app/vendor/autoload.php';

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/app/public' . $uri)) {
  return false;
}

session_start();

require_once __DIR__ . '/app/public/index.php';
