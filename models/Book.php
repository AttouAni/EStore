<?php
class Book {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add book
    public function create($title, $description, $category, $author, $price, $image) {

        $stmt = $this->conn->prepare("
            INSERT INTO book
            (title, description, category, author, price, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $title,
            $description,
            $category,
            $author,
            $price,
            $image
        ]);
    }

    // Get all books
    public function getAll() {

        $stmt = $this->conn->query(
            "SELECT * FROM book"
        );

        return $stmt->fetchAll();
    }

    // GET ONE BOOK
    public function getById($id) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM book WHERE id_book = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(
        $id,
        $title,
        $category,
        $author,
        $description,
        $price,
        $image = null
    ) {
        if ($image) {

            $stmt = $this->conn->prepare(
                "SELECT image FROM book WHERE id_book = ?"
            );
            $stmt->execute([$id]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            $oldImagePath = "../public/uploads/" . $book['image'];

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $stmt = $this->conn->prepare(
                "UPDATE book
                SET title = ?,
                    author = ?,
                    category = ?,
                    description = ?,
                    price = ?,
                    image = ?
                WHERE id_book = ?"
            );

            return $stmt->execute([
                $title,
                $author,
                $category,
                $description,
                $price,
                $image,
                $id
            ]);
        }

        $stmt = $this->conn->prepare(
            "UPDATE book
            SET title = ?,
                category = ?,
                author = ?,
                description = ?,
                price = ?
            WHERE id_book = ?"
        );

        return $stmt->execute([
            $title,
            $category,
            $author,
            $description,
            $price,
            $id
        ]);
    }

    // Delete book
    public function delete($id) {

        $stmt = $this->conn->prepare(
            "SELECT image FROM book WHERE id_book = ?"
        );

        $stmt->execute([$id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book && file_exists("../public/uploads/" . $book['image'])) {

            unlink("../public/uploads/" . $book['image']);
        }

        $stmt = $this->conn->prepare(
            "DELETE FROM book WHERE id_book = ?"
        );

        return $stmt->execute([$id]);
    }

}
?>