<?php


require_once './Autoload.php';

require_once './Classes/Book.php';
require_once './Classes/Author.php';
require_once './Classes/Category.php';
require_once './Classes/Comment.php';
require_once './Classes/Note.php';


$bookId  = $_GET['id'];



if (isset($_SESSION['userId'])) {
    $_SESSION['userId'];
}

$userId = isset($_SESSION['userId']) ? (int)$_SESSION['userId'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$status = isset($_SESSION['status']) ?? '';


$book1 = Book::fetchBookWithId($bookId, $connObj);
$author1 = Author::fetchAuthorWithId($book1['author_id'], $connObj);
$category1  = Category::fetchCategorieWithId($book1['category_id'], $connObj);
$comments = Comment::fetchCommentsForBook($book1['id'], $connObj);
$notes = Note::fetchUserNotes($book1['id'], $userId, $connObj);

$noComment = false;


?>

<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="style.css">
    <style>

    </style>


</head>

<body class="bg-lightblue">

    <nav class="navbar navbar-expand-lg navbar-dark  bg-black border-bottom border-dark">
        <div class="container-fluid py-1 ">
            <div class="w-25">
                <a class="navbar-brand bg-secondary rounded-1 px-2 bg-opacity-25 border-bottom border-light" href="index.php">Brainster Library</a>
            </div>

            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'admin') { ?>
                <div class="w-50 text-center">
                    <a href="adminDashboard.php" class="btn btn-danger px-3 py-1">Admin Dashboard</a>
                </div>
            <?php } else { ?>
                <div class="w-50 text-center">
                    <span class="text-white"><?= $username ?></span>
                </div>
            <?php } ?>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse  justify-content-lg-end" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <?php if (isset($_SESSION['status'])) { ?>
                        <?php if ($_SESSION['status'] === 'user') {
                            echo "<li class='nav-item'>
                                        <a class='nav-link' href='#' type='button'  data-bs-toggle='modal' data-bs-target='#exampleModal'>Apply</a>
                                      </li>";
                        } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </nav>
    <div class="container-fluid">

        <div class="row justify-content-center">

            <!-- Content Container -->
            <div class="col-sm-12 col-md-7 col-lg-8 cl  pb-4">

                <!-- Book Information Section -->
                <div class="row  py-5 rounded text-bold">
                    <div class="col-lg-7 col-xxl-5 h-50">
                        <img src="<?= $book1['photo'] ?>" class="w-100" style="height: 550px;" alt="">
                    </div>
                    <div class="col-lg-5 text-black">
                        <h1><?= $book1['title']  ?></h1>
                        <p>Author: <?= $author1['firstname'] . " " . $author1['lastname'] ?> </p>
                        <p>Year of issue: <?= $book1['publication_year'] ?></p>
                        <p>Number of pages: <?= $book1['number_of_pages'] ?></p>
                        <p>Category: <?= $category1['title'] ?></p>
                        <p><b>Summary: </b><br><?= $book1['summary'] ?></p>


                    </div>
                </div>

                <!-- About Author Section -->
                <div class="row mt-5">
                    <div class="col-md-12 mt-3 bg-dark p-5 text-light">
                        <h3><b>About the Author</b></h3>
                        <p class="h4"><?= $author1['firstname'] . " " . $author1['lastname'] ?> </p>
                        <p><?= $author1['biography'] ?></p>
                    </div>
                </div>

                <!-- Comment Section -->
                <div class="row">
                    <div class="comment-section mt-5 book-display-bg" id="comments">
                        <h3 class="mb-4">Comments</h3>

                        <!-- Error for Double comment -->
                        <?php if (!empty($_SESSION['error'])) {
                            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                        }
                        ?>

                        <!-- <div> -->
                        <?php foreach ($comments as $comment) : ?>
                            <!-- Stops the loop to render Comments that are declined or pending and are not from the User -->
                            <?php if (($comment['status'] == 2 || $comment['status'] == 0) && $comment['user_id'] !== (int)$userId) {
                                continue;
                            }
                            ?>

                            <?php
                            if ($comment['status'] === 1 || $comment['user_id'] === (int)$userId) {
                                $noComment = true;
                            }
                            ?>
                            <!-- Opens new container for every Comment -->
                            <div class="border p-2 rounded mt-2">
                                <!-- Checks if the current Loop comment is from the Logged In user -->

                                <?php if ($comment['user_id'] === $userId) { ?>

                                    <!-- Displays the username  -->
                                    <p class="mb-0"><span class="fw-bold text-dark"><?= $_SESSION['username'] ?></span>

                                        <!-- Check if the comment is declined of pending, and inserts the span element acordingly -->
                                        <?php
                                        if ($comment['status'] == 0) {
                                            echo "<span data-bs-toggle='tooltip' data-bs-placement='top' data-bs-custom-class='custom-tooltip' title='Waiting for aproval from Admin.'>Pending...</span>";
                                        } else if ($comment['status'] == 2) {
                                            echo "<span data-bs-toggle='tooltip' data-bs-placement='top' title='Your comment has been decliend by the Admin.'>Declined</span>";
                                        }
                                        ?>

                                        <!-- Enter the Date when the Comment was Postet -->
                                        <span class="text-secondary"><?= $comment['date'] ?></span>
                                        <a href="./Comment-CRUD//delete-comment.php?id=<?= $comment['id'] ?>" class="btn btn-sm btn-danger">Delete</a>

                                    </p>
                                    <!-- Enter the Comment text -->
                                    <p><?= $comment['comment_text'] ?></p>
                            </div>

                            <!-- Closes the Div element(comment Container) and skips the code for this Loop, to prevent doplicate comment from user -->
                        <?php
                                    continue;
                                } ?>

                        <!-- Checks if the Commen is aproved, and renders it in the Container -->
                        <?php
                            if ($comment['status'] == 1) {
                                echo "<p class='mb-0'><span class='fw-bold text-dark'>" . $comment['username'] . "</span> <span class='text-secondary'>" . $comment['date'] .  "</span></p>";
                                echo "<p>" . $comment['comment_text'] . "</p>";
                                echo " </div>";
                            } ?>

                    <?php endforeach; ?>
                    <?php

                    if (!$noComment) {
                        echo "No comments for this Book jet";
                    }
                    ?>
                    </div>

                    <!-- Checks if the user is logged in, if yes enables the comment Textare, else a message to log in -->
                    <?php if (isset($_SESSION['status'])) : ?>
                        <form action="./Comment-CRUD/post-comment.php" method="POST" class="mt-3">
                            <input type="hidden" value="<?= $book1['id'] ?>" name="bookId">
                            <input type="hidden" value="<?= $userId  ?>" name="userId">
                            <textarea type="text" class="form-control" placeholder="Write your comment..." name="comment-text"></textarea>
                            <div> <?= isset($_SESSION['errorComment']) ? "<p class='alert alert-danger'>" . $_SESSION['errorComment'] . "</p>" : '' ?></div>

                            <button type="submit" class="btn btn-dark mt-2">Post</button>
                        </form>
                    <?php else : ?>
                        <div class="text-muted mt-3 bg-white p-2 rounded bg-opacity-50">
                            <a href="login.php" class="text-decoration-none">Login</a> to write a comment.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Notes -->
            <?php if (isset($_SESSION['status'])) : ?>
                <button id="buttonNotes" type="button" class="btn bg-light text-black btn-light me-2 d-none d-md-block bg-opacity-50" data-mdb-ripple-init data-mdb-ripple-color="dark">Show notes</button>
                <div class="col-4 mt-5  hideContainer" id="notes-container">
                    <p class="h2 text-center text-white">Personal Notes for Book!</p>
                    <div class="notes-list"></div>
                    <form action="" class="comment-form">
                        <textarea type="text" class="form-control" placeholder="Write your note..." name="note" id="newNote"></textarea>
                        <div id="errorNote"> </div>
                        <button type="submit" class="btn btn-dark mt-2" id="saveButton">Save</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content box-color text-white pb-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">You want to Publish your own Book?</h1>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Send us your contact Details</p>

                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text text-white">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Telephone Number</label>
                            <input type="number" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Send us a Copy of your Book.</label>
                            <input type="file" class="form-control" id="fileInput" aria-describedby="fileHelp">
                            <div id="fileHelp" class="form-text text-white">The informations will be held strongly confidential!</div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>

                        <button type="submit" class="btn text-white bg-success bg-opacity-50">Apply</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const status = <?php echo json_encode($status); ?>;
        const bookId = <?= $book1['id'] ?>;
        const userId = <?= $userId ?>;
    </script>


    <script src="./Javascript/display-book.js"></script>
    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>



<?php

unset($_SESSION['error']);
unset($_SESSION['errorComment']);
unset($_SESSION['errorNote']);

?>