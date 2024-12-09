
<?php
require 'C:\xampp\htdocs\inAPI-Ecommerce';

class BuyerAddress {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAddresses() {
        try {
            $stmt = $this->pdo->query("SELECT id, name, street, city, state, zip, created_at FROM addresses");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching addresses: " . $e->getMessage();
        }
    }

    public function displayAddresses($addresses) {
        if (count($addresses) > 0) {
            echo "<h1>User Addresses</h1>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Name</th><th>Street</th><th>City</th><th>State</th><th>Zip Code</th><th>Created At</th></tr>";

            foreach ($addresses as $address) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($address['id']) . "</td>";
                echo "<td>" . htmlspecialchars($address['name']) . "</td>";
                echo "<td>" . htmlspecialchars($address['street']) . "</td>";
                echo "<td>" . htmlspecialchars($address['city']) . "</td>";
                echo "<td>" . htmlspecialchars($address['state']) . "</td>";
                echo "<td>" . htmlspecialchars($address['zip']) . "</td>";
                echo "<td>" . htmlspecialchars($address['created_at']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No addresses found.</p>";
        }
    }
}

$buyerAddress = new BuyerAddress($pdo);
$addresses = $buyerAddress->getAddresses();
$buyerAddress->displayAddresses($addresses);
?>

