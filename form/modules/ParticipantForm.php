<?php

include_once './helpers/cleanInput.php';
include_once './helpers/convertToArr.php';
include_once './modules/Participant.php';
include_once './modules/Form.php';

class ParticipantForm extends Form
{
  private $data;
  private $transportLayer;

  public function __construct()
  {
    $this->data = array(
      "deleted" => 0,
      "fname" => "",
      "lname" => "",
      "email" => "",
      "tel" => "",
      "subject" => "business",
      "payment" => "webmoney",
      "mailing" => 1,
    );
    $this->transportLayer = new Participant();
  }

  private function fill($data)
  {
    $this->data["fname"] = cleanInput($data["fname"]);
    $this->data["lname"] = cleanInput($data["lname"]);
    $this->data["email"] = cleanInput($data["email"]);
    $this->data["tel"] = cleanInput($data["telephone"]);
    $this->data["subject"] = $data["subject"];
    $this->data["payment"] = $data["payment"];
    $this->data["mailing"] = $data["mailing"] == "1" ? 1 : 0;
    $this->data[] = date("Y-m-d");
    $this->data[] = $_SERVER['REMOTE_ADDR'];
  }

  public function isError()
  {
    if ($this->isPost()) {
      foreach ($this->data as $key => $value) {
        if ($this->isInvalid($key) && $key != "deleted" && $key != "mailing") {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

  public function isInvalid($field)
  {
    return $this->isPost() && empty($this->data[$field]);
  }

  public function submit($data)
  {
    $this->fill($data);
    if (!$this->isError()) {
      $this->transportLayer->save(convertToArr($this->data));
    }
  }

  public function getValue($field)
  {
    return $this->data[$field] ?? "";
  }
}