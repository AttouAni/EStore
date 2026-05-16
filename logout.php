<?php

    session_start();
    $role = $_SESSION['role'] ?? null;
    session_unset();
    session_destroy();

    if ($role === 'admin') {
        header("Location: views/admin/login.php");
    }
    else {
        header("Location: views/auth/login.php");
    }
    exit();
?>