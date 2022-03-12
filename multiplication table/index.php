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
  <title>Table</title>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col col-lg-6">
        <table class="table table-bordered mb-3">
          <thead>
            <?php foreach(range(0, 10) as $i) : ?>

            <?php if($i === 0) : ?>
            <th scope="col" class="table-secondary"></th>
            <?php else: ?>
            <th scope="col" class="table-light">
              <?php echo $i; ?>
            </th>
            <?php endif; ?>

            <?php endforeach ?>
          </thead>
          <tbody>
            <?php foreach(range(1, 10) as $i) : ?>
            <tr>
              <td class="table-light">
                <?php echo $i; ?>
              </td>
              <?php foreach(range(1, 10) as $j) :?>
              <td <?php echo ($i === $j) ? "class='table-secondary'" : ""; ?>>
                <?php echo $i * $j; ?>
              </td>
              <?php endforeach ?>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>