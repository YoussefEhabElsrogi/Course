<?php

$localHost = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'website';

// Create Connection 
$conn = mysqli_connect($localHost, $userName, $password, $dbName);

// Check Connectino 
if (!$conn):
  die("Connection Faild " . mysqli_connect_error());
endif;
