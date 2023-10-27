<?php
$link = new mysqli('localhost', 'root', '', 'images');
$result = $link->query('SELECT users.username, images.name, images.original FROM images INNER JOIN users ON images.userid = users.id ORDER BY images.id DESC');
$images = array();
while(($res = $result->fetch_assoc()) != null) {
  $images[] = $res;
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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
        <li class="nav-item active">
          <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register.php">Register</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container mt-4">
    <table class="table">
      <thead>
        <th>Image</th>
        <th>User</th>
        <th>URL</th>
      </thead>
      <?php foreach($images as $image) { ?>
      <tr>
        <td>
          <img onclick="showDialog(event)" width="60" height="60" src="<?= '/'.$image['name'] ?>" alt="<?= $image['original'] ?>">
        </td>
        <td><?= $image['username'] ?></td>
        <td><a download href="<?= '/'.$image['name'] ?>">Download</a></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div id="dialog" class="hidden"></div>
  <style>
    #dialog {
      top: 0;
      left: 0;
      position: fixed;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      flex: 1;
    }
    .hidden {
      z-index: -1;
      opacity: 0;
    }
  </style>
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
  <script>
    const dialog = document.getElementById('dialog');
    dialog.addEventListener('click', (e) => {
      if (e.target.getAttribute('class') !== 'hidden') {
        e.target.setAttribute('class', 'hidden');
        e.target.innerHTML = '';
      }
    });

    function showDialog(event) {
      dialog.setAttribute('class', '');
      const image = event.target.src;
      dialog.innerHTML = `
      <img src="${image}" width="500">
      `;
    }
  </script>
</body>
</html>
