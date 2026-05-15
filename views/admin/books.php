<?php
require_once "../../config/database.php";
require_once "../../models/Book.php";

$bookModel = new Book($conn);

$books = $bookModel->getAll();
?>

<h1>Manage Books</h1>

<form
    action="../../controllers/bookController.php"
    method="POST"
    enctype="multipart/form-data"
>

    <input type="text" name="title" placeholder="Title">

    <input type="text" name="author" placeholder="Author">

    <input type="text" name="category" placeholder="Category">

    <textarea name="description"></textarea>

    <input type="number" step="0.01" name="price">

    <input type="file" name="image">

    <button type="submit" name="add_book">
        Add Book
    </button>

</form>

<hr>

<?php foreach ($books as $book): ?>

    <div>

        <h3><?= $book['title'] ?></h3>

        <p><?= $book['author'] ?></p>

        <p><?= $book['category'] ?></p>

        <p><?= $book['price'] ?> DT</p>

        <img
            src="../../public/uploads/<?= $book['image'] ?>"
            width="100"
        >
        

        <br>

        <a href="../../controllers/bookController.php?delete=<?= $book['id_book'] ?>">
            Delete
        </a>

        <form
            action="../../controllers/bookController.php"
            method="POST"
            enctype="multipart/form-data"
        >

            <input
                type="hidden"
                name="id_book"
                value="<?= $book['id_book'] ?>"
            >

            <input
                type="text"
                name="title"
                value="<?= $book['title'] ?>"
            >

            <input
                type="text"
                name="category"
                value="<?= $book['category'] ?>"
            >

            <input
                type="text"
                name="author"
                value="<?= $book['author'] ?>"
            >

            <input
                type="number"
                step="0.01"
                name="price"
                value="<?= $book['price'] ?>"
            >

            <textarea name="description"><?= $book['description'] ?></textarea>

            <input type="file" name="image">

            <button type="submit" name="update_book">
                Update
            </button>

        </form>

    </div>

    <hr>

<?php endforeach; ?>