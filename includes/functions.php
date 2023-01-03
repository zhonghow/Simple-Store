<?php

function connectToDB()
{
    return new PDO(
        'mysql:host=devkinsta_db;
        dbname=mystore',
        'root',
        'qQs06NBbdQOEMav6'
    );
}

function isLoggedIn()
{
    return isset($_SESSION['user']);
}


function logOut()
{
    unset($_SESSION['user']);
}
