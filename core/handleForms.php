<?php
// Enable error checking
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start session for user management
require_once './dbconfig.php';

// Redirect user to login page if they are not logged in
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header("Location: ../login.php");
    exit();
}

// Register User
if (isset($_POST['registerUser'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO Users (first_name, last_name, email, password_hash) 
              VALUES (:first_name, :last_name, :email, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        header("Location: ../login.php");
        exit();
    } else {
        echo "Error registering user.";
    }
}

// Login User
if (isset($_POST['loginUser'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: ../index.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}

// Logout User
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// Insert Customer
if (isset($_POST['insertCustomer'])) {
    $customerName = $_POST['customerName'];
    $email = $_POST['email'];
    $product_id = $_POST['product_id'];
    $start_date = $_POST['subscription_start_date'];
    $end_date = $_POST['subscription_end_date'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO Customers (customer_name, email, product_id, subscription_start_date, subscription_end_date, added_by)
              VALUES (:customer_name, :email, :product_id, :start_date, :end_date, :added_by)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':customer_name', $customerName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':added_by', $user_id);

    if ($stmt->execute()) {
        header("Location: ../view_customers.php");
        exit();
    } else {
        echo "Error registering customer.";
    }
}

// Insert Product
if (isset($_POST['insertProduct'])) {
    $productName = $_POST['product_name'];
    $teamName = $_POST['team_name'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO SaaS_Products (product_name, team_name, added_by)
              VALUES (:product_name, :team_name, :added_by)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_name', $productName);
    $stmt->bindParam(':team_name', $teamName);
    $stmt->bindParam(':added_by', $user_id);

    if ($stmt->execute()) {
        header("Location: ../add_product.php");
        exit(); 
    } else {
        echo "Error adding product.";
    }
}

// Update Customer
if (isset($_POST['updateCustomer'])) {
    $customer_id = $_POST['customer_id'];
    $customerName = $_POST['customerName'];
    $email = $_POST['email'];
    $product_id = $_POST['product_id'];
    $start_date = $_POST['subscription_start_date'];
    $end_date = $_POST['subscription_end_date'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE Customers 
              SET customer_name = :customer_name, email = :email, product_id = :product_id, 
                  subscription_start_date = :start_date, subscription_end_date = :end_date,
                  last_updated_by = :last_updated_by, last_updated = NOW()
              WHERE customer_id = :customer_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':customer_name', $customerName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':last_updated_by', $user_id);

    if ($stmt->execute()) {
        header("Location: ../view_customers.php");
        exit();
    } else {
        echo "Error updating customer.";
    }
}
?>
