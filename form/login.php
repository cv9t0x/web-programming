<?php
session_start();
if (isset($_SESSION['isAdmin'])) {
  header("Location: ./admin.php");
}
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
  <title>Login</title>
</head>

<body>
  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  include "./modules/LoginForm.php";

  $form = new LoginForm();

  if ($form->isPost()) {
    if ($form->isPass($_POST)) {
      $_SESSION['isAdmin'] = TRUE;
      header("Location: ./admin.php");
    }
  }
  ?>

  <div class="container-md py-4">
    <div class="row justify-content-center">
      <div class="col col-lg-6">
        <div class="mb-3">
          <a type="button" class="btn btn-primary" href="./index.php">
            Return
          </a>
        </div>

        <form action="login.php" method="post" autocomplete="off">
          <div class="mb-3">
            <h2>Sign In</h2>
          </div>

          <?= $form->isError() ? '<div class="mb-2 text-danger">Incorrect username or password</div>' : ""  ?>

          <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="login" class="form-control" id="login" name="login" placeholder="Enter login" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" />
          </div>

          <button type="submit" class="btn btn-primary">Enter</button>
        </form>
      </div>
    </div>
  </div>

</body>

</html>