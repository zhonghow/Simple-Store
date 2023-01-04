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


    // Find product by ID
    public function findProduct($product_id)
    {
        //find the product based on the product_id
        $statement = $this->database->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute([
            'id' => $product_id
        ]);

        //retrieve the product as object
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
