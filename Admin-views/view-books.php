<?php


require_once '../Autoload.php';


require_once '../Classes/Book.php';
require_once '../Classes/Author.php';
require_once '../Classes/Category.php';



// Redirect if user is not an admin
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header("Location: ../index.php?error=accessdenied");
    exit;
}


// Fetch categories, authors, and books
$categories = Category::fetchCategories($connObj);


$authors = Author::fetchAuthors($connObj);


$books = Book::fetchBooks($connObj);


$errors = $_SESSION['errors'] ?? [];
$data = $_SESSION['data'] ?? [];
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../style.css">

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </style>
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

    <div class="container-fluid text-white">
        <h1 class="text-center my-5">Manage Books</h1>
        <div class="row justify-content-center">
            <div class="col-md-10 ">
                <!-- Row 1 -->
                <div class="col-md-12">
                    <div class="card box-color">
                        <div class="card-body">
                            <h5 class="card-title text-center my-3">Add New Author</h5>
                            <div class="form">

                                <form action="../Book-CRUD/add-book.php" method="POST">
                                    <div class="row">
                                        <!-- Col 1 -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="title" class="form-label fw-bold">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="<?= isset($data['title']) ? $data['title'] : '' ?>">
                                                <div> <?= isset($errors['title']) ? "<p class='alert alert-danger'>" . $errors["title"] . "</p>" : '' ?></div>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="publication_year" class="form-label fw-bold">Publication Year</label>
                                                <input type="date" class="form-control" id="publication_year" placeholder="Publication Year" name="publication_year" value="<?= isset($data['publication_year']) ? $data['publication_year'] : '' ?>">
                                                <div> <?= isset($errors['publication_year']) ? "<p class='alert alert-danger'>" . $errors["publication_year"] . "</p>" : '' ?></div>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="number_of_pages" class="form-label fw-bold">Number of Pages</label>
                                                <input type="number" class="form-control" id="number_of_pages" placeholder="Number of Pages" name="number_of_pages" value="<?= isset($data['number_of_pages']) ? $data['number_of_pages'] : '' ?>">
                                                <div> <?= isset($errors['number_of_pages']) ? "<p class='alert alert-danger'>" . $errors["number_of_pages"] . "</p>" : '' ?></div>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="summary" class="form-label fw-bold">Summary</label>

                                                <textarea type="text" class="form-control" id="biography" rows="5" placeholder="Write summary..." name="summary"><?= isset($data['summary']) ? $data['summary'] : '' ?></textarea>
                                                <div id="charCount" class="text-end"></div>
                                                <?= isset($errors['summary']) ? "<p class='alert alert-danger p-1 '>" . $errors['summary'] . "</p>" : "" ?>


                                            </div>

                                        </div>
                                        <!-- Col 2 -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="photo" class="form-label fw-bold">Photo</label>
                                                <input type="text" class="form-control" id="photo" placeholder="Photo URL" name="photo" value="<?= isset($data['photo']) ? $data['photo'] : '' ?>">
                                                <div> <?= isset($errors['photo']) ? "<p class='alert alert-danger'>" . $errors["photo"] . "</p>" : '' ?></div>

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="category" class="form-label fw-bold">Category</label>
                                                <select id="category" class="form-select" name='category'>
                                                    <option selected disabled>Open this select menu</option>
                                                    <?php foreach ($categories as $category) : ?>
                                                        <?php
                                                        $selectedModel  = ($category['id'] == $data['category']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $category['id'] ?>" <?= $selectedModel ?>><?= $category['title'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= isset($errors['category']) ? "<p class='alert alert-danger p-1 '>" . $errors['category'] . "</p>" : "" ?>
                                            </div>


                                            <div class="form-group mb-3">

                                                <label for="author1" class="form-label fw-bold">Author</label>
                                                <select id="author1" class="form-select" name='author'>
                                                    <option selected disabled>Open this select menu</option>
                                                    <?php foreach ($authors as $author) : ?>
                                                        <?php
                                                        $selectedModel  = ($author['id'] == $data['author']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $author['id'] ?>" <?= $selectedModel ?>><?= $author['firstname'] . " " . $author['lastname'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= isset($errors['author']) ? "<p class='alert alert-danger p-1 '>" . $errors['author'] . "</p>" : "" ?>

                                                <?php

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success">Add Book</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="col-md-12">
                    <h2 class="my-4 text-white">List of Books</h2>
                    <table class="table table-striped box-color">
                        <thead class="text-white">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Publication Year</th>
                                <th>Photo</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-white " id="tableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <script>
        const tableBody = document.getElementById('tableBody');

        // Function to create a row for all the Books that were fetched.
        function displayBooks() {

            const books = <?php echo json_encode($books); ?>;


            books.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="text-white">${book.id}</td>
                                    <td class="text-white">${book.title}</td>
                                    <td class="text-white">${book.firstname} ${book.lastname}</td>
                                    <td class="text-white">${book.category}</td>
                                    <td class="text-white">${book.publication_year}</td>
                                    <td> <img src="${book.photo}" alt="" width="60px" height="75px"></td>

                                    <td>
                                        <a href="../Book-CRUD/edit-book.php?id=${book.id}" class="btn btn-sm btn-dark"><i class="bi bi-pencil-fill"></i> Edit</a>
                                        <button class="btn btn-sm  btn btn-danger deleteButton" data-bookid="${book.id}"><i class="bi bi-trash"></i> Delete</button>
                                    </td>
                             `;

                tableBody.appendChild(row);
            });
        }
        displayBooks();


        // Adding event listener for delete buttons, including the Sweetalert alert for the delete button.
        const deleteButtons = document.querySelectorAll('.deleteButton');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const bookId = this.getAttribute('data-bookid');


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
                    title: "Are you sure you want to delete this Book? This will also permanently delete all the Comments and private Notes from the users for this Book.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "The Book was delete successfully!",
                            icon: "success"
                        })
                        deleteBook(bookId, trElement)
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your Book lives to see another day! :)",
                            icon: "error"
                        });
                    }
                });




            });


        });


        // Function to delete the Book from the Database based on the BookId and remove the Row element to update the Page.
        function deleteBook(bookId, trElement) {
            fetch(`../Book-CRUD/delete-book.php?id=${bookId}`)
                .then(response => {
                    if (response.ok == true) {
                        console.log('Book deleted successfully');
                        trElement.remove();
                    } else {
                        console.error('Failed to delete Book');
                    }
                });
        }

        const bioElement = document.getElementById('biography');
        const charCount = document.getElementById('charCount');
        bioElement.addEventListener('keyup', (e) => {
            const numberOfChar = e.target.value.length;
            charCount.innerHTML = `${numberOfChar}/500 Characters`;
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php

unset($_SESSION['errors']);
unset($_SESSION['data']);

?>