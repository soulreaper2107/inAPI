<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce\db.php';

class SellerProduct {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addProduct($name, $price, $stock) {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $stock]);
        echo "Product added successfully!";
    }

    public function updateProduct($id, $name, $price, $stock) {
        $stmt = $this->pdo->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $price, $stock, $id]);
        echo "Product updated successfully!";
    }

    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        echo "Product deleted successfully!";
    }

    public function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            $name = htmlspecialchars($_POST['name']);
            $price = floatval($_POST['price']);
            $stock = intval($_POST['stock']);
            $id = isset($_POST['id']) ? intval($_POST['id']) : null;

            if ($action === 'add') {
                $this->addProduct($name, $price, $stock);
            } elseif ($action === 'update') {
                $this->updateProduct($id, $name, $price, $stock);
            } elseif ($action === 'delete') {
                $this->deleteProduct($id);
            }
        }
    }

    public function displayProductForms() {
        echo '<h1>Manage Products</h1>';
        echo '<form method="POST" action="sellerproducts.php">
            <h2>Add Product</h2>
            <input type="hidden" name="action" value="add">
            <label>Product Name: <input type="text" name="name" required></label><br>
            <label>Price: <input type="number" step="0.01" name="price" required></label><br>
            <label>Stock: <input type="number" name="stock" required></label><br>
            <button type="submit">Add Product</button>
        </form><br>';

        echo '<form method="POST" action="sellerproducts.php">
            <h2>Update Product</h2>
            <input type="hidden" name="action" value="update">
            <label>Product ID: <input type="number" name="id" required></label><br>
            <label>Product Name: <input type="text" name="name" required></label><br>
            <label>Price: <input type="number" step="0.01" name="price" required></label><br>
            <label>Stock: <input type="number" name="stock" required></label><br>
            <button type="submit">Update Product</button>
        </form><br>';

        echo '<form method="POST" action="sellerproducts.php">
            <h2>Delete Product</h2>
            <input type="hidden" name="action" value="delete">
            <label>Product ID: <input type="number" name="id" required></label><br>
            <button type="submit">Delete Product</button>
        </form>';
    }
}

$sellerProduct = new SellerProduct($pdo);
$sellerProduct->handlePostRequest();
$sellerProduct->displayProductForms();
?>
