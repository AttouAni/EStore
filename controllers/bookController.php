<?php

require_once "../config/database.php";
require_once "../models/Book.php";

session_start();

$bookModel = new Book($conn);

// ADD BOOK
if (isset($_POST['add_book'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $price = $_POST['price'];

    $imageName = $_FILES['image']['name']; 
    $tmpName = $_FILES['image']['tmp_name'];

    move_uploaded_file(
        $tmpName,
        "../public/uploads/" . $imageName
    );

    $bookModel->create(
        $title,
        $description,
        $category,
        $author,
        $price,
        $imageName
    );

    header("Location: ../views/admin/books.php");
    exit();
}

if (isset($_POST['update_book'])) {

    $id = $_POST['id_book'];

    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $imageName = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../public/uploads/" . $imageName
        );
    }

    $bookModel->update(
        $id,
        $title,
        $category,
        $author,
        $description,
        $price,
        $imageName
    );

    header("Location: ../views/admin/books.php");
    exit();
}

// DELETE BOOK
if (isset($_GET['delete'])) {

    $bookModel->delete($_GET['delete']);

    header("Location: ../views/admin/books.php");
    exit();
}
?>