<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/21
 * Time: 12:28 AM
 */

$config = array(
  '/api/register' => array(
    'file'      => '/controller/Register.php',
    'class_name'=> 'Core\Feature\Register',
    'method'    => 'handleRegister'
  ),
  '/api/login' => array(
    'file'       => '/controller/Login.php',
    'class_name' => 'Core\Feature\Login',
    'method'     => 'handleLogin'
  )
);

return $config;
