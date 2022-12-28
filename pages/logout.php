<?php

session_start();

require "includes/functions.php";

if (isLoggedIn()) {
    logOut();
    header('Location:/login');
    exit;
} else {
    header('Location:/login');
    exit;
}
