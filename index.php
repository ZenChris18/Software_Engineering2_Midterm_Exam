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
    <title>Register a Customer - SaaS Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h3>Register a Customer</h3>

    <!-- Link to add a new SaaS Product -->
    <p><a href="add_product.php">Add New SaaS Product</a></p>

    <!-- Customer Registration Form -->
    <h4>Register a Customer</h4>
    <form action="core/handleForms.php" method="POST">
        <table>
            <tr>
                <td><label for="customerName">Full Name</label></td>
                <td><input type="text" name="customerName" required></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td><label for="product_id">Select SaaS Product</label></td>
                <td>
                    <select name="product_id" required>
                        <?php
                        require './core/dbconfig.php';
                        $stmt = $pdo->query("SELECT product_id, product_name FROM SaaS_Products");
                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . $row['product_id'] . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="subscription_start_date">Subscription Start Date</label></td>
                <td><input type="date" name="subscription_start_date" required></td>
            </tr>
            <tr>
                <td><label for="subscription_end_date">Subscription End Date</label></td>
                <td><input type="date" name="subscription_end_date" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="insertCustomer" value="Register Customer"></td>
            </tr>
        </table>
    </form>

    <!-- View Customers Link -->
    <p><a href="view_customers.php">View All Customers</a></p>
    <p><a href="logout.php">Logout</a></p>


</body>
</html>