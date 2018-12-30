<?php
namespace Core\Base;

class JsonResponse {

  /**
   * @param $data response data
   */
  static public function requestSuccess ($data) {
    $return = array(
      'status' => 'success',
      'data' => $data,
      'message' => 'success'
    );
    echo json_encode($return);
    die;
  }

  /**
   * @param $field error field
   * @param $msg prompt msg
   */
  static public function requestErrorField ($field = null, $msg) {
    $return = array(
      'status' => 'error',
      'data' => array(
        'field' => $field,
        'message' => $msg
      ),
      'message' => 'error'
    );
    echo json_encode($return);
    die;
  }

  /**
   * @param $field error field
   * @param $msg prompt msg
   */
  static public function requestError ($msg) {
    $return = array(
      'status' => 'error',
      'message' => $msg
    );
    echo json_encode($return);
    die;
  }
}
