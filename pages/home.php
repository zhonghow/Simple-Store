<?php

session_start();

require "includes/functions.php";
require "includes/class-products.php";

$products = new Products();

$products_list = $products->listAllProducts();
?>

<?php

require "templates/header.php";

?>

<div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
    <div class="min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h1">My Store</h1>
            <div class="d-flex align-items-center justify-content-end gap-3">

                <?php if (isLoggedIn()) : ?>
                    <a href="/cart" class="btn btn-success">My Cart</a>
                    <a href="/logout" class="btn btn-danger">Log Out</a>
                <?php endif ?>

                <?php if (!isLoggedIn()) : ?>
                    <a href="/cart" class="btn btn-success d-flex justify-content-center align-items-center">My Cart</a>
                <?php endif ?>

            </div>
        </div>

        <!-- products -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($products_list as $items) : ?>
                <div class="col">
                    <div class="card h-100 border border-0 shadow">
                        <img src="<?= $items['image_url'] ?>" class="card-img-top" alt="<?= $items['name'] ?>" />
                        <div class="card-body text-center">
                            <h5 class="card-title m-0"><?= $items['name'] ?></h5>
                            <p class="card-text mb-2"><?= "$" . $items['price'] ?></p>

                            <!-- 
                                action="/cart" => when button is click, user will go to cart page
                            -->
                            <form action="/cart" method="POST">
                                <!-- 
                                    product id will pass to the cart page
                                 -->
                                <input type="hidden" name="product_id" value="<?= $items['id']; ?>">
                                <button class="btn btn-primary">Add to cart</button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>


    <!-- footer -->
    <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
        <div class="text-muted small">
            © 2022 <a href="/" class="text-muted">My Store</a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <?php if (isLoggedIn()) : ?>
                <a href="/order" class="btn btn-light btn-sm">My Orders</a>
                <a href="/logout" class="btn btn-light btn-sm">Log Out</a>
            <?php endif ?>
            <?php if (!isLoggedIn()) : ?>
                <a href="/login" class="btn btn-light btn-sm">Login</a>
                <a href="/signup" class="btn btn-light btn-sm">Sign Up</a>
            <?php endif ?>
        </div>
    </div>
</div>

<?

require "templates/footer.php";

?>