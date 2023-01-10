<?php

declare(strict_types=1);

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Socket\Upload;

define('_DIR_ROOT_', __DIR__ . '/app/');
define('_DIR_VIEW_', __DIR__ . '/app/src/View/');
define('_DIR_IMAGE_', __DIR__ . '/app/src/resources/images/');
define('_DIR_CSS_', __DIR__ . '/app/src/resources/css/');
define('_DIR_JS_', __DIR__ . '/app/src/resources/js/');
define('KEY_SESSION_USER', 'userSession');
date_default_timezone_set("Asia/Ho_Chi_Minh");
ini_set('session.gc_maxlifetime', 365 * 24 * 60 * 60);
ini_set('session.cookie_lifetime ', 999);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
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
