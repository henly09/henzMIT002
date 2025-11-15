<!DOCTYPE html>
<?php
include_once('../../../conn.php');
?>
<?php
if (isset($_SESSION['loggedin'])) {
  header('Location: admin.php');
  exit;
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PiStamp Administrator Login</title>
  <link rel="icon" href="../assets/img/AdminLTELogo.png">
  <link rel="stylesheet" href="style.css">
  <link href='../../node_modules/boxicons/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="wrapper">
    <form action="" method="post" id="login">
      <h1>Login</h1>

      <div class="input-box ">
        <input type="text" placeholder="Username" class="form-control atay" name="username" id="username">
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" placeholder="Password" class="form-control atay" name="password" id="password">
        <i class='bx bx-lock-alt'></i>
      </div>

      <button type="submit" class="btn" name="submit" id="submit">Login</button>
    </form>
  </div>
  </div>
  <script src="../js/bootstrap/bootstrap.min.js"></script>

  <!-- Sweet Alert 2 -->
  <script src="../js/sweetalert/swal.js"></script>
  <script src="index.js"></script>
</body>

</html>
