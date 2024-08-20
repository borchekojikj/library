<?php
require_once '../Autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../Classes/Note.php';


    // Retrieve the raw POST data
    $postData = file_get_contents("php://input");

    // Decode the JSON data
    $request = json_decode($postData);

    $noteId = $request->id;

    $success = note::deleteNoteById($noteId, $connObj);


    // Close the database connection

    // Return response
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete note']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID field is missing']);
}
