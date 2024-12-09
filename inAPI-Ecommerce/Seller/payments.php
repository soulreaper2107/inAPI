<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce';

class Payment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function receivePayment($buyerName, $amount) {
        echo "Payment received successfully!<br>";
        echo "Buyer: $buyerName<br>";
        echo "Amount: $" . number_format($amount, 2);
    }

    public function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $buyerName = htmlspecialchars($_POST['buyer_name']);
            $amount = floatval($_POST['amount']);
            $this->receivePayment($buyerName, $amount);
        } else {
            echo '<h1>Receive Payment</h1>';
            echo '<form method="POST" action="payments.php">
                <label>Buyer Name: <input type="text" name="buyer_name" required></label><br>
                <label>Amount: <input type="number" step="0.01" name="amount" required></label><br>
                <button type="submit">Receive Payment</button>
            </form>';
        }
    }
}

$payment = new Payment($pdo);
$payment->handlePostRequest();
?>
