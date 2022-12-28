<?php

$path = $_SERVER["REQUEST_URI"];

switch ($path) {
    case '/login':
        require "pages/login.php";
        break;
    case '/signup':
        require "pages/signup.php";
        break;
    case '/logout':
        require "pages/logout.php";
        break;
    case '/order':
        require "pages/order.php";
        break;
    case '/cart':
        require "pages/cart.php";
        break;
    default:
        require "pages/home.php";
        break;
}
