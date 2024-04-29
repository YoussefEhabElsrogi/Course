<?php

require_once './../config/connection.php';
require_once './../core/functions.php';
require_once './../core/validitions.php';
require_once './../core/sessions.php';

session_start();
$errors = [];

if (postMethod() && issetInput($_POST['email'] && issetInput($_POST['password']))):

  foreach ($_POST as $key => $value):
    $$key = receiveInput($conn, $value);
  endforeach;

  if (requireInput($email)):
    $errors['email'] = 'Your email is required';
  elseif (checkEmail($email)):
    $errors['email'] = 'This is not an email , enter the valid email';
  endif;  // check `email`


  // check `password`
  if (requireInput($password)):
    $errors['password'] = 'Your password is required';
  elseif (minInput($password, 8)):
    $errors['password'] = 'Your password must be greater than 8 chars';
  elseif (maxInput($password, 20)):
    $errors['password'] = 'Your password must be smaller than 20 chars';
  endif;


  if (requireInput($errors)):

    $select = "SELECT * FROM `users` WHERE `email` = '$email'";

    $result = mysqli_query($conn, $select);

    if (!mysqli_num_rows($result) > 0):
      redirectPage('./../register.php');

    else:

      $user = mysqli_fetch_assoc($result);

      $hashPassword = $user['password'];

      // Verify the entered password against the hashed password from the database
      if (passwordVerifyed($password, $hashPassword)):

        // Cookie to save data
        if (isset($keep)):
          if ($keep === '1'):
            setcookie('email', $email, time() + 3600, '/');
            setcookie('password', $password, time() + 3600, '/');
          endif;
        endif;

        // Sessions
        createSession('id', $user['id']);
        createSession('username', $user['username']);

        // redirect
        redirectPage('./../home.php');
      else:
        createSession('noPassword', 'Your password isn\'t found');

        // redirect
        redirectPage('./../home.php');
      endif;

    endif;

  else:
    createSession('error', $errors);
    redirectPage('./../index.php');
  endif;

else:

  redirectPage('./../index.php');

endif;