<?php



require_once '../Autoload.php';
require_once '../Classes/Note.php';




$bookId = $_GET['bookId'];
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';



$notes = Note::fetchUserNotes($bookId, $userId, $connObj);


// Return notes data as JSON
echo json_encode($notes);
