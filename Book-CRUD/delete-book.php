<?php


require_once '../Autoload.php';
require_once '../Classes/Book.php';


$bookId = $_GET['id'];




$status = Book::deleteBook($bookId, $connObj);


// Return response
if ($status) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete Author']);
}
