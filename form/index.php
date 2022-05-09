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
    include "./modules/Form.php";

    $form = new Form();

    if ($form->is_post()){
      $form->post($_POST);
      if(!$form->is_error()) {
        header("Location: index.php?send=true");
      }
    }
  ?>

  <div class="container-md py-4">
    <div class="row justify-content-center">
      <div class="col col-lg-6">

        <?php if(isset($_GET['send']) && $_GET['send'] === 'true') : ?>
        <h2>Application was successfully accepted!</h2>
        <?php else : ?>
        <form action="index.php" method="post" autocomplete="off">
          <div class="mb-3 py-2">
            <h2>Next.js conference registration</h2>
          </div>

          <?= $form->is_error() ? '<div class="mb-2 text-danger">* required field</div>' : ""  ?>

          <div class="mb-3 row align-items-center">
            <div class="col-6">
              <label for="fname" class="form-label">First name</label>

              <?= $form->is_invalid("fname") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

              <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name"
                value="<?= $form->get_value("fname"); ?>" />
            </div>

            <div class="col-6">
              <label for="lname" class="form-label">Last name</label>

              <?= $form->is_invalid("lname") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

              <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name"
                value="<?= $form->get_value("lname"); ?>" />
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>

            <?= $form->is_invalid("email") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address"
              value="<?= $form->get_value("email"); ?>" />
          </div>

          <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>

            <?= $form->is_invalid("telephone") ? '<span class="text-danger">*</span>' : '<span>*</span>' ?>

            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Enter telephone"
              value="<?= $form->get_value("telephone"); ?>" />
          </div>

          <div class="mb-3">
            <label for="topic" class="form-label">Conference topic</label>
            <select class="form-select" id="topic" name="topic" aria-label="topic">
              <option value="business"
                <?= !$form->get_value("topic") || $form->get_value("topic") === "business" ? "selected='selected'" : ""; ?>>
                Business
              </option>
              <option value="technology"
                <?= $form->get_value("topic") === "technology" ? "selected='selected'" : ""; ?>>
                Technology
              </option>
              <option value="advertisingMarketing"
                <?= $form->get_value("topic") === "advertisingMarketing" ? "selected='selected'" : ""; ?>>
                Advertising &#38; Marketing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="payment" class="form-label">Payment method</label>
            <select class="form-select" id="payment" name="payment" aria-label="payment">
              <option value="webmoney"
                <?= !$form->get_value("payment") || $form->get_value("payment") === "webmoney" ? "selected='selected'" : ""; ?>>
                WebMoney
              </option>
              <option value="yandex" <?= $form->get_value("payment") === "yandex" ? "selected='selected'" : ""; ?>>
                Yandex.Money
              </option>
              <option value="paypal" <?= $form->get_value("payment") === "paypal" ? "selected='selected'" : ""; ?>>
                Paypal
              </option>
              <option value="card" <?= $form->get_value("payment") === "card" ? "selected='selected'" : ""; ?>>
                Card
              </option>
            </select>
          </div>

          <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="receiveEmail" name="receiveEmail" value="yes"
              <?= $form->get_value("receiveEmail") === "yes" || !$form->get_value("receiveEmail") ? "checked='checked'" : ""; ?> />
            <label class="form-check-label" for="receiveEmail">Do you want to receive the newsletter?</label>
          </div>

          <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>


</body>

</html>