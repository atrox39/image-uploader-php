<?php
session_start();
date_default_timezone_set('America/Tijuana');
if (!isset($_SESSION['user'])) {
  header('location: /');
} else {
  $USERID = $_SESSION['user']['id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['path']) {
  $id = $_POST['id'];
  $path = $_POST['path'];
  $link = new mysqli('localhost', 'root', '', 'images');
  $link->query("DELETE FROM images WHERE id = $id AND userid = $USERID");
  $fullPath = getcwd().'\\'.str_replace('/', '\\', $path);
  unlink($fullPath);
}
header('location: /gallery.php');
