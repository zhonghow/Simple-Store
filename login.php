<?php

session_start();

require "includes/functions.php";
require "includes/class-authentication.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $auth = new Authentication();
    $error = $auth->login(
        $email,
        $password
    );
}

?>

<?php

require "templates/header.php";

?>

<div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
    <div class="min-vh-100">
        <!-- login form -->
        <div class="card rounded shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-3 py-3 border-bottom">
                    Login To Your Account
                </h5>
                
                <?php require "templates/erroralert.php"; ?>
                
                <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" />
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-fu">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- links -->
        <div class="d-flex justify-content-between align-items-center gap-3 mx-auto pt-3" style="max-width: 500px;">
            <a href="index.php" class="text-decoration-none small"><i class="bi bi-arrow-left-circle"></i> Go back</a>
            <a href="signup.php" class="text-decoration-none small">Don't have an account? Sign up here
                <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>

    <!-- footer -->
    <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
        <div class="text-muted small">
            © 2022 <a href="index.php" class="text-muted">My Store</a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="login.php" class="btn btn-light btn-sm">Login</a>
            <a href="signup.php" class="btn btn-light btn-sm">Sign Up</a>
            <a href="order.php" class="btn btn-light btn-sm">My Orders</a>
        </div>
    </div>
</div>

<?php

require "templates/footer.php";

?>