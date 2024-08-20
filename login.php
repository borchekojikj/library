<?php

session_start();

$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">


    <link rel="stylesheet" href="style.css">

</head>


<body class="bg-lightblue vh-100">

    <!-- Navbar -->
    <nav class="navbar transparent-nav">
        <a class="navbar-brand text-white box-color rounded p-2 py-1 d-block ms-2" href="./index.php">LIBRARY</a>
    </nav>

    <div class="user-container box-color text-white">

        <h1 class="text-center mb-4">Login</h1>
        <!-- Login Form -->
        <form action="./Process-login-signup/process-login.php" method="POST" class="mb-4">

            <div class="form-group mb-3">
                <label for="usernameInput" class="form-label fw-bold">Username</label>
                <input type="text" name="username" class="form-control" id="usernameInput" placeholder="Enter username" value="<?= isset($data['username']) ? $data['username'] : '' ?>">
                <div id="messageUsername">
                    <?php if (!empty($errors['usernameErrors'])) {

                        echo "<div class='alert alert-danger mt-2'>";

                        foreach ($errors['usernameErrors'] as $error) {
                            echo "<div>$error </div>";
                        }

                        echo "</div>";
                    } ?>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input id="password" type="password" class="form-control" placeholder="Enter password" name="password" value="<?= isset($data['password']) ? $data['password'] : '' ?>">
                <div id="messagePassword">
                    <?php if (!empty($errors['passwordErrors'])) {
                        echo "<div class='alert alert-danger mt-2'>";
                        foreach ($errors['passwordErrors'] as $error) {
                            echo "<div>$error </div>";
                        }
                        echo "</div>";
                    } ?>
                </div>
            </div>

            <p>Don't have an account yet? <a href="register.php" class="text-decoration-none">Sign up</a></p>
            <button class="btn btn-success w-100">Login</button>
        </form>

    </div>

    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>

<?php
session_unset();
?>