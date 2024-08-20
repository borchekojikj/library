<?php

require_once '../Autoload.php';
require_once '../Classes/Category.php';
require_once '../Classes/Author.php';

// Redirect if user is not an admin
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header("Location: index.php?error=accessdenied");
    exit; // Make sure to stop further execution
}




$categories = Category::fetchCategories($connObj);




$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];
$username = $_SESSION['username'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- Custom CSS -->
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

    <div class="container vh-100">
        <h1 class="text-center my-5 text-white">Manage Categories</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card box-color text-white">
                    <div class="card-body">
                        <h2>Add Category</h2>
                        <form action="../Category-CRUD/add-category.php" method="POST">
                            <div class="mb-3">
                                <label for="categoryInput" class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" id="categoryInput" placeholder="Enter category">
                                <div> <?= isset($errors['category']) ? "<p class='alert alert-danger'>" . $errors["category"] . "</p>" : '' ?></div>
                            </div>
                            <button type="submit" class="btn btn-success">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card box-color text-white">
                    <div class="card-body">
                        <h2 id="test">Categories</h2>
                        <table class="table table-striped">
                            <thead class="text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
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

        function displayCategories() {

            const cateogires = <?php echo json_encode($categories); ?>;


            cateogires.forEach(category => {

                const row = document.createElement('tr');
                row.innerHTML = `
                        <td class="text-white">${category.id}</td>
                        <td class="text-white">${category.title}</td>
   
  
                        <td class="text-white">
                        <a href="../Category-CRUD/edit-category.php?id=${category.id}&title=${category.title}" class="btn btn-sm btn btn-dark"><i class="bi bi-pencil"></i> Edit</a>
                        <button class="btn btn-sm btn btn-danger deleteButton" data-authorid="${category.id}"><i class="bi bi-trash"></i> Delete</button>
                        </td>
                             `;

                tableBody.appendChild(row);
            });
        }
        displayCategories();
        // Adding event listener for delete buttons
        const deleteButtons = document.querySelectorAll('.deleteButton');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const categoryId = this.getAttribute('data-authorid');


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
                    title: "Are you sure you want to delete this Category? The users won't see the Books with this Caregory in the Front-page.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "The Category was delete successfully!",
                            icon: "success"
                        })
                        deleteCategory(categoryId, trElement)
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your Category lives to see another day! :)",
                            icon: "error"
                        });
                    }
                });




            });


        });

        const test1 = document.getElementById('test');

        function deleteCategory(categoryId, trElement) {

            fetch(`../Category-CRUD/delete-category.php?id=${categoryId}`)
                .then(response => {

                    if (response.ok == true) {
                        console.log('Category updated successfully');
                        trElement.remove();
                    } else {
                        console.error('Failed to update note');
                    }
                });
        }
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>

</html>



<?php

unset($_SESSION['errors']);
unset($_SESSION['data']);

?>