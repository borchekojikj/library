<?php


require_once '../Autoload.php';
require_once '../Classes/Note.php';





// Retrieve the raw POST data
$postData = file_get_contents("php://input");



// Decode the JSON data
$request = json_decode($postData);

$note = $request->content;
$bookId = $request->bookId;
$userId = $request->userId;

if (strlen($note) === 0) {
    echo json_encode(['success' => 0, 'error' => 'Failed to delete note']);
    die();
}

$notetoSave = new Note($bookId, $userId, $note, $connObj);


$success = $notetoSave->addNoteToDatabase();


// $status = true;
if ($success) {
    echo json_encode(['success' => 1, 'error' => 'Failed to delete note']);
} else {
    echo json_encode(['success' => 0, 'error' => 'Failed to delete note']);
}
