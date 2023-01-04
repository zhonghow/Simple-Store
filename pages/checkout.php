<?php

session_start();

require "includes/functions.php";
require "includes/class-products.php";
require "includes/class-orders.php";
require "includes/class-cart.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Error Check (Cart is empty) //
    if (empty($_SESSION['cart'])) {
        $error = "Your cart is empty";
    }

    // Error Check (User is logged in) //
    if (!isLoggedIn()) {
        $error = "You must be logged in to checkout";
    }

    // Proceed if no error //

    if (!isset($error)) {
        $orders = new Orders();
        $cart = new Cart();

        // Create a new order //
        $orders->createNewOrder(
            $_SESSION['user']['id'], // User ID => $user_id
            $cart->total(), // Total Amount => $total_amount
            $_SESSION['cart'] // Products in the cart => $products_in_cart

        );

        // Empty Cart //
        $cart->emptyCart();

        header('Location:/order');
        exit;
    }
}


require "templates/header.php";
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger mb-3">
                    <?= $error ?>
                </div>
            <?php else : ?>
                <div class="alert alert-danger mb-3">
                    Something went wrong!
                </div>
            <?php endif ?>
            <a href="/cart" class="btn btn-primary">Back to cart</a>
        </div>
    </div>
</div>

<?php
require "templates/footer.php";
?>