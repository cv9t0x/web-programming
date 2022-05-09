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
    $dir_to_read = "users/";
    $input_path = $dir_to_read . "users.txt";
    $users_data = array();

    if(is_dir($dir_to_read)) {
      if(($input = fopen($input_path, "r")) !== FALSE) {
        while(($data = fgetcsv($input)) !== FALSE) {
          if($data[0] == 1) {
            $user_data = array();
            $user_data["fname"] = $data[1];
            $user_data["lname"] = $data[2];
            $user_data["email"] = $data[3];
            $user_data["telephone"] = $data[4];
            $user_data["topic"] = $data[5];
            $user_data["payment"] = $data[6];
            $user_data["receiveEmail"] = $data[7];
            $user_data["date"] = $data[8];
            $user_data["ipAddress"] = $data[9];
            array_push($users_data, $user_data);
          }
        }
      }
    }

    if (!empty($_POST)) {
      $checkboxes = $_POST['check_list'];

      if(!empty($checkboxes) && !empty($users_data)) {
        $counter = 0;
        $old_users = file($input_path);
        $input=fopen($input_path,"w");

        foreach($old_users as $idx => $user) {
          if($user[0] == 0) {
            fwrite($input, $user);
          } else if (in_array($counter, $checkboxes)) {
            $user = substr_replace($user, 0, 0, 1);
            fwrite($input, $user);
            $counter += 1;
          } else {
            fwrite($input, $user);
            $counter += 1;
          } 
        }
        
        fclose($input);
        header("Location: admin.php");
      }
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
                    <?php echo $user_data["fname"]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data["lname"]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data["email"]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data["telephone"]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data["topic"]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data["payment"]; ?>
                  </span>
                </td>
                <td>
                  <span class="capitalize">
                    <?php echo $user_data["receiveEmail"]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data["date"]; ?>
                  </span>
                </td>
                <td>
                  <span>
                    <?php echo $user_data["ipAddress"]; ?>
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