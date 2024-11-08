<?php
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
    <title>Add SaaS Product</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h3>Add New SaaS Product</h3>
    <form action="core/handleForms.php" method="POST">
        <p><label for="product_name">Product Name </label><input type="text" name="product_name" required></p>
        <p><label for="team_name">Team Name </label><input type="text" name="team_name" required></p>
        <p><input type="submit" name="insertProduct" value="Add Product"></p>
    </form>

    <h4>Current SaaS Products and Subscribed Customers</h4>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Team Name</th>
                <th>Subscribed Customers</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require './core/dbconfig.php';

            $query = "SELECT sp.product_name, sp.team_name, 
                             GROUP_CONCAT(c.customer_name SEPARATOR ', ') AS subscribed_customers
                      FROM SaaS_Products sp
                      LEFT JOIN Customers c ON sp.product_id = c.product_id
                      GROUP BY sp.product_id";
            $stmt = $pdo->query($query);

            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subscribed_customers'] ?: 'None') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <p><a href="index.php">Register a Customer</a></p>
    <p><a href="view_customers.php">View All Customers</a></p>
</body>
</html>