<?php

class Cart
{
    public $database;
    public function __construct()
    {
    }

    public function listProductsInCart()
    {

        $list = [];
        //Check if cart is empty or not
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $products_object = new Products();
                $product = $products_object->findProduct($product_id);
                // push product id and quantity 
                $list[] = [
                    'id' => $product_id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'total' => $product['price'] * $quantity,
                    'quantity' => $quantity
                ];
            }
        }
        return $list;
    }

    public function add($product_id)
    {
        // Check if there is existing data in $SESSION['cart']
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        } else {
            $cart = [];
        }

        // Check if the product id exist in the cart or not
        if (isset($cart[$product_id])) {
            // add product_id to $cart
            $cart[$product_id] += 1; // +1 quantity
        } else {
            $cart[$product_id] = 1; // quantity
        }

        // assign $cart to $_SESSION['cart']
        $_SESSION['cart'] = $cart;
    }

    public function total()
    {
        $cart_total = 0;

        // get all products in cart

        $list = $this->listProductsInCart();

        // calculate the cart total
        foreach ($list as $products) {
            $cart_total += $products['total'];
        }

        return $cart_total;
    }

    public function delete($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    public function plusOne($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            ++$_SESSION['cart'][$product_id];
        }
    }
    
    public function minusOne($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            if ($_SESSION['cart'][$product_id] <= 1) {

                unset($_SESSION['cart'][$product_id]);
            } else {
                --$_SESSION['cart'][$product_id];
            }
        }
    }

    public function setValue($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {

            if ($_POST['quantity'] < 1) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $_POST['quantity'];
            }
        }
    }
}
