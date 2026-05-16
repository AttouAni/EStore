<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Admin Dashboard</title>
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">
            ESTORE
        </div>
        <a
            href="dashboard.php"
            class="active"
        >
            <i class="bi bi-grid"></i>
            Dashboard
        </a>
        <a href="books.php">
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
        <h1 class="fw-bold mb-4">
            Dashboard
        </h1>
        <p class="text-muted mb-5">
            Welcome back, Admin.
        </p>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm dashboard-card p-4">
                    <h5>Total Books</h5>
                    <h2 class="fw-bold">
                        24
                    </h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm dashboard-card p-4">
                    <h5>Total Orders</h5>
                    <h2 class="fw-bold">
                        15
                    </h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm dashboard-card p-4">
                    <h5>Total Users</h5>
                    <h2 class="fw-bold">
                        8
                    </h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm dashboard-card p-4">
                    <h5>Revenue</h5>
                    <h2 class="fw-bold">
                        540 DT
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>