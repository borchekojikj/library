<?php

session_start();
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    require_once '../Classes/Note.php';
    require_once '../Autoload.php';



    // Retrieve the raw POST data
    $postData = file_get_contents("php://input");



    // Decode the JSON data
    $request = json_decode($postData);

    // Access the 'id' parameter
    $noteId = $request->id;
    $content = $request->content;


    // Delete the note from the database
    $success = Note::editNote($noteId, $content, $connObj);


    echo json_encode($success);
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
