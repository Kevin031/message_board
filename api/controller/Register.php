<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/21
 * Time: 12:56 AM
 */

namespace Core\Feature;

use Core\Base\BaseController;
use Core\Base\Request;
use Core\Base\Database;
use Core\Base\JsonResponse;
use PDOException;

class Register extends BaseController {
  /**
   * Register constructor.
   */
  function __construct() {
    $data = Request::post_data();
    $this->input = array(
      'username' => $data['username'],
      'email'    => $data['email'],
      'password' => $data['password']
    );
  }

  /**
   * @var array
   */
  protected $required_fields = ['username', 'email', 'password'];

  /*
   * feature entry
   */
  public function handleRegister() {
    $this->inputCheck();

    try {
      // create link
      $connect = new Database('user');

      // create table
      $connect->setTable("CREATE TABLE user (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(60) NOT NULL,
        password VARCHAR(60) NOT NULL
      )");

      // check duplicate
      if ($connect->checkDuplicate('username', $this->input['username'])) {
        JsonResponse::requestErrorField('username', 'username already exists');
      } else if ($connect->checkDuplicate('email', $this->input['email'])) {
        JsonResponse::requestErrorField('email', 'email already exists');
      }

      // insert data
      $this->insertData($connect->pdo_connect);
      JsonResponse::requestSuccess($this->input);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  /**
   * check input valid
   */
  private function inputCheck() {
    // required fields valid
    $required_valid = $this->check_required($this->input, $this->required_fields);
    if (!$required_valid['res']) {
      JsonResponse::requestError('missing required field ' . $required_valid['field']);
    }
    // email valid
    if (!preg_match("/([\w\-]+@[\w\-]+\.[\w\-]+)/", $this->input['email'])) {
      JsonResponse::requestErrorField('email', 'Invalid email');
    }
    // password valid
    if (strlen($this->input['password']) < 6 || strlen($this->input['password']) > 16) {
      JsonResponse::requestErrorField('password', 'Please enter a 6-16-bit password');
    }
  }

  /**
   * @param $connect PDO object
   */
  private function insertData ($connect) {
    $stmt = $connect->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute(array(
      ':username' => $this->input['username'],
      ':email' => $this->input['email'],
      ':password' => $this->input['password']
    ));
  }
}
