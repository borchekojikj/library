<?php


require_once '../Autoload.php';
require_once '../Classes/Book.php';
require_once '../Classes/Author.php';
require_once '../Classes/Category.php';



$bookId = $_GET['id'];

$categories = Category::fetchCategories($connObj);
$authors = Author::fetchAuthors($connObj);
$bookData = Book::fetchBookWithId($bookId, $connObj);



if (isset($_POST['titleEdit']) && isset($_POST['publication_yearEdit']) && isset($_POST['number_of_pagesEdit']) && isset($_POST['photoEdit']) && isset($_POST['summaryEdit']) && isset($_POST['category_idEdit']) && isset($_POST['author_idEdit'])) {


    $data = [
        'id' => $bookId,
        'title' => $_POST['titleEdit'],
        'publication_year' => $_POST['publication_yearEdit'],
        'number_of_pages' => $_POST['number_of_pagesEdit'],
        'photo' => $_POST['photoEdit'],
        'summary' => $_POST['summaryEdit'],
        'category_id' => $_POST['category_idEdit'],
        'author_id' => $_POST['author_idEdit'],
    ];


    $status = Book::editBook($data, $connObj);


    if ($status) {
        header("Location: ../Admin-views/view-books.php?status=success");
        die();
    } else {
        header("Location:  ../Admin-views/view-books.php?status=error");
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

        <div class="row my-4">
            <div class="col-12">
                <div class="form">
                    <h1>Update Book</h1>
                    <form action="" method="POST">
                        <div class="form-group mb3">
                            <label for="title">Title</label>
                            <input value="<?= $bookData['title'] ?>" type="text" name="titleEdit" class="form-control" id="title" aria-describedby="firstname" placeholder="Enter firstname">
                        </div>
                        <div class="form-group mb-3">
                            <label for="publication_year">Publication Year</label>
                            <input value="<?= $bookData['publication_year'] ?>" id="publication_year" type="date" class="form-control" placeholder="Lastname" name="publication_yearEdit">
                        </div>
                        <div class="form-group mb-3">
                            <label for="number_of_pages">Number of Pages</label>
                            <input value="<?= $bookData['number_of_pages'] ?>" id="number_of_pages" type="number" class="form-control" placeholder="Lastname" name="number_of_pagesEdit">
                        </div>
                        <div class="form-group mb-3">
                            <label for="summary" class="form-label fw-bold">Summary</label>

                            <textarea type="text" class="form-control" placeholder="Write summary..." name="summaryEdit"><?= $bookData['summary'] ?></textarea>
                            <?= isset($errors['summary']) ? "<p class='alert alert-danger p-1 '>" . $errors['summary'] . "</p>" : "" ?>


                        </div>
                        <div class="form-group mb-3">
                            <label for="photo">Photo</label>
                            <input value="<?= $bookData['photo'] ?>" id="photo" type="text" class="form-control" placeholder="Lastname" name="photoEdit">
                        </div>

                        <div class="form-group mb-3">


                            <label for="model" class="form-label">Category</label>

                            <select id="type" class="form-select" name='category_idEdit' ?>">

                                <?php for ($i = 0; $i < count($categories); $i++) : ?>
                                    <?php if ($categories[$i]['id'] == $bookData['category_id']) {
                                        $bookId = $categories[$i]['id'];
                                        $title = $categories[$i]['title'];
                                        continue;
                                    } ?>
                                    <option value="<?= $categories[$i]['id'] ?>"><?= $categories[$i]['title'] ?></option>
                                <?php endfor; ?>
                                <option selected value="<?= $bookId  ?>"><?= $title ?></option>

                            </select>
                        </div>
                        <div class="form-group mb-3">


                            <label for="model" class="form-label">Author</label>




                            <select id="type" class="form-select" name='author_idEdit' ?>">

                                <?php for ($i = 0; $i < count($authors); $i++) : ?>
                                    <?php if ($authors[$i]['id'] == $bookData['author_id']) {
                                        $bookIdAuthor = $authors[$i]['id'];
                                        $titleAuthor = $authors[$i]['firstname'];
                                        continue;
                                    } ?>
                                    <option value="<?= $authors[$i]['id'] ?>"><?= $authors[$i]['firstname'] ?></option>
                                <?php endfor; ?>
                                <option selected value="<?= $bookIdAuthor  ?>"><?= $titleAuthor ?></option>

                            </select>
                        </div>
                        <button class="btn btn-success">Update Book</button>
                        <a href="../Admin-views/view-books.php" class="btn btn-dark">Cancel</a>
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