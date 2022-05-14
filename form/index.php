<?php
include_once "./scripts/autoLogout.php";
include_once "./modules/Statistic.php";

$statistic = new Statistic();
$statistic->addHit($_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'));

?>

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
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  include "./modules/ParticipantForm.php";

  $form = new ParticipantForm();

  if ($form->isPost()) {
    $form->submit($_POST);
    if (!$form->isError()) {
      header("Location: index.php?send=true");
    }
  }
  ?>

  <div class="container-md py-4">
    <div class="row justify-content-center">
      <div class="col col-lg-6">
        <div class="mb-3">
          <a type="button" class="btn btn-primary" href="./login.php">
            Enter administrator mode
          </a>
        </div>

        <?php if (isset($_GET['send']) && $_GET['send'] === 'true') : ?>
        <h2>Application was successfully accepted!</h2>
        <?php else : ?>

        <form action="index.php" method="post" autocomplete="off">
          <div class="mb-3">
            <h2>Next.js conference registration</h2>
          </div>

          <?= $form->isError() ? '<div class="mb-2 text-danger">* required field</div>' : ""  ?>

          <div class="mb-3 row align-items-center">
            <div class="col-6">
              <label for="fname" class="form-label">First name</label>

              <?= $form->isInvalid("fname") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

              <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name"
                value="<?= $form->getValue("fname"); ?>" />
            </div>

            <div class="col-6">
              <label for="lname" class="form-label">Last name</label>

              <?= $form->isInvalid("lname") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

              <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name"
                value="<?= $form->getValue("lname"); ?>" />
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>

            <?= $form->isInvalid("email") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address"
              value="<?= $form->getValue("email"); ?>" />
          </div>

          <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>

            <?= $form->isInvalid("tel") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Enter telephone"
              value="<?= $form->getValue("tel"); ?>" />
          </div>

          <div class="mb-3">
            <label for="subject" class="form-label">Conference subject</label>
            <select class="form-select" id="subject" name="subject" aria-label="subject">
              <option value="business" <?= $form->getValue("subject") === "business" ? "selected='selected'" : ""; ?>>
                Business
              </option>
              <option value="technology"
                <?= $form->getValue("subject") === "technology" ? "selected='selected'" : ""; ?>>
                Technology
              </option>
              <option value="advertisingMarketing"
                <?= $form->getValue("subject") === "advertisingMarketing" ? "selected='selected'" : ""; ?>>
                Advertising &#38; Marketing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="payment" class="form-label">Payment method</label>
            <select class="form-select" id="payment" name="payment" aria-label="payment">
              <option value="webmoney" <?= $form->getValue("payment") === "webmoney" ? "selected='selected'" : ""; ?>>
                WebMoney
              </option>
              <option value="yandex" <?= $form->getValue("payment") === "yandex" ? "selected='selected'" : ""; ?>>
                Yandex.Money
              </option>
              <option value="paypal" <?= $form->getValue("payment") === "paypal" ? "selected='selected'" : ""; ?>>
                Paypal
              </option>
              <option value="card" <?= $form->getValue("payment") === "card" ? "selected='selected'" : ""; ?>>
                Card
              </option>
            </select>
          </div>

          <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="mailing" name="mailing" value="1"
              <?= $form->getValue("mailing") ? "checked='checked'" : ""; ?> />
            <label class="form-check-label" for="mailing">Do you want to receive the newsletter?</label>
          </div>

          <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>


</body>

</html>