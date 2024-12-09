<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce';

class Checkout {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function processPayment($userId, $paymentMethod) {
        echo "Payment processed successfully using $paymentMethod!<br>";
        $this->updateProductStock($userId);
        $this->clearCart($userId);
    }

    private function updateProductStock($userId) {
        $stmt = $this->pdo->prepare("SELECT c.product_id, c.quantity FROM cart c WHERE c.user_id = ?");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cartItems as $item) {
            $stmt = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$item['quantity'], $item['product_id']]);
        }
    }

    private function clearCart($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        echo "Your cart has been cleared!";
    }

    public function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = intval($_POST['user_id']);
            $paymentMethod = htmlspecialchars($_POST['payment_method']);
            $this->processPayment($userId, $paymentMethod);
        }
    }

    public function displayCheckoutForm() {
        echo '<h1>Checkout</h1>';
        echo '<form method="POST" action="checkout.php">
            <label>User ID: <input type="number" name="user_id" required></label><br>
            <label>Payment Method: <select name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select></label><br>
            <button type="submit">Complete Checkout</button>
        </form>';
    }
}

$checkout = new Checkout($pdo);
$checkout->handlePostRequest();
$checkout->displayCheckoutForm();
?>
