<?php
require './core/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect all form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Insert query including all columns in Users table
    $query = "INSERT INTO Users (first_name, last_name, address, age, email, password_hash) 
              VALUES (:first_name, :last_name, :address, :age, :email, :password_hash)";
              
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password);

    // Execute and check if the registration was successful
    if ($stmt->execute()) {
        echo "Registration successful. <a href='login.php'>Login here</a>.";
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
