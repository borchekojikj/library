<?php

session_start();



$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Sign Up</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-lightblue vh-100">

    <nav class="navbar transparent-nav">
        <a class="navbar-brand text-white rounded p-2 py-1 d-block ms-2 box-color" href="index.php">LIBRARY</a>
    </nav>


    <div class="user-container box-color text-white">
        <h1 class="text-center mb-4">Sign Up</h1>
        <form action="./Process-login-signup/process-signup.php" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label fw-bold">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter username" value="<?= isset($data['username']) ? $data['username'] : '' ?>">
                <?php if (!empty($errors['usernameErrors'])) : ?>
                    <div class="alert alert-danger mt-2">
                        <?php foreach ($errors['usernameErrors'] as $error) : ?>
                            <div><?= $error ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input id="password" type="password" class="form-control" placeholder="Enter password" name="password" value="<?= isset($data['password']) ? $data['password'] : '' ?>">
                <?php if (!empty($errors['passwordErrors'])) : ?>
                    <div class="alert alert-danger mt-2">
                        <?php foreach ($errors['passwordErrors'] as $error) : ?>
                            <div><?= $error ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>


            <div class="mb-3">
                <p>Already have an account? <a href="login.php" class="text-decoration-none">Log in</a></p>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
session_unset();
?>