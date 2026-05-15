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

    public function getFeatured($limit = 4) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM book LIMIT ?"
        );
        $stmt->bindValue(
            1,
            (int)$limit,
            PDO::PARAM_INT
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->conn->query(
            "SELECT DISTINCT category FROM book"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooks(
        $search = '',
        $sort = '',
        $category = ''
    ) {

        $query = "SELECT * FROM book WHERE 1";
        $params = [];

        // SEARCH
        if (!empty($search)) {

            $query .= "
                AND (
                    title LIKE ?
                    OR author LIKE ?
                    OR description LIKE ?
                )
            ";

            $searchTerm = "%$search%";

            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // CATEGORY FILTER
        if (!empty($category)) {

            $query .= " AND category = ?";

            $params[] = $category;
        }

        // SORTING
        switch ($sort) {

            case 'title_asc':
                $query .= " ORDER BY title ASC";
                break;

            case 'price_asc':
                $query .= " ORDER BY price ASC";
                break;

            case 'price_desc':
                $query .= " ORDER BY price DESC";
                break;
        }

        $stmt = $this->conn->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>