<?php

class Payment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createPayment($userId, $amount, $paymentMethod, $paymentStatus) {
        $stmt = $this->pdo->prepare("INSERT INTO payments (user_id, amount, payment_method, payment_status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $amount, $paymentMethod, $paymentStatus]);

        echo "Payment processed!";
    }

    public function getPayments($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM payments WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
