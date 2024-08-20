<?php

require_once '../Autoload.php';

if ($_SESSION['status'] !== 'admin') {
    header("LOcation: ../index.php?error=accessdenied");
}

require_once '../Classes/Author.php';

$errors = [];




$fisrtname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$biography = trim($_POST['biography']);


$inputValues = [
    'firstname'  => trim($_POST['firstname']),
    'lastname' => trim($_POST['lastname']),
    'biography' => trim($_POST['biography']),
];


$reqFields = [
    'firstname', 'lastname'
];




foreach ($reqFields  as $field) {

    if (strlen($_POST[$field]) < 3) {
        $errors[$field] = ucfirst($field) . " hat to be minimum 3 Characters";
    }
}


if (strlen($_POST['biography']) < 20 || strlen($_POST['biography']) > 255) {
    $errors['biography'] =  "Biography hat to be minimum 20 Characters and maximum 255 Characters";
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: {$_SERVER['HTTP_REFERER']}?status=errors");
    die();
}





$author = new Author($fisrtname, $lastname, $biography, $connObj);





$status = $author->addAuthorToDatabase();



if ($status) {
    $_SESSION['data'] = '';
    header("Location: ../Admin-views/view-authors.php?status=success");
    die();
} else {
    header("Location: ../Admin-views/view-authors.php?status=error");
    die();
}
