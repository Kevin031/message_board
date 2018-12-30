<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/22
 * Time: 12:03 PM
 */

namespace Core\Feature;

use Core\Base\BaseController;
use Core\Base\Request;
use Core\Base\Database;
use Core\Base\JsonResponse;
use PDOException;

class Login extends BaseController {

  /**
   * Login constructor.
   */
  function __construct() {
    $data = Request::post_data();
    $this->input = array(
      'user' => $data['user'],
      'password' => $data['password']
    );
    $this->valid_type = preg_match("/([\w\-]+@[\w\-]+\.[\w\-]+)/", $this->input['user'])
      ? 'email'
      : 'username';
  }

  /**
   * @var array
   */
  protected $required_fields = ['user', 'password'];

  /**
   * 入口
   */
  public function handleLogin() {
    $this->inputCheck();
    $connect = new Database('user');

    try {
      // check duplicate
      if (!$connect->checkDuplicate($this->valid_type, $this->input['user'])) {
        JsonResponse::requestError('Wrong username or password');
      }
      // check password
      if(!$this->passwordCheck($connect)) {
        JsonResponse::requestError('Wrong username or password');
      }
      // pass
      JsonResponse::requestSuccess(array(
        'token' => $this->makeCookie($connect)
      ));
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

  /**
   * 输入检查
   */
  private function inputCheck() {
    // required fields valid
    $required_valid = $this->check_required($this->input, $this->required_fields);
  }

  /**
   * 密码比对
   * @param $connect
   * @return $boolean
   */
  private function passwordCheck($connect) {
    $stmt = $connect->prepare("SELECT * FROM user WHERE $this->valid_type=(:user)");
    $stmt->execute(array(
      ':user' => $this->input['user']
    ));
    $result = $stmt->fetchAll();
    if(count($result)) {
      return $result[0]['password'] == $this->input['password'];
    } else {
      return FALSE;
    }
  }

  /**
   * 生成cookie
   * @param $connect
   * @return 
   */
  private function makeCookie($connect) {
    $connect->setTable("CREATE TABLE cookie (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      uid VARCHAR(100) NOT NULL,
      token VARCHAR(100) NOT NULL
    )");

    session_start([
      'cookie_lifetime' => 86400 // 有效期一天
    ]);
    $uid = session_id();

    $cookie_list = $connect->query("SELECT * FROM cookie")->fetchAll();
    $uid_list = array_map(function ($item) {
      return $item['uid'];
    }, $cookie_list);

    // 若已生成cookie则不需要创建新的cookie 
    if (array_search($uid, $uid_list) === FALSE) {
      $stmt = $connect->prepare("SELECT * FROM user WHERE $this->valid_type=(:user)");
      $stmt->execute(array(':user' => $this->input['user']));
      $user_info = $stmt->fetchAll();
      $token = md5($user_info[0]['username'] . $user_info[0]['password']);
      $stmt = $connect->prepare("INSERT INTO cookie (uid, token) VALUE (:uid, :token)");
      $stmt->execute(array(
        ':uid'   => $uid,
        ':token' => $token
      ));
      return $token;
    } else {
      return $cookie_list[array_search($uid, $uid_list)]['token'];
    }
  }
}