<?php

class dbh
{
  protected $conn;
  protected $dsn;
  protected $user;
  protected $pass;

  public function __construct()
  {
    $this->dsn = 'mysql:host=localhost;dbname=participant_db;charset=UTF8';
    $this->user = 'cv9t';
    $this->pass = 'qwerty123';
  }

  protected function connect()
  {
    try {
      $this->conn = new PDO($this->dsn, $this->user, $this->pass);
    } catch (PDOException $e) {
      die('Failed to connect: ' . $e->getMessage());
    }
    return $this->conn;
  }

  protected function disconnect()
  {
    $this->conn = null;
  }

  protected function query($sql)
  {
    $res = NULL;
    try {
      $res = $this->conn->query($sql);
    } catch (PDOException $e) {
      die('Failed to query: ' . $e->getMessage());
    }
    $this->disconnect();
    return $res;
  }
}