<?php
/**
 * Created by PhpStorm.
 * User: liubin
 * Date: 2018/12/22
 * Time: 12:28 AM
 */

namespace Core\Base;


class BaseController {
  public function say() {
    echo 'hello world';
  }

  /**
   * @param $data target data
   * @param $required_keys required key array
   * @return array valid or not
   */
  public function check_required($data, $required_keys) {
    foreach ($required_keys as $key) {
      if (!array_key_exists($key, $data) || !$data[$key]) {
        return array(
          'res' => FALSE,
          'field' => $key
        );
      }
    }
    return array(
      'res' => TRUE
    );
  }
}