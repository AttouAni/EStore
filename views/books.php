<?php
    session_start();

    require_once "../config/database.php";
    require_once "../models/Book.php";

    $bookModel = new Book($conn);

    $search = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? '';
    $category = $_GET['category'] ?? '';

    $books = $bookModel->searchBooks(
        $search,
        $sort,
        $category
    );
    $categories = $bookModel->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container">
            <a class="navbar-brand fw-bold" href="home.php">
                ESTORE
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="collapse navbar-collapse"
                id="navbarNav"
            >
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="home.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="books.php">
                            Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">
                            My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link text-danger"
                            href="../logout.php"
                        >
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <h1 class="mb-4">
            All Books
        </h1>
        <form
            method="GET"
            class="row g-3 mb-5"
        >
            <div class="col-md-5">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search books..."
                    value="<?= $search ?>"
                >
            </div>
            <div class="col-md-3">
                <select
                    name="sort"
                    class="form-select"
                >
                    <option value="">
                        Sort By
                    </option>
                    <option value="title_asc">
                        Alphabetical
                    </option>
                    <option value="price_asc">
                        Price Low → High
                    </option>
                    <option value="price_desc">
                        Price High → Low
                    </option>
                </select>

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
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm book-card">
                        <img
                            src="../public/uploads/<?= $book['image'] ?>"
                            class="card-img-top"
                        >
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <?= $book['title'] ?>
                            </h5>
                            <p class="text-muted">
                                <?= $book['author'] ?>
                            </p>
                            <h6 class="fw-bold mb-3">
                                <?= $book['price'] ?> DT
                            </h6>
                            <button class="btn btn-primary mt-auto">
                                <i class="bi bi-cart-plus"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">
            © 2026 ESTORE - All Rights Reserved
        </p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 