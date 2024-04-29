<?php

session_start();

require_once './core/functions.php';
require_once './core/sessions.php';
require_once './config/connection.php';

if (!issetSession('id') && !issetSession('username')):

  redirectPage('./index.php');

else:

  $id = $_SESSION['id'];
  $userName = $_SESSION['username'];

  $select = "SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1";

  $result = mysqli_query($conn, $select);

  $data = mysqli_fetch_assoc($result);

  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./css/style.css">
  </head>

  <body>
    <a href="logout.php">Logout</a>

    <div class="photo">

      <?php if ($data['profile_image'] === 'male.webp' || $data['profile_image'] === 'female.jpeg'): ?>
        <img src="./default_image/<?php echo $data['profile_image'] ?>" alt="Profile image not found!">
      <?php else: ?>
        <img src="./image/<?php echo $data['profile_image'] ?>" alt="Profile image not found!">
      <?php endif; ?>

    </div>


    <form method="POST" action="./handelers/handelProfile_image.php" enctype="multipart/form-data">

      <?php if (issetSession('error')): ?>
        <div id="error">
          <?php echo $_SESSION['error']; ?>
        </div>
        <?php removeSession('error'); endif; ?>

      <?php if (issetSession('success')): ?>
        <div id="success">
          <?php echo $_SESSION['success']; ?>
        </div>
        <?php removeSession('success'); endif; ?>

      <input type="file" name="file">
      <input type="submit" name="submit" value="UPLOAD">
    </form>

  </body>

  </html>

<?php endif; ?>