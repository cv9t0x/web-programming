<?php

include_once './modules/dbh.php';

class Participant extends dbh
{
  public function __construct()
  {
    parent::__construct();
    $this->create();
  }

  private function create()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
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

  public function save($data)
  {
    $sql = "INSERT INTO `participants` (`deleted`,`fname`,`lname`,`email`,`tel`,`subject`,`payment`,`mailing`,`created_at`,`ip`) 
    VALUES ($data[0],'$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]',$data[7],'$data[8]','128.0.0.1');";
    $this->connect()->query($sql);
  }

  public function delete($id)
  {
    $sql = "UPDATE `participants` SET `deleted`=1 WHERE `id`=$id;";
    $this->connect()->query($sql);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM `participants` WHERE `deleted` != 1;";
    $res = $this->connect()->query($sql)->fetchAll();
    $participants = array();

    if (count($res) > 0) {
      foreach ($res as $row) {
        $participants[] = $row;
      }
    }

    return $participants;
  }
}