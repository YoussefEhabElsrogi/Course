<?php

require_once './config/connection.php';
require_once './core/functions.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])):

  $id = $_GET['id'];

  $delete = "DELETE FROM `users` WHERE `id` = '$id'";

  $result = mysqli_query($conn, $delete);

  setcookie('email', '', time() - 3600, '/');
  setcookie('password', '', time() - 3600, '/');

  redirectPage('./index.php');

endif;