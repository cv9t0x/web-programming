<?php

include_once './modules/Form.php';
include_once './modules/Admin.php';

class LoginForm extends Form
{
  private $error;
  private $transportLayer;

  public function __construct()
  {
    $this->transportLayer = new Admin();
  }

  public function isPass($data)
  {
    if (!$this->transportLayer->isAdmin($data['login'], md5($data['password']))) {
      $this->error = TRUE;
      return FALSE;
    }
    return TRUE;
  }

  public function isError()
  {
    return $this->error;
  }
}