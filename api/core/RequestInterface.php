<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/22
 * Time: 12:35 AM
 */

namespace Core\Base;

interface RequestInterface {

  /**
   * @return mixed
   */
  static public function post_data();
}