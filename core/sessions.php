<?php

function createSession($key, $value)
{
  $_SESSION[$key] = $value;
}
function issetSession($key)
{
  return isset($_SESSION[$key]);
}
function returnSession($key)
{
  return $_SESSION[$key];
}
function getSessionValue($sessionName, $sessionValue)
{
  return $_SESSION[$sessionName][$sessionValue];
}
function removeSession($key)
{
  unset($_SESSION[$key]);
}