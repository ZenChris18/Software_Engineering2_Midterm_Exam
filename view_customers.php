<?php
include './core/dbconfig.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h3>Customer List</h3>
    <table>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Subscription Start Date</th>
                <th>Subscription End Date</th>
                <th>Product Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT Customers.customer_id, Customers.customer_name, Customers.email, 
                             Customers.subscription_start_date, Customers.subscription_end_date,
                             SaaS_Products.product_name 
                      FROM Customers
                      JOIN SaaS_Products ON Customers.product_id = SaaS_Products.product_id
                      ORDER BY Customers.customer_id ASC"; 
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subscription_start_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subscription_end_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                echo "<td>
                        <a href='update_customer.php?customer_id=" . $row['customer_id'] . "'>Edit</a> | 
                        <a href='delete_customer.php?customer_id=" . $row['customer_id'] . "' onclick=\"return confirm('Are you sure you want to delete this customer?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <p><a href="index.php">Register a Customer</a></p>
    <p><a href="add_product.php">Add New SaaS Product</a></p>
</body>
</html>