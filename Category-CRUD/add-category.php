<?php



require_once '../Autoload.php';
require_once '../Classes/Category.php';

$categoryTitle = ucfirst($_POST['category']);

$errors = [];



if (strlen($categoryTitle) < 3) {
    $errors['category'] = "Category hat to be minimum 3 Characters";
    $_SESSION['errors'] = $errors;
    header("Location: {$_SERVER['HTTP_REFERER']}?status=errors");
    die();
}


Category::addCategoryToDatabase($categoryTitle, $connObj);


if ($status) {
    header("Location: ../Admin-views/view-categories.php?status=success");
    die();
} else {
    header("Location: ../Admin-views/view-categories.php?status=error");
    die();
}
