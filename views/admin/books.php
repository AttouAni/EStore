<?php
    session_start();
    require_once "../../config/database.php";
    require_once "../../models/Book.php";
    $bookModel = new Book($conn);
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $books = $bookModel->searchBooks(
        $search,
        '',
        $category
    );
    $categories = $bookModel->getCategories();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Manage Books</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #212529;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar-title {
            color: white;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #343a40;
            color: white;
        }
        .sidebar a.active {
            background-color: #0d6efd;
            color: white;
        }
        .logout-link {
            margin-top: auto;
        }
        .main-content {
            margin-left: 250px;
            padding: 40px;
        }
        .dashboard-card {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .main-content {
            margin-left: 250px;
            padding: 40px;
        }
        .table img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">
            ESTORE
        </div>
        <a
            href="dashboard.php"
        >
            <i class="bi bi-grid"></i>
            Dashboard
        </a>
        <a href="books.php" class="active">
            <i class="bi bi-book"></i>
            Books
        </a>
        <a href="orders.php">
            <i class="bi bi-bag"></i>
            Orders
        </a>
        <a
            href="../../logout.php"
            class="logout-link text-danger"
        >
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold">
                    Manage Books
                </h1>
                <p class="text-muted">
                    Manage your bookstore collection.
                </p>
            </div>
            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addBookModal"
            >
                <i class="bi bi-plus-lg"></i>Add Book
            </button>
        </div>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form
                    method="GET"
                    class="row g-3"
                >
                    <div class="col-md-8">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by title, author or description..."
                            value="<?= $search ?>"
                        >
                    </div>
                    <div class="col-md-3">
                        <select
                            name="category"
                            class="form-select"
                        >
                            <option value="">
                                All Categories
                            </option>
                            <?php foreach ($categories as $cat): ?>
                                <option
                                    value="<?= $cat['category'] ?>"
                                >

                                    <?= $cat['category'] ?>

                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button
                            class="btn btn-dark w-100"
                        >
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th class="text-end">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td>
                                    <img
                                        src="../../public/uploads/<?= $book['image'] ?>"
                                    >
                                </td>
                                <td class="fw-semibold">
                                    <?= $book['title'] ?>
                                </td>
                                <td>
                                    <?= $book['author'] ?>
                                </td>
                                <td class="fw-bold">
                                    <?= $book['price'] ?> DT
                                </td>
                                <td class="text-end">
                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewBookModal"
                                        onclick='fillViewModal(<?= json_encode($book) ?>)'
                                    >
                                        <i class="bi bi-eye"></i>
                                        View
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBookModal"
                                        onclick='fillEditModal(<?= json_encode($book) ?>)'
                                    >
                                        <i class="bi bi-pencil"></i>
                                        Update
                                    </button>
                                    <a
                                        href="../../controllers/bookController.php?delete=<?= $book['id_book'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ================= ADD BOOK MODAL ================= -->
    <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add New Book
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form
                    action="../../controllers/bookController.php"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Title
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Author
                                </label>
                                <input
                                    type="text"
                                    name="author"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Category
                                </label>
                                <input
                                    type="text"
                                    name="category"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Price
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Description
                                </label>
                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="5"
                                    required
                                ></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Book Image
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            name="add_book"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg"></i>Add Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= EDIT BOOK MODAL ================= -->
    <div class="modal fade" id="editBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Update Book
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form
                    action="../../controllers/bookController.php"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <div class="modal-body">
                        <input type="hidden" name="id_book" id="edit_id_book">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="edit_title"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Author</label>
                                <input
                                    type="text"
                                    name="author"
                                    id="edit_author"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <input
                                    type="text"
                                    name="category"
                                    id="edit_category"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    id="edit_price"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea
                                    name="description"
                                    id="edit_description"
                                    class="form-control"
                                    rows="5"
                                    required
                                ></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Book Image (optional)
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            name="update_book"
                            class="btn btn-warning"
                        >
                            <i class="bi bi-check-lg"></i>
                            Update Book
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ================= VIEW BOOK MODAL ================= -->
    <div class="modal fade" id="viewBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Book Details
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img
                                id="view_image"
                                src=""
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 350px; object-fit: cover;"
                            >
                        </div>
                        <div class="col-md-7">
                            <h3 class="fw-bold mb-3" id="view_title"></h3>
                            <p class="mb-2">
                                <span class="fw-bold">Author:</span>
                                <span id="view_author"></span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold">Category:</span>
                                <span id="view_category"></span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold">Price:</span>
                                <span id="view_price"></span> DT
                            </p>
                            <hr>
                            <p id="view_description" class="text-muted"></p>
                            <hr>
                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBookModal"
                                    onclick='fillEditModal(<?= json_encode($book) ?>)'
                                >
                                    <i class="bi bi-pencil"></i>
                                    Update
                                </button>
                                <a
                                    id="view_delete"
                                    href="#"
                                    class="btn btn-danger"
                                >
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillEditModal(book) {
            document.getElementById("edit_id_book").value = book.id_book;
            document.getElementById("edit_title").value = book.title;
            document.getElementById("edit_author").value = book.author;
            document.getElementById("edit_category").value = book.category;
            document.getElementById("edit_price").value = book.price;
            document.getElementById("edit_description").value = book.description;
        }
        function fillViewModal(book) {
            document.getElementById("view_image").src =
                "../../public/uploads/" + book.image;

            document.getElementById("view_title").innerText = book.title;
            document.getElementById("view_author").innerText = book.author;
            document.getElementById("view_category").innerText = book.category;
            document.getElementById("view_price").innerText = book.price;
            document.getElementById("view_description").innerText = book.description;

            document.getElementById("view_delete").href =
                "../../controllers/bookController.php?delete=" + book.id_book;
        }
    </script>

</body>
</html>


    <!-- ================= ADD BOOK MODAL ================= -->
<!--     <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add New Book
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form
                    action="../../controllers/bookController.php"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Title
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Author
                                </label>
                                <input
                                    type="text"
                                    name="author"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Category
                                </label>
                                <input
                                    type="text"
                                    name="category"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Price
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Description
                                </label>
                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="5"
                                    required
                                ></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Book Image
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            name="add_book"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg"></i>Add Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
