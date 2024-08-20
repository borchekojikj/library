<?php


require_once '../Autoload.php';
require_once '../Classes/Comment.php';




$comment = $_POST['comment-text'];
$bookId = $_POST['bookId'];
$userId = $_POST['userId'];
$date = date('Y-m-d');
$status = 0;

if (!isset($comment) || $comment === '') {
    $_SESSION['errorComment'] = "Can't post an Epmty field!";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die();
}

$comment = new Comment($bookId, $status, $userId, $comment, $date, $connObj);

$hasComment = Comment::checkIfAuthorHasComment($bookId, $userId, $connObj);




if ($hasComment) {
    $_SESSION['error'] = 'Only one comment per Book is alowed!';
    header("Location: {$_SERVER['HTTP_REFERER']}#comments");
    die();
} else {
    $status = $comment->addCommentToDatabase();
    header("Location: {$_SERVER['HTTP_REFERER']}#comments");
    die();
}
