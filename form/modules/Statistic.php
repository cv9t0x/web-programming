<?php

include_once './modules/dbh.php';

class Statistic extends dbh
{
  public function __construct()
  {
    parent::__construct();
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

  // public function addHit($date)
  // {
  //   $sql = "SELECT `hits` FROM `statistics` WHERE `date`='$date';";
  //   $hitsNum = count($this->connect()->query($sql)->fetchAll());

  // if ($hitsNum > 0) {
  //   $sql = "UPDATE `statistics` SET `hits`=`hits`+1 WHERE `date`='$date';";
  // } else {
  //   $sql = "INSERT INTO `statistics` SET `hits`=1, `date`='$date';";
  // }

  //   $this->connect()->query($sql);

  //   // SET `hits`=`hits`+1 
  // }

  // public function getNumberOfHitsByDate($date)
  // {
  //   $sql = "SELECT `hits` FROM `statistics` WHERE `date`='$date';";
  //   $res = $this->connect()->query($sql)->fetch();

  //   return $res['hits'];
  // }

  // public function getNumberOfUniqueIpsByDate($date)
  // {
  //   $sql = "SELECT COUNT(DISTINCT `ip`) FROM `participants` WHERE `created_at`='$date';";
  //   $res = $this->connect()->query($sql)->fetch();

  //   return $res[0];
  // }
}