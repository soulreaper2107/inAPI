<?php
class User {
    private $pdo;
    private $encryption;

    public function __construct($pdo, $encryption) {
        $this->pdo = $pdo;
        $this->encryption = $encryption;
    }

    public function createUser($username, $email, $password, $address) {
        $salt = bin2hex(random_bytes(32)); 
        $hashedPassword = $this->encryption->hashPassword($password, $salt);

        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, address, salt) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $address, $salt]);

        echo "User created successfully!";
    }

    public function getUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $address) {
        $stmt = $this->pdo->prepare("UPDATE users SET address = ? WHERE id = ?");
        $stmt->execute([$address, $userId]);

        echo "User address updated!";
    }

    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);

        echo "User deleted!";
    }
}
