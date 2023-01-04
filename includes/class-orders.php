<?php

class Orders
{
    public $database;

    public function __construct()
    {
        try {
            $this->database = connectToDB();
        } catch (
            Exception) {
            die("Database Connection Failed");
        }
    }

    public function createNewOrder(
        $user_id, // Who made the order
        $total_amount = 0, //Total amount of price
        $products_in_cart = [] // Products in the cart
    ) {

        // Step #1 => Insert a new order into database
        $statement = $this->database->prepare('INSERT INTO orders(user_id, total_amount, transaction_id) VALUES (:user_id, :total_amount, :transaction_id)');
        $statement->execute([
            'user_id' => $user_id,
            'total_amount' => $total_amount,
            'transaction_id' => ''
        ]);

        // Step #2 => Retrieve Order ID using 'lastInsertID'
        // 'lastInsertID' => Retrieve the latest id that just inserted into the database
        $order_id = $this->database->lastInsertId();

        // Step #3 => Create orders_products bridge
        foreach ($products_in_cart as $product_id => $quantity) {
            $statement = $this->database->prepare('INSERT INTO orders_products(order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)');
            $statement->execute([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }
    }

    public function listAllOrders($user_id)
    {
        // Retrieve orders data from database based on the given user_id
        $statement = $this->database->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $statement->execute([
            'user_id' => $user_id
        ]);

        // Fetch all the orders data
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listProductsInOrder($order_id)
    {
        $statement = $this->database->prepare(
            'SELECT
         products.id, 
         products.name, 
         orders_products.order_id, 
         orders_products.quantity
         FROM orders_products
         JOIN products
         ON orders_products.product_id = products.id
         WHERE order_id = :order_id'
        );

        $statement->execute([
            'order_id' => $order_id
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
