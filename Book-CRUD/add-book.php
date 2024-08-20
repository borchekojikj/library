<?php


require_once '../Autoload.php';
require_once '../Classes/Book.php';


$errors = [];


$reqFields = [
    'title', 'publication_year', 'number_of_pages', 'photo', 'category', 'author', 'summary'
];


foreach ($reqFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $fieldDisplay = str_replace("_", " ", $field);
        $errors[$field] = ucfirst($fieldDisplay) . " is required";
    }
}

if (isset($_POST['publication_year']) && $_POST['publication_year'] > date('Y-m-d')) {
    $errors['publication_year'] = "The Publication year can't be in the Future.";
}

if (isset($_POST['number_of_pages']) && $_POST['number_of_pages'] <= 0) {
    $errors['number_of_pages'] = "Nubmer of pages can't be zero or negative.";
}

if (isset($_POST['summary']) && strlen($_POST['summary']) > 500) {
    $errors['summary'] = "Summary can have max 500 Characters.";
}

function formatInputValues()
{

    $inputValues = [
        'title' => trim($_POST['title']),
        'publication_year' => trim($_POST['publication_year']),
        'number_of_pages' => trim($_POST['number_of_pages']),
        'photo' => trim($_POST['photo']),
        'summary' => trim($_POST['summary']),
        'category' => trim($_POST['category']),
        'author' => trim($_POST['author']),
    ];

    return $inputValues;
}


$inputValues = formatInputValues();




if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $inputValues;
    header("Location: {$_SERVER['HTTP_REFERER']}?status=errors");
    die();
}


$title = $_POST['title'];
$publication_year = $_POST['publication_year'];
$number_of_pages = $_POST['number_of_pages'];
$photo = $_POST['photo'];
$category = $_POST['category'];
$summary = $_POST['summary'];
$author = $_POST['author'];
$summary = $_POST['summary'];




$book = new Book($title, $publication_year, $number_of_pages, $photo, $summary, $author, $category, $connObj);


$status = $book->addBookToDatabase();


if ($status) {
    header("Location: ../Admin-views/view-books.php?status=success");
    die();
} else {
    header("Location: ../Admin-views/view-books.php?status=error");
    die();
}
