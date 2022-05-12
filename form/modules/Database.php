<?php

class Database {
  private $host;
  private $username;
  private $password;
  private $db_name;
  private $table_name;

  public function __construct($host, $username, $password, $db_name, $table_name) {
    $this->$host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->db_name = $db_name;
    $this->table_name = $table_name;

    $this->create_table();
  }

  private function create_table() {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
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

  public function save_data($data) {
    $sql = "INSERT INTO $this->table_name (deleted,fname,lname,email,tel,subject,payment,mailing,created_at,ip) 
    VALUES ($data[0],'$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]',$data[7],'$data[8]','$data[9]');";
    $this->connect()->query($sql);
  }


  public function delete_data($id) {
    $sql = "UPDATE $this->table_name SET deleted=1 WHERE id=$id;";
    $this->connect()->query($sql);
  }

  public function get_data() {
    $sql = "SELECT * FROM $this->table_name WHERE deleted != 1;";
    $result = $this->connect()->query($sql);
    $data = array();

    while($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    return $data;
  }
}