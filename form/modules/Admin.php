<?php

include_once './modules/dbh.php';

class Admin extends dbh
{
  public function __construct()
  {
    parent::__construct();
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