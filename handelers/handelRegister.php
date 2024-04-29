<?php

require_once './../config/connection.php';
require_once './../core/functions.php';
require_once './../core/validitions.php';
require_once './../core/sessions.php';

session_start();
$errors = [];

if (postMethod() && issetInput($_POST['submit'])):

  foreach ($_POST as $key => $value):
    $$key = receiveInput($conn, $value);
  endforeach;

  // Check username
  if (requireInput($username)):
    $errors['username'] = 'Your name is required';
  elseif (minInput($username, 6)):
    $errors['username'] = 'Your name must be at least 6 characters';
  elseif (maxInput($username, 20)):
    $errors['username'] = 'Your name must be less than 20 characters';
  elseif (checkInputNotInt($username)):
    $errors['username'] = 'Please enter characters instead of numbers';
  endif;

  // Check email
  if (requireInput($email)):
    $errors['email'] = 'Your email is required';
  elseif (checkEmail($email)):
    $errors['email'] = 'Please enter a valid email address';
  endif;

  // Check password
  if (requireInput($password)):
    $errors['password'] = 'Your password is required';
  elseif (minInput($password, 8)):
    $errors['password'] = 'Your password must be at least 8 characters';
  elseif (maxInput($password, 20)):
    $errors['password'] = 'Your password must be less than 20 characters';
  endif;

  // Check gender
  $validGenders = ['male', 'female'];
  if (isset($gender)):
    if (!checkItemInArray($gender, $validGenders)):
      $errors['gender'] = 'Please choose a valid gender';
    endif;
  else:
    $errors['gender'] = 'Please choose your gender';
  endif;

  // Check birthday
  if (requireInput($birthday_month) || requireInput($birthday_day) || requireInput($birthday_year)):
    $errors['birthday'] = 'Birth date is required';
  endif;

  if (requireInput($errors)):
    $hashPassword = hashPassword($password);

    if ($gender === 'male'):
      $image = 'male.webp';
    elseif ($gender === 'female'):
      $image = 'female.jpeg';
    endif;

    $birthDate = (int) $birthday_day . '-' . (int) $birthday_month . '-' . (int) $birthday_year;

    $sql = "INSERT INTO `users`  (`username` , `email`,`password`,`gender`,`birthday`,`profile_image`) VALUES ('$username','$email','$hashPassword','$gender','$birthDate','$image')";

    $result = mysqli_query($conn, $sql);

    createSession('success', 'Your data is registered');

    redirectPage('./../register.php');

  else:
    createSession('error', $errors);
    redirectPage('./../register.php');
  endif;

else:
  redirectPage('./../register.php');
endif;