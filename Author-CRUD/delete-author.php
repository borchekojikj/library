<?php



require_once '../Classes/Author.php';
require_once '../Autoload.php';


if ($_SESSION['status'] !== 'admin') {
    header("Location: index.php?error=accessdenied");
}

$authorId = $_GET['id'];





$status = Author::deleteAuthor($authorId, $connObj);


// Return response
if ($status) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete Author']);
}
