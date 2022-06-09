<?php

include_once './modules/dbh.php';

class Statistic extends dbh
{
  public function __construct()
  {
    parent::__construct();
    $this->create();
  }

  private function create()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `statistics` (
      `id` INT(10) NOT NULL AUTO_INCREMENT,
      `ip` VARCHAR(255) NOT NULL,
      `hits` INT(10) NOT NULL,
      `last_seen` DATETIME NOT NULL,
      PRIMARY KEY(`id`)
    );";
    $this->connect()->query($sql);
  }

  public function addHit($ip, $date)
  {
    $sql = "SELECT `ip` FROM `statistics` WHERE `ip`='$ip';";
    $isFound = $this->connect()->query($sql)->fetch() ?? 0;

    if ($isFound) {
      $sql = "UPDATE `statistics` SET `hits`=`hits`+1, `last_seen`='$date' WHERE `ip`='$ip';";
    } else {
      $sql = "INSERT INTO `statistics` SET `hits`=1, `last_seen`='$date', `ip`='$ip';";
    }

    $this->connect()->query($sql);
  }

  public function getNumberOfSessions()
  {
    $sql = "SELECT COUNT(`id`) FROM `statistics` WHERE `last_seen` >= DATE_SUB(NOW(), INTERVAL 2 MINUTE);";
    $res = $this->connect()->query($sql)->fetch();
    return $res[0] ?? 0;
  }

  public function getNumberOfHits()
  {
    $sql = "SELECT SUM(`hits`) FROM `statistics`";
    $res = $this->connect()->query($sql)->fetch();
    return $res[0] ?? 0;
  }

  public function getNumberOfUniqueIps()
  {
    $sql = "SELECT COUNT(`ip`) FROM `statistics`";
    $res = $this->connect()->query($sql)->fetch();
    return $res[0] ?? 0;
  }

}