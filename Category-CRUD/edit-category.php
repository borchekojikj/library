<?php

require_once '../Autoload.php';
require_once '../Classes/Category.php';


$categoryId = $_GET['id'];
$categoryTitle = $_GET['title'];

var_dump($_POST);

if (isset($_POST['newCategory'])) {
    echo "TEST";
    Category::editCategory($categoryId, $_POST['newCategory'], $connObj);

    if ($status) {
        header("Location: ../Admin-views/view-categories.php?status=success");
        die();
    } else {
        header("Location: ../Admin-views/view-categories.php?status=error");
        die();
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
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
    <link rel="stylesheet" href="../style.css">
</head>

<body class="bg-lightblue">


    <div class="container vh-100 text-white">

        <div class="row justify-content-center">
            <div class="col-8">
                <h1 class="my-5">Update Category</h1>

                <div class="form">
                    <form action="" method="POST">
                        <div class="form-group mb3">
                            <label for="newCategory">Category</label>
                            <input type="text" name="newCategory" class="form-control" id="newCategory" placeholder="Enter Category" value="<?= $categoryTitle ?>">
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Update</button>
                        <a href="../Admin-views/view-categories.php" class="btn btn-dark mt-2">Back to Categories</a>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>