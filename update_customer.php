<?php
require './core/dbconfig.php';

// Check if a customer ID is provided
if (!isset($_GET['customer_id'])) {
    echo "Customer ID not specified.";
    exit;
}

$customer_id = $_GET['customer_id'];

// Fetch customer data
$query = "SELECT * FROM Customers WHERE customer_id = :customer_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch();

if (!$customer) {
    echo "Customer not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
</head>
<body>
    <h3>Update Customer Details</h3>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
        <p><label for="customerName">Full Name </label><input type="text" name="customerName" value="<?php echo htmlspecialchars($customer['customer_name']); ?>" required></p>
        <p><label for="email">Email </label><input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required></p>
        <p><label for="product_id">Select SaaS Product </label>
            <select name="product_id" required>
                <?php
                $stmt = $pdo->query("SELECT product_id, product_name FROM SaaS_Products");
                while ($row = $stmt->fetch()) {
                    $selected = ($row['product_id'] == $customer['product_id']) ? 'selected' : '';
                    echo "<option value='" . $row['product_id'] . "' $selected>" . htmlspecialchars($row['product_name']) . "</option>";
                }
                ?>
            </select>
        </p>
        <p><label for="subscription_start_date">Subscription Start Date </label><input type="date" name="subscription_start_date" value="<?php echo $customer['subscription_start_date']; ?>" required></p>
        <p><label for="subscription_end_date">Subscription End Date </label><input type="date" name="subscription_end_date" value="<?php echo $customer['subscription_end_date']; ?>" required></p>
        <p><input type="submit" name="updateCustomer" value="Update Customer"></p>
    </form>
</body>
</html>