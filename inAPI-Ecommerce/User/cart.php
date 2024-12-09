<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce';

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
        $stmt = $this->pdo->prepare("SELECT c.id, p.name, c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeItem($cartItemId) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$cartItemId]);
        echo "Item removed from cart!";
    }

    public function displayCart($cartItems) {
        if (count($cartItems) > 0) {
            echo "<h1>Your Cart</h1>";
            echo "<table border='1'>";
            echo "<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";

            foreach ($cartItems as $item) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($item['price']) . "</td>";
                echo "<td><form method='POST' action='cart.php'><input type='hidden' name='cart_item_id' value='" . $item['id'] . "'><button type='submit' name='action' value='remove'>Remove</button></form></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Your cart is empty.</p>";
        }
    }

    public function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] === 'remove') {
                $cartItemId = intval($_POST['cart_item_id']);
                $this->removeItem($cartItemId);
            }
        }
    }
}

$cart = new Cart($pdo);
$cart->handlePostRequest();

$userId = 1; 
$cartItems = $cart->getItems($userId);
$cart->displayCart($cartItems);
?>
