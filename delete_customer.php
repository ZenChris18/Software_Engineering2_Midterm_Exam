<?php
require './core/dbconfig.php';

// Check if customer ID is provided
if (!isset($_GET['customer_id'])) {
    echo "Customer ID not specified.";
    exit;
}

$customer_id = $_GET['customer_id'];

// Delete customer from database
$query = "DELETE FROM Customers WHERE customer_id = :customer_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Customer deleted successfully.";
} else {
    echo "Error deleting customer.";
}

// Redirect back to customer list after deletion
header("Location: view_customers.php");
exit;
?>