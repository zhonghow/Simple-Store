<?php

// Get route from the global variable $_SERVER
$path = $_SERVER["REQUEST_URI"];

// Remove beginning and & ending slash '/'
$path = trim($path, "/"); 

// Remove all the URL parameters that starts from '?'
$path = parse_url($path, PHP_URL_PATH); 

switch ($path) {
    case 'login':
        require "pages/login.php";
        break;
    case 'signup':
        require "pages/signup.php";
        break;
    case 'logout':
        require "pages/logout.php";
        break;
    case 'order':
        require "pages/order.php";
        break;
    case 'cart':
        require "pages/cart.php";
        break;
    default:
        require "pages/home.php";
        break;
}
