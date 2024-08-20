<?php


require_once '../Autoload.php';
require_once '../Classes/Author.php';



// Redirect if user is not an admin
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header("Location: index.php?error=accessdenied");
    exit;
}

$username = $_SESSION['username'] ?? '';

$authors = Author::fetchAuthors($connObj);

$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../style.css">

</head>

<body class="bg-lightblue">

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
        <h1 class="text-center my-5 text-white">Manage Authors</h1>

        <!-- Add Author Form -->
        <div class="row">
            <div class="col-md-6">
                <div class="card box-color text-white">
                    <div class="card-body">
                        <h5 class="card-title">Add New Author</h5>
                        <form action="../Author-CRUD/add-author.php" method="POST" id="myForm">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname</label>
                                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter Firstname" value="<?= isset($data['firstname']) ? $data['firstname'] : '' ?>">
                                <div> <?= isset($errors['firstname']) ? "<p class='alert alert-danger'>" . $errors["firstname"] . "</p>" : '' ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter Lastname" value="<?= isset($data['lastname']) ? $data['lastname'] : '' ?>">
                                <div> <?= isset($errors['lastname']) ? "<p class='alert alert-danger'>" . $errors["lastname"] . "</p>" : '' ?></div>

                            </div>
                            <div class="mb-3">
                                <label for="biography" class="form-label">Biography <span class="text-secondary">(max. 255 Characters)</span></label>
                                <textarea class="form-control" id="biography" rows="3" name="biography" placeholder="Enter Biography"><?= isset($data['biography']) ? $data['biography'] : '' ?></textarea>
                                <div id="charCount" class="text-end"></div>

                                <div> <?= isset($errors['biography']) ? "<p class='alert alert-danger'>" . $errors["biography"] . "</p>" : '' ?></div>

                            </div>
                            <button type="submit" class="btn btn-primary">Add Author</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>

        <!-- Author List -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="box-color">
                    <div class="card-body text-white">
                        <h5 class="card-title ms-4 py-4 h4">Author List</h5>
                        <table class="table table-striped text-white">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Biography</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const tableBody = document.getElementById('tableBody');

        function DisplayAuthors() {

            const authors = <?php echo json_encode($authors); ?>;
            authors.forEach(author => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-white">${author.id}</td>
                    <td class="text-white">${author.firstname}</td>
                    <td class="text-white">${author.lastname}</td>
                    <td class="text-white w-50">${author.biography}</td>
                    <td class="text-white">
                        <a href="../Author-CRUD/edit-author.php?id=${author.id}" class="btn btn-sm btn btn-dark"><i class="bi bi-pencil"></i> Edit</a>
                        <button class="btn btn-sm btn btn-danger deleteButton" data-authorid="${author.id}"><i class="bi bi-trash"></i> Delete</button>
                    </td>
                `;

                tableBody.appendChild(row);
            });
        }
        DisplayAuthors();
        // Adding event listener for delete buttons
        const deleteButtons = document.querySelectorAll('.deleteButton');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const authorId = this.getAttribute('data-authorid');
                const parentElement = this.parentNode
                const trElement = parentElement.parentNode;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure you want to delete this Author? The users won't see his Books in the Front-page.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "The Author was delete successfully!",
                            icon: "success"
                        })
                        deleteAuthor(authorId, trElement)
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your Author lives to see another day! :)",
                            icon: "error"
                        });
                    }
                });




            });

            function deleteAuthor(authorId, trElement) {

                fetch(`../Author-CRUD/delete-author.php?id=${authorId}`)
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        console.log(response.success);
                        if (response.success == true) {
                            console.log('Author updated successfully');
                            trElement.remove();
                        } else {
                            console.error('Failed to update note');
                        }
                    });
            }
        });

        const bioElement = document.getElementById('biography');
        const charCount = document.getElementById('charCount');

        bioElement.addEventListener('keyup', (e) => {
            const numberOfChar = e.target.value.length;
            charCount.innerHTML = `${numberOfChar}/255 Characters`;
        })
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php

unset($_SESSION['errors']);
unset($_SESSION['data']);

?>