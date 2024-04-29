<?php

function checkRequest()
{
  return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
}
function postMethod()
{
  return checkRequest() === 'POST';
}
function receiveInput($conn, $input)
{
  return mysqli_real_escape_string($conn, htmlspecialchars(htmlentities(stripslashes(trim($input)))));
}
function issetInput($input)
{
  return isset($input);
}
function redirectPage($path)
{
  header("Location: $path");
  exit;
}
function hashPassword($password)
{
  return password_hash($password, PASSWORD_DEFAULT);
}
function checkEmail($email)
{
  return !filter_var($email, FILTER_VALIDATE_EMAIL);
}
function checkItemInArray($input, array $array): bool
{
  return in_array($input, $array, true);
}
function passwordVerifyed($password, $hashPassword)
{
  return password_verify($password, $hashPassword);
}
function checkInputNotInt($input)
{
  return filter_var($input, FILTER_VALIDATE_INT);
}