<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM user WHERE email = ?"
        );
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function register($name, $email, $password) {

        $stmt = $this->conn->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, 'user')");
        return $stmt->execute([$name, $email, $password]);
    }
}

?>