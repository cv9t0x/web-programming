<?php

class Form
{
  public function isPost()
  {
    return $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST);
  }
}