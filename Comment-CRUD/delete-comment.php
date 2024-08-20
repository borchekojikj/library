<?php


require_once '../Autoload.php';
require_once '../Classes/Comment.php';



$commentId = $_GET['id'];



$status =  Comment::deleteComment($commentId, $connObj);


if ($status) {
    header("Location: {$_SERVER['HTTP_REFERER']}#comments");
    die();
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}#comments");
    die();
}
