<?php

class Authentication
{

    public $database;

    // This function will trigger when the class (which in this case "Authentication") is called
    public function __construct()
    {
        $this->database = connectToDB();
    }

    public function login($email = '', $password = '')
    {
        
        $error = '';

        if (empty($email) || empty($password))  {
            $error = 'All fields are required';
        }


        if(!empty($error)) {
            return $error;
        }
        
        $statement = $this->database->prepare(
            'SELECT * FROM user_info WHERE email = :email'
        );

        $statement->execute([
            'email' => $email
        ]);

        // fetch one result from database
        $user = $statement->fetch();

        // if $user exists, it means the user exists in the database
        if ($user) {
            // check password
            if (
                password_verify($password, $user['password'])
            ) {
                // assign user data to user session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email']
                ];

                // redirect user back to index
                header('Location: /');
                exit;
            } else {
                return 'Invalid email or password';
            }
        } else {
            // user doesn't exists
            return 'Invalid email or password';
        }
    }

    public function signup($email = '', $password = '', $confirm_password = '')
    {

        $error = '';

        if (empty($email) || empty($password) || empty($confirm_password)) {
            $error = 'All fields are required';
        }


        if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
            $error = 'The password & confirm password field should match';
        }

        if(!empty($error)) {
            return $error;
        }


        // make sure user's email wasn't already exists in database
        $statement = $this->database->prepare(
            'SELECT * FROM user_info WHERE email = :email'
        );

        $statement->execute([
            'email' => $email
        ]);

        // fetch one result from database
        $user = $statement->fetch();

        // if user exists, return error
        if ($user) {
            return 'Email already exists';
        } else {
            // if user doesn't exists, insert user data into database
            $statement = $this->database->prepare(
                'INSERT INTO user_info ( email, password )
                VALUES (:email, :password )'
            );

            $statement->execute([
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            // redirect the user back to login.php
            header('Location: /login.php');
            exit;
        }
    }
}
