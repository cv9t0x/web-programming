<?php

include "./modules/Database.php";

function clean_input($value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}

class Form {
  private $user_data;
  private $database;

  public function __construct() {
    $this->user_data = array(
      "deleted" => 0,
      "fname" => "",
      "lname" => "",
      "email" => "",
      "telephone" => "",
      "topic" => "business",
      "payment" => "webmoney",
      "receiveEmail" => 1,
    );
    $this->database = new Database(
      'localhost',
      'cv9t',
      'qwerty123',
      'form_db'
    );
  }

  private function fill($data) {
    $this->user_data["fname"] = clean_input($data["fname"]);
    $this->user_data["lname"] = clean_input($data["lname"]);
    $this->user_data["email"] = clean_input($data["email"]);
    $this->user_data["telephone"] = clean_input($data["telephone"]);
    $this->user_data["topic"] = $data["topic"];
    $this->user_data["payment"] = $data["payment"];
    $this->user_data["receiveEmail"] = $data["receiveEmail"] === "yes";
    $this->user_data[] = date("Y-m-d H:i:s");
    $this->user_data[] = $_SERVER['REMOTE_ADDR'];
  }

  private function save() {
    $temp = [];
    foreach($this->user_data as $key => $value) {
      $temp[] = $value;
    }
    $this->database->saveData($temp);
  }

  public function submit($data) {
    $this->fill($data);
    if(!$this->is_error()) {
      $this->save();
    }
  }

  public function delete($indexes) {
    foreach($indexes as $key => $value) {
      $this->database->deleteData($key);
    }
  }

  public function get() {
    return $this->database->getData();
  }

  public function is_post() {
    return $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST);
  }

  public function is_invalid($field) {
    return $this->is_post() && empty($this->user_data[$field]);
  }

  public function is_error() {
    if($this->is_post()) {
      foreach($this->user_data as $key => $value) {
        if($this->is_invalid($key) && $key != "deleted") {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

  public function get_value($field) {
    return $this->user_data[$field] ?? "";
  }
}