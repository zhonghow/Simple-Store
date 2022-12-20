<?php

function connectToDB()
{
    return new PDO(
        'mysql:host=devkinsta_db;
        dbname=Store_App',
        'root',
        'qQs06NBbdQOEMav6'
    );
}

function isLoggedIn()
{
    // If user == logged in, return true
    // If user != logged in, return false

    return isset($_SESSION['user']);
}


function logOut()
{
    //Deletes the session data so that the user is log out
    unset($_SESSION['user']);
}

