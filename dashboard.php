<?php
session_start();
date_default_timezone_set('America/Tijuana');
if (!isset($_SESSION['user'])) {
  header('location: /');
} else {
  $USERID = $_SESSION['user']['id'];
}

function uploadImageName($image) {
  $imageName = date('ymdhis').'_'.$image['name'];
  $target = 'uploads/';
  return $target . basename($imageName);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
  $link = new mysqli('localhost', 'root', '', 'images');
  $image = $_FILES['image'];
  $imageName = uploadImageName($image);
  // Image
  $original = $_FILES['image']['name'];
  $type = explode('.', $_FILES['image']['name'])[1];
  $link->query("INSERT INTO images (original, type, name, userid) VALUES ('$original', '$type', '$imageName', $USERID)");
  if ($link->affected_rows > 0) {
    $message = array('message' => 'Image uploaded', 'type' => 'success');
    move_uploaded_file($_FILES['image']['tmp_name'], $imageName);
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
    html,
    body {
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
    <a class="navbar-brand" href="/dashboard.php">Upload Images</a>
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
        <li class="nav-item active">
          <a class="nav-link" href="/dashboard.php">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/images.php">Images</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gallery.php">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container h-100">
    <form class="row justify-content-center align-items-center h-100" method="POST" enctype="multipart/form-data">
      <div class="col-md-4 card p-4">
        <div class="form-group">
          <h4>Upload image</h4>
        </div>
        <div class="form-group">
          <label>* Image</label>
          <input class="form-control p-2" type="file" limit="1" name="image" accept=".jpg,.png,.gif" required>
        </div>
        <div class="form-group">
          <input type="submit" value="Upload" class="btn btn-primary form-control">
        </div>
        <?php if (isset($message)) { ?>
          <div class="form-group">
            <div class="alert alert-<?= $message['type'] ?>" role="alert">
              <?= $message['message'] ?>
            </div>
          </div>
        <?php } ?>
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
