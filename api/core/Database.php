<?php

namespace Core\Base;

use PDO;

class Database {

  private $hostname = '127.0.0.1';
  private $username = 'root';
  private $password = 'root';
  private $dbname = 'phpstudio';

  /**
   * Database constructor.
   */
  function __construct($table) {
    $connect = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo_connect = $connect;
    $this->table = $table;
  }

  /**
   * Database destruct
   */
  function __destruct() {
    $this->pdo_connect = NULL;
  }

  /**
   * 创建数据表
   * @param $sql
   */
  public function create_database($sql) {
    $this->pdo_connect->exec($sql);
  }

  /**
   * 检查是否存在表
   * @param $table_name
   * @return bool
   */
  public function setTable($sql) {
    $tables = $this->pdo_connect
      ->query("SHOW TABLES")
      ->fetchAll(PDO::FETCH_GROUP);
    if(!in_array($this->table, array_keys($tables))) {
      $this->create_database($sql);
    }
  }

  /**
   * 暴露query方法
   * @param $sql
   * @return mixed
   */
  public function query($sql) {
    return $this->pdo_connect->query($sql);
  }

  /**
   * 暴露prepare方法
   * @param $sql
   * @return mixed
   */
  public function prepare($sql) {
    return $this->pdo_connect->prepare($sql);
  }

  /**
   * @param $name 列名
   * @param $value 比对值
   * @return bool 是否重复
   */
  public function checkDuplicate ($col, $value) {
    $sql = "SELECT $col FROM $this->table";
    $result = $this->pdo_connect->query($sql)->fetchAll();
    $target_list = array_column($result, $col);
    return in_array($value,  $target_list);
  }

}
