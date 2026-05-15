<?php

class OrderItem {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(
        $order_id,
        $book_id,
        $quantity
    ) {

        // GET BOOK PRICE
        $stmt = $this->conn->prepare(
            "SELECT price FROM book WHERE id_book = ?"
        );
        $stmt->execute([$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        $unitPrice = $book['price'];
        $subtotal = $unitPrice * $quantity;

        // INSERT ORDER ITEM
        $stmt = $this->conn->prepare(
            "INSERT INTO orderitem
            (book_id, order_id, quantity, price)
            VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $book_id,
            $order_id,
            $quantity,
            $subtotal
        ]);
    }

    public function getByOrder($order_id) {

        $stmt = $this->conn->prepare(
            "SELECT
                orderitem.*,
                book.*
             FROM orderitem, book
             WHERE orderitem.book_id = book.id_book
             AND order_id = ?"
        );

        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>