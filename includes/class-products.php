<?php

class Products
{
    public $database;

    public function __construct()
    {
        try {
            $this->database = connectToDB();
        } catch (Exception) {
            die('Database Connection Failed');
        }
    }

    // Retrieve all the products from database

    public function listAllProducts()
    {
        $statement = $this->database->prepare('SELECT * FROM products');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
