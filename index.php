<?php


require_once './Autoload.php';
require_once './Classes/Book.php';
require_once './Classes/Category.php';
require_once './Classes/Comment.php';


$books = Book::fetchBooks($connObj);
$categories = Category::fetchCategories($connObj);

$user = $_SESSION['status'] ?? '';
$username = $_SESSION['username'] ?? '';
$userId = $_SESSION['userId'] ?? '';

// print_r($books);
$userComments = Comment::fetchCommentsForUser($userId, $connObj);
$numberOfComments = 0;

if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
    $comments = Comment::fetchAllPendingComments($connObj);
    $numberOfComments = count($comments);
}

$isFirstLogin = $_SESSION['isFirstLogin'] ?? '';


?>

<!DOCTYPE html>
<html>

<head>
    <title>Brainster Library</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- SEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>


    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark  bg-black border-bottom border-dark">
            <div class="container-fluid py-1 ">
                <div class="w-25">
                    <span class="navbar-brand px-2" href="index.php">Brainster Library</span>
                </div>

                <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'admin') { ?>
                    <div class="w-50 text-center">
                        <a href="adminDashboard.php" class="btn btn-danger px-3 py-1">Admin Dashboard</a>
                    </div>
                <?php } else { ?>
                    <div class="w-50 text-center" id="name">
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
                                <a class="nav-link" href="register.php">Sign Up</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </nav>

        <div class="banner">
            <div class="container1">
                <div class="box" id="bannerContainer">
                </div>
                <div class="btns">
                    <div class="btn prev"></div>
                    <div class="btn next"></div>
                </div>
            </div>
        </div>

    </header>


    <!-- Main -->
    <main>
        <div class="container-fluid">

            <h2 class="text-center mt-5 madimi-one-regular">Books Catalogue</h2>

            <div class="text-center mt-4">

                <!-- Container for the filters -->

                <div class="row mb-5">
                    <div class="col-12">
                        <div class="filters" id="filters">
                        </div>
                    </div>
                </div>

                <!-- Container for the Cards -->

                <div class="row ">
                    <div class="col-12">
                        <div class="d-flex gap-5 flex-wrap justify-content-center" id="bookContainer">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php require_once './Components/footer.html'; ?>

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
        // SEETALERT FOR ADMIN
        const user = <?php echo json_encode($user); ?>;
        const username = <?php echo json_encode($username); ?>;
        const numberOfComments = <?php echo json_encode($numberOfComments); ?>;
        const isFirstLogin = <?php echo json_encode($isFirstLogin) ?>;
        // Banner 
        const books = <?php echo json_encode($books); ?>;
        // MAIN
        const categories = <?php echo json_encode($categories); ?>;
        // USER COMMENTS
        const userComments = <?php echo json_encode($userComments); ?>;
        // LOGIN STATUS
        let loginStatus = <?php echo json_encode($isFirstLogin); ?>;
    </script>

    <script src="./Javascript/index.js"></script>

    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>

<?php
$_SESSION['isFirstLogin'] = false;

?>