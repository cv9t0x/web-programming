<?php

function is_dir_exists($path) {
  $dir = dirname($path);
  if (!is_dir($dir)){
    mkdir($dir);
    return FALSE;
  }
  return TRUE;
}

function save_to_file($path, $data, $option) {
  $out = fopen($path,  $option);
  fputcsv($out, $data);
  fclose($out);
}

function read_from_file($path, &$arr) {
  $in = fopen($path, 'r');
  while(($data = fgetcsv($in)) !== FALSE) {
    if($data[0] == 1) {
      $arr[] = array_slice($data, 1);
    }
  }
}

function clean_input($value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}

class Form {
  private $user_data;
  private static $path_to_save = "./users/users.txt";

  public function __construct() {
    $this->user_data = array();
  }

  private function create($data) {
    $this->user_data[] = 1;
    $this->user_data["fname"] = clean_input($data["fname"]);
    $this->user_data["lname"] = clean_input($data["lname"]);
    $this->user_data["email"] = clean_input($data["email"]);
    $this->user_data["telephone"] = clean_input($data["telephone"]);
    $this->user_data["topic"] = $data["topic"];
    $this->user_data["payment"] = $data["payment"];
    $this->user_data["receiveEmail"] = $data["receiveEmail"] === "yes" ? "yes" : "no";
    $this->user_data[] = date('l jS \of F Y h:i A');
    $this->user_data[] = $_SERVER['REMOTE_ADDR'];
  }

  private function save() {
    is_dir_exists(static::$path_to_save);
    save_to_file(static::$path_to_save, $this->user_data, "a");
  }

  private function read() {
    $users_data = [];
    if(is_dir_exists(static::$path_to_save)) {
      read_from_file(static::$path_to_save, $users_data);
    }
    return $users_data;
  }

  public function post($data) {
    $this->create($data);
    if(!$this->is_error()) {
      $this->save();
    }
  }

  public function delete($indexes) {
    $counter = 0;
    $prev_users = file(static::$path_to_save);
    $in = fopen(static::$path_to_save, "w");

    foreach($prev_users as $idx => $prev_user_data) {
      if($prev_user_data[0] == 0) {
        fwrite($in, $prev_user_data);
      } else if (in_array($counter, $indexes)) {
        $prev_user_data = substr_replace($prev_user_data, 0, 0, 1);
        fwrite($in, $prev_user_data);
        $counter += 1;
      } else {
        fwrite($in, $prev_user_data);
        $counter += 1;
      } 
    }
    
    fclose($in);
  }

  public function get() {
    return $this->read();
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
        if($this->is_invalid($key)) {
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