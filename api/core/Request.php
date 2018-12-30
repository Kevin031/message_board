<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/22
 * Time: 12:28 AM
 */

namespace Core\Base;

use Core\Base\RequestInterface;

class Request implements RequestInterface {

  /**
   *
   * @return mixed
   */
  static public function post_data() {
    $post_data = file_get_contents("php://input");
    return json_decode($post_data, TRUE);
  }

}
