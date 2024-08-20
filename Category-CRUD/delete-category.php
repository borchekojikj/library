<?php

require_once '../Autoload.php';

require_once '../Classes/Category.php';


$categoryId = $_GET['id'];

$status = Category::deleteCategory($categoryId, $connObj);



if ($status) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete Author']);
}
