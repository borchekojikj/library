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
    header("Location: ../register.php");
    die();
}





if (preg_match('/\s/', $username)) {
    array_push($errors['usernameErrors'], 'Spaces in the username are not allowed!');
}

if ((int)strlen($username) < 5) {
    array_push($errors['usernameErrors'], 'Username has to be minimum 5 Charachters!');
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../register.php?");
    die();
}

if (!preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
    array_push($errors['passwordErrors'], 'Password hash to include minimum one Capital and one Special Character!');
}

if ((int)strlen($password) < 8) {
    array_push($errors['passwordErrors'], 'Password has to be minimum 8 Charachters!');
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../register.php?");
    die();
}


$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$user = new User($username, $passwordHash, $connObj);

if ($user->userExists()) {
    array_push($errors['usernameErrors'], 'Username already taken!');
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../register.php?");
    die();
}


if (!empty($errors['passwordErrors']) || !empty($errors['usernameErrors'])) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: ../register.php?");
    die();
}




$status = $user->saveUserToDatabase();

$userId =  $connObj->lastInsertId();

if ($status) {
    $_SESSION['isFirstLogin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['userId'] = $userId;
    $_SESSION['status'] = 'user';
    header("Location: ../index.php?status=success");
    die();
} else {
    header("Location: ../index.php?status=error");
    die();
}
