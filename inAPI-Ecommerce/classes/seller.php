<?php
class Seller {
    private $pdo;
    private $encryption;

    public function __construct($pdo, $encryption) {
        $this->pdo = $pdo;
        $this->encryption = $encryption;
    }
    public function createSeller($username, $email, $password, $address) {
        $salt = bin2hex(random_bytes(32)); // Generate a random salt
        $hashedPassword = $this->encryption->hashPassword($password, $salt);

        $stmt = $this->pdo->prepare("INSERT INTO sellers (username, email, password, address, salt) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $address, $salt]);

        echo "Seller created successfully!";
    }

    public function getSeller($sellerId) {
        $stmt = $this->pdo->prepare("SELECT * FROM sellers WHERE id = ?");
        $stmt->execute([$sellerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSeller($sellerId, $address) {
        $stmt = $this->pdo->prepare("UPDATE sellers SET address = ? WHERE id = ?");
        $stmt->execute([$address, $sellerId]);

        echo "Seller address updated!";
    }

    public function deleteSeller($sellerId) {
        $stmt = $this->pdo->prepare("DELETE FROM sellers WHERE id = ?");
        $stmt->execute([$sellerId]);

        echo "Seller deleted!";
    }
}
