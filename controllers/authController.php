<?php
require_once "../config/database.php";
require_once "../models/User.php";

session_start();

$userModel = new User($conn);

// registration
if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("All fields are required");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match");
    }

    $existingUser = $userModel->findByEmail($email);

    if ($existingUser) {
        die("Email already exists");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $user = $userModel->register($name, $email, $hashedPassword);

    header("Location: ../views/auth/login.php");
    exit();
}

//login
if (isset($_POST['login']) || isset($_POST['admin_login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("All fields are required");
    }

    $user = $userModel->findByEmail($email);

    if (!$user) {
        die("Invalid credentials");
    }

    if (!password_verify($password, $user['password'])) {
        die("Invalid credentials");
    }

    if (isset($_POST['login'])) {

        if ($user['role'] !== 'user') {
            die("Access denied: Not a user account");
        }

        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../views/home.php");
        exit();
    }

    if (isset($_POST['admin_login'])) {

        if ($user['role'] !== 'admin') {
            die("Access denied: Not an admin account");
        }

        $_SESSION['admin_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../views/admin/dashboard.php");
        exit();
    }
}

?>