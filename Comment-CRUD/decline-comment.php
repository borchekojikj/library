<?php



require_once '../Autoload.php';
require_once '../Classes/Comment.php';





$commentId = $_GET['id'];


$status = Comment::declineComment($commentId, $connObj);


if ($status) {
    header("Location: {$_SERVER['HTTP_REFERER']}?status=updated");
    die();
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}?status=error");
    die();
}
