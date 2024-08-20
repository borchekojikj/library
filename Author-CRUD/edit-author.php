<?php


require_once '../Autoload.php';

if ($_SESSION['status'] !== 'admin') {
    header("Location: index.php?error=accessdenied");
}


require_once '../Classes/Author.php';



$authorId = $_GET['id'];



$authorData = Author::fetchAuthorWithId($authorId, $connObj);

$firstname = $authorData['firstname'];
$lastname = $authorData['lastname'];
$biography = $authorData['biography'];


$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];




if (isset($_POST['firstnameEdit']) && isset($_POST['lastnameEdit']) && isset($_POST['biographyEdit'])) {

    $firstname = trim($_POST['firstnameEdit']);
    $lastname = trim($_POST['lastnameEdit']);
    $biography = trim($_POST['biographyEdit']);

    $errors = [];

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'biography' => $biography,
        'id' => $authorId
    ];

    if (strlen($firstname) < 3) {
        $errors['firstname'] = "Firstname hat to be minimum 3 Characters";
    }

    if (strlen($lastname) < 3) {
        $errors['lastname'] = "Lastname hat to be minimum 3 Characters";
    }

    if (strlen($biography) < 20) {
        $errors['biography'] =  "Biography hat to be minimum 20 Characters";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ../Admin-views/edit-author.php?id=$authorId");
        die();
    }




    $status = Author::editAuthor($data, $connObj);

    if ($status) {
        header("Location: ../Admin-views/view-authors.php?status=success");
        die();
    } else {
        header("Location: ../Admin-views/view-authors.php?status=error");
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
        <h1 class="my-4">Edit Author</h1>

        <div class="row">
            <div class="col-12">
                <div class="form">
                    <h2>Author</h2>
                    <form action="" method="POST">
                        <div class="form-group mb3">
                            <label for="firstname">Firstname</label>
                            <input value="<?= $firstname ?>" type="text" name="firstnameEdit" class="form-control" id="firstname" aria-describedby="firstname" placeholder="Enter firstname">
                            <div> <?= isset($errors['firstname']) ? "<p class='alert alert-danger'>" . $errors["firstname"] . "</p>" : '' ?></div>

                        </div>
                        <div class="form-group mb-3">
                            <label for="lastname">Lastname</label>
                            <input value="<?= $lastname ?>" id="text" type="text" class="form-control" placeholder="Lastname" name="lastnameEdit">
                            <div> <?= isset($errors['lastname']) ? "<p class='alert alert-danger'>" . $errors["lastname"] . "</p>" : '' ?></div>

                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Biography</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="biographyEdit"><?= $biography ?></textarea>
                            <div> <?= isset($errors['biography']) ? "<p class='alert alert-danger'>" . $errors["biography"] . "</p>" : '' ?></div>

                        </div>
                        <button class="btn btn-success">Update Author</button>
                        <a href="../Admin-views/view-authors.php" class="btn btn-dark">Back to Authors</a>
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

<?php

unset($_SESSION['errors']);
unset($_SESSION['data']);

?>