<?php

session_start();

require "includes/functions.php";
require "includes/class-products.php";
require "includes/class-cart.php";

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                $cart->delete($_POST['id']);
                break;
            case 'plusOne':
                $cart->plusOne($_POST['id']);
                break;
            case 'minusOne':
                $cart->minusOne($_POST['id']);
                break;
            case 'setValue':
                $cart->setValue($_POST['id']);
                break;
        }
    }

    if (isset($_POST['product_id'])) {
        $cart->add($_POST['product_id']);
    }
}

// var_dump($_POST['product_id']);

?>

<?php

require "templates/header.php";

?>

<div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">

    <div class="min-vh-100">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h1">My Cart</h1>
        </div>


        <?php if ($cart->total() > 0) : ?>

            <!-- List of products user added to cart -->
            <table class="table table-hover table-bordered table-striped table-light">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ID</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($cart->listProductsInCart() as $items) : ?>
                        <tr class="text-center">
                            <td><?= $items['id'] ?></td>
                            <td><?= $items['name'] ?></td>
                            <td><?= "$" . $items['price'] ?></td>

                            <form action="<?= $_SERVER['REQUEST_URI'];  ?>" method="POST">
                                <input type="hidden" name="id" value="<?= $items['id'] ?>">
                                <input type="hidden" name="action" value="setValue">
                                <td><input class="quantity" name="quantity" type="number" value="<?= $items['quantity'] ?>"></td>
                            </form>

                            <td><?= "$" . $items['total'] ?></td>
                            <td>
                                <div class="d-flex justify-content-evenly">

                                    <form action="<?= $_SERVER['REQUEST_URI'];  ?>" method="POST">
                                        <input type="hidden" name="action" value="plusOne">
                                        <input type="hidden" name="id" value="<?= $items['id'] ?>">
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </form>

                                    <form action="<?= $_SERVER['REQUEST_URI'];  ?>" method="POST">
                                        <input type="hidden" name="action" value="minusOne">
                                        <input type="hidden" name="id" value="<?= $items['id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                    </form>

                                    <form action="<?= $_SERVER['REQUEST_URI'];  ?>" method="POST">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $items['id']; ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    <tr>
                        <td colspan="4" class="text-end">Total</td>
                        <td class="text-center">$<?= $cart->total(); ?></td>
                        <td></td>

                    </tr>
                </tbody>
            </table>
        <?php endif ?>

        <div class="d-flex justify-content-between align-items-center my-3">
            <?php if ($cart->total() <= 0) : ?>
                <p class="d-flex">Your cart is empty. Try adding something into the cart!</p>
                <a href="/" class="btn btn-success btn-sm">Continue Shopping</a>
            <?php endif ?>
            <?php if ($cart->total() > 0) : ?>
                <a href="/" class="btn btn-light btn-sm">Continue Shopping</a>
                <form action="/checkout" method="POST">
                    <button class="btn btn-primary">Checkout</button>
                </form>
            <?php endif ?>

        </div>

    </div>

    <!-- footer -->
    <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
        <div class="text-muted small">© 2022 <a href="/" class="text-muted">My Store</a></div>
        <div class="d-flex align-items-center gap-3">
            <a href="/login" class="btn btn-light btn-sm">Login</a>
            <a href="/signup" class="btn btn-light btn-sm">Sign Up</a>
            <a href="/order" class="btn btn-light btn-sm">My Orders</a>
        </div>
    </div>

</div>

<?php

require "templates/footer.php";

?>