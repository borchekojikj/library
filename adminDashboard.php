<?php

require_once './Autoload.php';

if ($_SESSION['status'] !== 'admin') {
    header("LOcation: index.php?error=accessdenied");
}


require_once './Classes/Comment.php';

$pendingComments = Comment::fetchAllPendingComments($connObj);

$numberForPendingComments = count($pendingComments);

$username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- FONT AWSOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="style.css">


</head>

<body class="bg-lightblue">

    <nav class="navbar navbar-expand-lg navbar-dark  bg-black border-bottom border-dark">
        <div class="container-fluid py-1 ">
            <div class="w-25 ">
                <a class="navbar-brand bg-secondary rounded-1 px-2 bg-opacity-25 border-bottom border-light" href="index.php">Brainster Library</a>
            </div>


            <div class="w-50 text-center">
                <span class="text-white"><?= $username ?></span>
            </div>



            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse  justify-content-lg-end" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="container vh-100">
        <h1 class="text-center my-5 text-white">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="./Admin-views/view-authors.php" class="btn btn-primary btn-lg btn-block btn-box">
                    <i class="fas fa-users"></i>
                    <span class="px-5">Manage Authors</span>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="./Admin-views/view-categories.php" class="btn btn-secondary btn-lg btn-block btn-box">
                    <i class="fas fa-list-alt"></i>
                    <span class="px-5">Manage Categories</span>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="./Admin-views/view-books.php" class="btn btn-success btn-lg btn-block btn-box">
                    <i class="fas fa-book-open"></i>
                    <span class="px-5">Manage Books</span>
                </a>
            </div>

            <div class="col-md-6 mb-4 ">
                <a href="./Admin-views/view-comments.php" class="btn btn-info btn-lg btn-block btn-box" id="commentContainer">
                    <i class="fas fa-comments text-white"></i><span class="px-5 text-white">Manage Comments</span>
                </a>
                <?php
                if ($numberForPendingComments !== 0) {
                    echo "<span id='commentInfo'></span>";
                }
                ?>

            </div>
        </div>
    </div>

    <script>
        const commentContainer = document.getElementById('commentContainer');
        const number = <?php echo json_encode($numberForPendingComments); ?>;
        const commentInfo = document.getElementById('commentInfo');
        commentInfo.innerHTML = +number;
        commentContainer.addEventListener('mouseover', (e) => {
            commentInfo.style.left = '100%';
            commentInfo.style.button = '95%';

        })

        commentContainer.addEventListener('mouseout', (e) => {
            commentInfo.style.left = '97%';
            commentInfo.style.button = '93%';
        })
    </script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>