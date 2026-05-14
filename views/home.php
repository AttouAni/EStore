<?php

require_once "../config/database.php";
require_once "../models/Book.php";

$bookModel = new Book($conn);

$books = $bookModel->getAll();
?>

<h1>All Books</h1>

<?php foreach ($books as $book): ?>

    <div>

        <h3><?= $book['title'] ?></h3>

        <p><?= $book['author'] ?></p>

        <p><?= $book['category'] ?></p>

        <p><?= $book['price'] ?> DT</p>

        <img
            src="../public/uploads/<?= $book['image'] ?>"
            width="100"
        >

        <form
            action="../controllers/orderController.php"
            method="POST"
        >

            <input
                type="hidden"
                name="id_book"
                value="<?= $book['id_book'] ?>"
            >

            <button type="submit" name="order_book">
                Order
            </button>

        </form>

    </div>

    <hr>

<?php endforeach; ?>