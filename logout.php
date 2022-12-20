<?php

session_start();

require "includes/functions.php";

if (isLoggedIn()) {
    logOut();
    header('Location:/login.php');
    exit;
} else {
    header('Location: /login.php');
    exit;
}
