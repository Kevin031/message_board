<?php

/**
 * MVC路由功能的简单实现
 */

use Core\Base;
use Core\Feature;

foreach (glob('./core/*.php', GLOB_NOSORT) as $file_name) {
  include_once $file_name;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Headers: content-type');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Request-Methods: POST,GET,OPTIONS');

define('APP_PATH', trim(__DIR__));
define('BASE_PATH', dirname(__FILE__));

$root         = $_SERVER['SCRIPT_NAME'];
$request      = $_SERVER['REQUEST_URI'];
$config       = include_once BASE_PATH . '/config/config.php';
$router       = include_once BASE_PATH . '/config/router.php';
$request_path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);

// 判断是否存在路由定义
if (array_key_exists($request_path, $router)) {
  $module_file = BASE_PATH . $router[$request_path]['file'];
  $class_name  = $router[$request_path]['class_name'];
  $method_name = $router[$request_path]['method'];

//  判断是否存在文件
  if (file_exists($module_file)) {
    include($module_file);
    $object_module = new $class_name();

//    判断是否存在方法
    if (method_exists($object_module, $method_name)) {
      if (is_callable(array($object_module, $method_name))) {
        $object_module->$method_name();
      }
    } else {
      die('method not exist');
    }
  } else {
    die('file not exist');
  }
} else {
  die('page not found');
}

?>