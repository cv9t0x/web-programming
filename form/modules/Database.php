<?php

class Database {
  private $host;
  private $username;
  private $password;
  private $db_name;

  public function __construct($host, $username, $password, $db_name) {
    $this->$host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->db_name = $db_name;
    $this->create();
  }

  private function create() {
    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
      `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
      `fname` VARCHAR(255) NOT NULL,
      `lname` VARCHAR(255) NOT NULL,
      `email` VARCHAR(255) NOT NULL,
      `tel` VARCHAR(255) NOT NULL,
      `subject` VARCHAR(255) NOT NULL,
      `payment` VARCHAR(255) NOT NULL,
      `mailing` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
      `created_at` TIMESTAMP NOT NULL,
      `ip` VARCHAR(255) NOT NULL,
      PRIMARY KEY(`id`)
    );";
    $this->connect()->query($sql);
  }

  private function connect() {
    $conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
    return $conn;
  }

  public function saveData($data) {
    $sql = "INSERT INTO participants (deleted,fname,lname,email,tel,subject,payment,mailing,created_at,ip) 
    VALUES ($data[0],'$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]',$data[7],'$data[8]','$data[9]');";
    $this->connect()->query($sql);
  }

  public function getData() {
    $sql = "SELECT * FROM participants WHERE deleted != 1;";
    $result = $this->connect()->query($sql);
    $data = array();

    while($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
        
    return $data;
  }

  public function deleteData($id) {
    $sql = "UPDATE participants SET deleted=1 WHERE id=$id;";
    $this->connect()->query($sql);
  }
}