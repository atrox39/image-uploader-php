<?php
session_start();
date_default_timezone_set('America/Tijuana');
if (isset($_SESSION['user'])) {
  header('location: /dashboard.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $link = new mysqli('localhost', 'root', '', 'images');
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  try {
    $link->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
    $success = $link->affected_rows;
    if ($success > 0) {
      $message = array('message' => 'User created successfully', 'type' => 'success');
    } else {
      $message = array('message' => 'User not created', 'type' => 'danger');
    }
  } catch (Exception $ex) {
    $message = array('message' => 'Username or email already exists', 'type' => 'danger');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
  >
  <style>
    html, body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
    }
  </style>
  <title>Upload images</title>
</head>
<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Upload Images</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login.php">Login</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/register.php">Register<span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container h-100">
    <form class="row justify-content-center align-items-center h-100" method="POST" enctype="multipart/form-data">
      <div class="col-md-4 card p-4">
        <div class="form-group">
          <h4>Register user</h4>
        </div>
        <div class="form-group">
          <label>* Username</label>
          <input class="form-control" type="text" name="username" placeholder="Your username" required>
        </div>
        <div class="form-group">
          <label>* Email</label>
          <input class="form-control" type="email" name="email" placeholder="email@email.com" required>
        </div>
        <div class="form-group">
          <label>* Password</label>
          <input class="form-control" type="password" name="password" placeholder="Your Password" required>
        </div>
        <div class="form-group">
          <input type="submit" value="Register" class="btn btn-primary form-control">
        </div>
        <?php
        if (isset($message)) {
        ?>
        <div class="form-group">
          <div class="alert alert-<?= $message['type'] ?>" role="alert">
            <?= $message['message'] ?>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
    </form>
  </div>
  <script
    src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"
  ></script>
</body>
</html>
