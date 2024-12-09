<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce';

class Address {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addAddress($name, $street, $city, $state, $zip) {
        $stmt = $this->pdo->prepare("INSERT INTO addresses (name, street, city, state, zip) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $street, $city, $state, $zip]);
        echo "Address added successfully!";
    }

    public function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $street = htmlspecialchars($_POST['street']);
            $city = htmlspecialchars($_POST['city']);
            $state = htmlspecialchars($_POST['state']);
            $zip = htmlspecialchars($_POST['zip']);

            $this->addAddress($name, $street, $city, $state, $zip);
        } else {
            echo '<h1>Add Address</h1>';
            echo '<form method="POST" action="address.php">
                <label>Name: <input type="text" name="name" required></label><br>
                <label>Street: <input type="text" name="street" required></label><br>
                <label>City: <input type="text" name="city" required></label><br>
                <label>State: <input type="text" name="state" required></label><br>
                <label>Zip: <input type="text" name="zip" required></label><br>
                <button type="submit">Add Address</button>
            </form>';
        }
    }
}

$address = new Address($pdo);
$address->handlePostRequest();
?>
