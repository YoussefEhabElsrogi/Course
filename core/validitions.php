<?php

function requireInput($input)
{
  return empty($input);
}
function minInput($input, $length)
{
  return strlen($input) < $length;
}
function maxInput($input, $length)
{
  return strlen($input) > $length;
}