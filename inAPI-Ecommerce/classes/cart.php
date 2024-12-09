<?php

class Cart {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addItem($userId, $productId, $quantity) {
        $stmt = $this->pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $productId, $quantity]);

        echo "Item added to cart!";
    }

    public function getItems($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeItem($cartItemId) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$cartItemId]);

        echo "Item removed from cart!";
    }
}
