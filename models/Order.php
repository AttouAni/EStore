<?php

class Order {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($client_id) {

        $stmt = $this->conn->prepare(
            "INSERT INTO `order`
            (client_id, total_price)
            VALUES (?, 0)"
        );

        $stmt->execute([$client_id]);

        return $this->conn->lastInsertId();
    }

    public function updateTotal($order_id) {

        // GET SUM OF ORDER ITEMS
        $stmt = $this->conn->prepare(
            "SELECT SUM(price) as total
             FROM orderitem
             WHERE order_id = ?"
        );
        $stmt->execute([$order_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['total'];

        // UPDATE ORDER TOTAL
        $stmt = $this->conn->prepare(
            "UPDATE `order`
             SET total_price = ?
             WHERE id_order = ?"
        );

        return $stmt->execute([
            $total,
            $order_id
        ]);
    }

    public function getByUser($client_id) {

        $stmt = $this->conn->prepare(
            "SELECT *
            FROM `order`
            WHERE client_id = ?
            ORDER BY order_date DESC"
        );
        $stmt->execute([$client_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {

        $stmt = $this->conn->query(
            "SELECT *
            FROM `order`
            ORDER BY order_date DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($order_id, $status) {

        $stmt = $this->conn->prepare(
            "UPDATE `order`
            SET status = ?
            WHERE id_order = ?"
        );

        return $stmt->execute([
            $status,
            $order_id
        ]);
    }
}

enum Status {
    case Pending;
    case Validated;
    case Cancelled;
}

?>