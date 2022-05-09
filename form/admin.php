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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <title>Admin</title>

  <style>
  .btn-label {
    position: relative;
    left: -12px;
    display: inline-block;
    padding: 6px 12px;
    background: rgba(0, 0, 0, 0.15);
    border-radius: 3px 0 0 3px;
  }

  .btn-labeled {
    padding-top: 0;
    padding-bottom: 0;
  }

  .btn {
    margin-bottom: 10px;
  }

  .capitalize {
    text-transform: capitalize;
  }
  </style>

</head>

<body>
  <?php
    include "./modules/Form.php";

    $form = new Form();
    $users_data = $form->get();

    if ($form->is_post()) {
      $checkboxes = $_POST['check_list'];
      $form->delete($checkboxes);

      header("Location: admin.php");
    }


  ?>

  <div class="container-md py-4">
    <div class="row justify-content-center">
      <div class="col-12">

        <?php if(empty($users_data)): ?>
        <h2>No members so far</h2>
        <?php else : ?>
        <form action="admin.php" method="post">
          <div class="mb-3">
            <h2>Table of members</h2>
          </div>

          <table class="table table-bordered mb-3">
            <thead>
              <th scope="col">#</th>
              <th scope="col">First name</th>
              <th scope="col">Last name</th>
              <th scope="col">Email</th>
              <th scope="col">Telephone</th>
              <th scope="col">Topic</th>
              <th scope="col">Payment</th>
              <th scope="col">Receive email</th>
              <th scope="col">Date</th>
              <th scope="col">Ip Address</th>
            </thead>
            <tbody>
              <?php foreach($users_data as $idx => $user_data) : ?>
              <tr>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="<?php echo "checkbox".($idx + 1); ?>"
                      name="check_list[]" value="<?php echo $idx; ?>">
                    <label class="form-check-label" for="<?php echo "checkbox".($idx + 1); ?>">
                      <?php echo ($idx + 1); ?>
                    </label>
                  </div>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data[0]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data[1]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data[2]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data[3]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data[4]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data[5]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data[6]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data[7]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data[8]; ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <button type="submit" class="btn btn-labeled btn-danger">
            <span class="btn-label"><i class="fa fa-trash"></i></span>Delete</button>
        </form>
        <?php endif; ?>

      </div>
    </div>
  </div>

</body>

</html>