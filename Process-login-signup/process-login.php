<?php


require_once '../Autoload.php';
require_once '../Classes/User.php';

$username = $_POST['username'];
$password = $_POST['password'];

$errors = [
    'usernameErrors' =>  [],
    'passwordErrors' => []
];

$inputValues = [
    'username'  => trim($_POST['username']),
    'password' => trim($_POST['password']),
];

if (empty($username)) {
    array_push($errors['usernameErrors'], 'Username is required!');
}


if (empty($password)) {
    array_push($errors['passwordErrors'], 'Password is required!');
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../login.php");
    die();
}








$user = new User($username, $password, $connObj);

if (!$user->userExists()) {
    array_push($errors['usernameErrors'], 'Invalid Password-Username combination');
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../login.php?");
    die();
}

$authUser = $user->authenticate();
if (!$authUser) {
    array_push($errors['passwordErrors'], 'Wrong password!');
}

if (!empty($errors['passwordErrors']) || !empty($errors['usernameErrors'])) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../login.php?");
    die();
}

if ($authUser['role'] == '1') {
    $_SESSION['isFirstLogin'] = true;
    $_SESSION['userId'] = $authUser['id'];
    $_SESSION['username'] = $authUser['username'];
    $_SESSION['status'] = 'admin';
    header("Location: ../index.php");
    die();
} else {
    $_SESSION['isFirstLogin'] = true;
    $_SESSION['username'] = $authUser['username'];
    $_SESSION['userId'] = $authUser['id'];
    $_SESSION['status'] = 'user';

    header("Location: ../index.php");
    die();
}
