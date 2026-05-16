<?php
    session_start();

    require_once "../config/database.php";
    require_once "../models/Book.php";

    $bookModel = new Book($conn);

    $books = $bookModel->getFeatured();
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
    <title>ESTORE</title>
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
            background-color: #f8f9fa;
        }

        .hero {

            background:
                linear-gradient(
                    rgba(0,0,0,0.6),
                    rgba(0,0,0,0.6)
                ),

                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600');

            background-size: cover;
            background-position: center;

            height: 500px;

            color: white;

            display: flex;
            align-items: center;
        }

        .hero-content {
            max-width: 600px;
        }

        .book-card img {
            height: 300px;
            object-fit: cover;
        }

        .category-card {
            transition: 0.3s;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .custom-carousel-btn {
            width: 5%;
        }

        .carousel-control-prev {
            left: -70px;
        }

        .carousel-control-next {
            right: -70px;
        }

    </style>

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
                    <a class="nav-link active" href="home.php">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="books.php">
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

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4 fw-bold">
                Discover Your Next Favorite Book
            </h1>
            <p class="lead my-4">
                Browse thousands of books from all categories
                and enjoy a seamless online shopping experience.
            </p>
            <a href="books.php" class="btn btn-primary btn-lg me-2">
                Explore Books
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">
                Featured Books
            </h2>
            <a href="books.php" class="btn btn-outline-dark">
                View All
            </a>
        </div>
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
</section>


<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-5">
            Browse Categories
        </h2>
        <?php
            $categoryChunks = array_chunk($categories, 4);
        ?>
        <div
            id="categoriesCarousel"
            class="carousel slide"
        >
            <div class="carousel-inner">
                <?php foreach ($categoryChunks as $index => $chunk): ?>
                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                        <div class="row g-4">
                            <?php foreach ($chunk as $category): ?>
                                <div class="col-md-3">
                                    <a
                                        href="books.php?category=<?= urlencode($category['category']) ?>"
                                        class="text-decoration-none"
                                    >
                                        <div
                                            class="card category-card text-white border-0 overflow-hidden"
                                            style="
                                                height:200px;

                                                background:
                                                linear-gradient(
                                                    rgba(0,0,0,0.5),
                                                    rgba(0,0,0,0.5)
                                                ),

                                                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600');

                                                background-size:cover;
                                                background-position:center;
                                            "
                                        >
                                            <div
                                                class="d-flex justify-content-center align-items-center h-100"
                                            >
                                                <h3 class="fw-bold">
                                                    <?= $category['category'] ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button
                class="carousel-control-prev custom-carousel-btn"
                type="button"
                data-bs-target="#categoriesCarousel"
                data-bs-slide="prev"
            >
                <span
                    class="carousel-control-prev-icon bg-dark rounded-circle p-4"
                ></span>

            </button>

            <!-- RIGHT BUTTON -->

            <button
                class="carousel-control-next custom-carousel-btn"
                type="button"
                data-bs-target="#categoriesCarousel"
                data-bs-slide="next"
            >

                <span
                    class="carousel-control-next-icon bg-dark rounded-circle p-4"
                ></span>

            </button>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <i class="bi bi-truck fs-1 text-primary"></i>
                <h4 class="mt-3">
                    Fast Delivery
                </h4>
                <p>
                    Get your books delivered quickly and safely.
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-check fs-1 text-success"></i>
                <h4 class="mt-3">
                    Secure Payments
                </h4>
                <p>
                    100% secure payment experience.
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-collection fs-1 text-danger"></i>
                <h4 class="mt-3">
                    Large Collection
                </h4>
                <p>
                    Thousands of books from every category.
                </p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    <p class="mb-0">
        © 2026 ESTORE - All Rights Reserved
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>