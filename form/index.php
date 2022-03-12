<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <title>Form</title>
</head>

<body>
  <?php
    $dir_to_save = "users/";
    $user_errors = array("fnameErr" => false, "lnameErr" => false, "emailErr" => false, "telephoneErr" => false);
    $user_data = array("fname" => "", "lname" => "", "email" => "", "telephone" => "", "topic" => "Business", "payment" => "Webmoney", "receiveEmail" => "yes");
    $error = false;
  
    if ($_POST) {
      if (empty($_POST["fname"])) {
        $user_errors["fnameErr"] = true;
        $error = true;
      } else {
        $user_data["fname"] = test_input($_POST["fname"]);
      }

      if (empty($_POST["lname"])) {
        $user_errors["lnameErr"] = true;
        $error = true;
      } else {
        $user_data["lname"] = test_input($_POST["lname"]);
      }

      if (empty($_POST["email"])) {
        $user_errors["emailErr"] = true;
        $error = true;
      } else {
        $user_data["email"] = test_input($_POST["email"]);
      }

      if (empty($_POST["telephone"])) {
        $user_errors["telephoneErr"] = true;
        $error = true;
      } else {
        $user_data["telephone"] = test_input($_POST["telephone"]);
      }

      if (!empty($_POST["receiveEmail"])) {
        $user_data["receiveEmail"] = "yes";
      } else {
        $user_data["receiveEmail"] = "no";
      }

      $user_data["topic"] = test_input($_POST["topic"]);
      $user_data["payment"] = test_input($_POST["payment"]);

      if(!$error) {
        $out = array();
        
        foreach($user_data as $key => $value) {
          $out[] = $key.' '.$value."\n";
        }

        if(!is_dir($dir_to_save)) {
          mkdir($dir_to_save);
        }
    
        file_put_contents(($dir_to_save.date("d-m-y_h-m-s").".txt"), $out);
        header("Location: index.php?send=true");
      }
    }

    function test_input($value) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      return $value;
    }
  ?>

  <div class="container-md py-4">
    <div class="row justify-content-center">
      <div class="col col-lg-6">
        <?php if(isset($_GET['send']) && $_GET['send'] === 'true') : ?>
        <h2>Application was successfully accepted!</h2>
        <?php else : ?>
        <form action="index.php" method="post">
          <div class="mb-3 py-2">
            <h2>Next.js conference registration</h2>
          </div>

          <?php if($error) : ?>
          <div class="mb-2 text-danger">* required field</div>
          <?php endif; ?>

          <div class="mb-3 row align-items-center">
            <div class="col-6">
              <label for="fname" class="form-label">First name</label>

              <?php if($user_errors["fnameErr"]) : ?>
              <span class="text-danger">*</span>
              <?php else : ?>
              <span>*</span>
              <?php endif; ?>

              <input type="text" class="form-control" id="fname" name="fname" aria-describedby="firstName"
                placeholder="Enter first name" value="<?php echo $user_data["fname"]; ?>" />
            </div>

            <div class="col-6">
              <label for="lname" class="form-label">Last name</label>

              <?php if($user_errors["lnameErr"]) : ?>
              <span class="text-danger">*</span>
              <?php else : ?>
              <span>*</span>
              <?php endif; ?>

              <input type="text" class="form-control" id="lname" name="lname" aria-describedby="lastName"
                placeholder="Enter last name" value="<?php echo $user_data["lname"]; ?>" />
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>

            <?php if($user_errors["emailErr"]) : ?>
            <span class="text-danger">*</span>
            <?php else : ?>
            <span>*</span>
            <?php endif; ?>

            <input type="email" class="form-control" id="email" name="email" aria-describedby="email"
              placeholder="Enter email address" value="<?php echo $user_data["email"]; ?>" />
          </div>

          <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>

            <?php if($user_errors["telephoneErr"]) : ?>
            <span class="text-danger">*</span>
            <?php else : ?>
            <span>*</span>
            <?php endif; ?>

            <input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephone"
              placeholder="Enter telephone" value="<?php echo $user_data["telephone"]; ?>" />
          </div>

          <div class="mb-3">
            <label for="topic" class="form-label">Conference topic</label>
            <select class="form-select" id="topic" name="topic" aria-label="topic">
              <option value="business" <?php echo ($user_data["topic"] === "business") ? "selected='selected'" : ""; ?>>
                Business
              </option>
              <option value="technology"
                <?php echo ($user_data["topic"] === "technology") ? "selected='selected'" : ""; ?>>Technology
              </option>
              <option value="advertisingMarketing"
                <?php echo ($user_data["topic"] === "advertisingMarketing") ? "selected='selected'" : ""; ?>>
                Advertising &#38; Marketing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="payment" class="form-label">Payment method</label>
            <select class="form-select" id="payment" name="payment" aria-label="payment">
              <option value="webmoney"
                <?php echo ($user_data["payment"] === "webmoney") ? "selected='selected'" : ""; ?>>WebMoney
              </option>
              <option value="yandex" <?php echo ($user_data["payment"] === "yandex") ? "selected='selected'" : ""; ?>>
                Yandex.Money
              </option>
              <option value="paypal" <?php echo ($user_data["payment"] === "paypal") ? "selected='selected'" : ""; ?>>
                Paypal
              </option>
              <option value="card" <?php echo ($user_data["payment"] === "card") ? "selected='selected'" : ""; ?>>
                Card
              </option>
            </select>
          </div>

          <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="receiveEmail" name="receiveEmail"
              aria-describedby="receiveEmail" value="yes"
              <?php echo $user_data["receiveEmail"] === "yes" ? "checked='checked'" : ""; ?> />
            <label class="form-check-label" for="receiveEmail">Do you want to receive the newsletter?</label>
          </div>

          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>


</body>

</html>