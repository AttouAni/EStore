<?php

session_start();

require_once "../config/database.php";

require_once "../models/Order.php";
require_once "../models/OrderItem.php";

$orderModel = new Order($conn);
$orderItemModel = new OrderItem($conn);

// GET USER ORDERS
$orders = $orderModel->getByUser(
    $_SESSION['user_id']
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
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
                        <a class="nav-link " href="books.php">
                            Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="orders.php">
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
        <h1>My Orders</h1>
    </div>
    <div class="container">
        <?php foreach ($orders as $order): ?>

            <div
                style="
                    border:1px solid black;
                    margin-bottom:20px;
                    padding:15px;
                "
            >

                <h3>
                    Order #<?= $order['id_order'] ?>
                </h3>

                <p>
                    Total:
                    <?= $order['total_price'] ?> DT
                </p>

                <p>
                    Status:
                    <?= $order['status'] ?>
                </p>

                <p>
                    Date:
                    <?= $order['order_date'] ?>
                </p>

                <hr>

                <h4>Books:</h4>

                <?php

                $items = $orderItemModel->getByOrder(
                    $order['id_order']
                );

                ?>

                <?php foreach ($items as $item): ?>

                    <div style="margin-bottom:10px;">

                        <img
                            src="../public/uploads/<?= $item['image'] ?>"
                            width="80"
                        >

                        <p>
                            <?= $item['title'] ?>
                        </p>

                        <p>
                            Quantity:
                            <?= $item['quantity'] ?>
                        </p>

                        <p>
                            Subtotal:
                            <?= $item['price'] ?> DT
                        </p>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>
    </div>
    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">
            © 2026 ESTORE - All Rights Reserved
        </p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 