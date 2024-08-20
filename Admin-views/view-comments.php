<?php



require_once '../Autoload.php';
require_once '../Classes/Comment.php';




// Redirect if user is not an admin
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header("Location: ../index.php?error=accessdenied");
    exit; // Make sure to stop further execution
}

$comments = Comment::fetchComments($connObj);
$username = $_SESSION['username'] ?? '';





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

<body class="bg-lightblue min-vh-100">


    <nav class="navbar navbar-expand-lg navbar-dark  bg-black border-bottom border-dark">
        <div class="container-fluid py-1 ">
            <div class="w-25 ">
                <a class="navbar-brand bg-secondary rounded-1 px-2 bg-opacity-25 border-bottom border-light" href="../adminDashboard.php">Admin Dashboard</a>
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
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="container">
        <div class="row h-100">
            <div class="col-12">
                <div class="form">
                    <h1 class="text-center my-5 text-white">Manage Commments</h1>
                    <div class=" text-center mb-3">
                        <buttom class="btn btn-light" id="allButton">Show all comments</buttom>
                        <buttom class="btn btn-light" id="aproveButton">Show declined comments</buttom>
                        <buttom class="btn btn-light" id="pendingButton">Show pending comments</buttom>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table box-color text-white">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Text</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="commentsContainer">
                    </tbody>


                </table>

            </div>
        </div>
    </div>


    <script>
        const container1 = document.getElementById('container1');
        const container2 = document.getElementById('commentsContainer');
        const comments = <?php echo json_encode($comments); ?>;
        const aproveButton = document.getElementById('aproveButton');
        const allButton = document.getElementById('allButton');
        const pendingButton = document.getElementById('pendingButton');


        aproveButton.addEventListener('click', (e) => {
            container2.innerHTML = '';
            const filterdComments = comments.filter((comment) => comment.status === 2);

            displayComments(filterdComments)
        });

        allButton.addEventListener('click', (e) => {
            container2.innerHTML = '';
            displayComments(comments)
        });

        pendingButton.addEventListener('click', (e) => {
            container2.innerHTML = '';
            const filterdComments = comments.filter((comment) => comment.status === 0);
            displayComments(filterdComments)
        });

        function displayComments(comments) {
            comments.forEach((comment) => {
                const rowElement = document.createElement('tr');
                rowElement.innerHTML = `

                        <td class="text-white" >${comment.id}</td>
                        <td class="text-white" >${comment.username}</td>
                        <td class="text-white">${comment.title}</td>
                        <td class="text-white w-50">${comment.comment_text}</td>
                               
            `;
                if (comment['status'] == 0) {

                    rowElement.innerHTML += `
                <td>
                <a href = "../Comment-CRUD/aprove-comment.php?id=${comment['id']}"
                class = "btn btn-dark bi bi-check2 mt-2 mt-xl-2 mt-xxl-2" > Aprove </a>
                <a href = "../Comment-CRUD/decline-comment.php?id=${comment['id']}"
                class = "btn btn-dark bi bi-dash-circle  mt-2 mt-xxl-2" > Decline </a>
                <a href="../Comment-CRUD/delete-comment.php?id=${comment['id']}" class="btn btn-danger bi bi-trash-fill pe-3 mt-2 mt-xxl-2"><span class="text-white ps-1">Delete</span></a>
               </td> `;
                }
                if (comment['status'] == 2) {

                    rowElement.innerHTML += `
                <td>
                <a href = "../Comment-CRUD/aprove-comment.php?id=${comment['id']}"
                class = "btn btn-dark bi bi-check2  mt-2 mt-xxl-2" > Aprove </a>
                <a href="../Comment-CRUD/delete-comment.php?id=${comment['id']}" class="btn btn-danger bi bi-trash-fill pe-3 mt-2 mt-xxl-2"><span class="text-white ps-1">Delete</span></a>
                </td>`;
                }

                if (comment['status'] == 1) {

                    rowElement.innerHTML += `
                
             <td>
                <a href="../Comment-CRUD/delete-comment.php?id=${comment['id']}" class="btn btn-danger bi bi-trash-fill pe-3 mt-2 mt-xxl-0"><span class="text-white ps-1">Delete</span></a>
                </td>`;
                }
                container2.appendChild(rowElement);

            });
        }

        displayComments(comments)
    </script>


    <!-- POPPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>