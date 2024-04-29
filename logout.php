<?php

require_once './core/functions.php';

session_start();
session_unset();
session_destroy();

redirectPage('./index.php');