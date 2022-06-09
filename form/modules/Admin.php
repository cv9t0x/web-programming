<?php

include_once './modules/dbh.php';

class Admin extends dbh
{
  public function __construct()
  {
    parent::__construct();
    $this->create();
  }

  private function create()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `admins` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `login` VARCHAR(255) NOT NULL,
      `password` VARCHAR(255) NOT NULL,
      PRIMARY KEY(`id`)
    );";

    $this->connect()->query($sql);
  }

  public function isAdmin($login, $password)
  {
    $sql = "SELECT * FROM `admins` WHERE `login`='$login' AND `password`='$password';";
    $res = $this->connect()->query($sql);
    if ($res) {
      $res = $res->fetchAll();
      return count($res) > 0;
    } else {
      return FALSE;
    }
  }
}