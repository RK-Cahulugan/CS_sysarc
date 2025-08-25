<?php
require 'db_connect.php'; // database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username  = $_POST['username'];
    $lname     = $_POST['lname'];       
    $fname     = $_POST['fname'];       
    $email     = $_POST['email'];
    $studentID = $_POST['studentID'];
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];

    // Check if passwords match
    if ($password !== $confirm) {
        die("Passwords do not match!");
    }

    // Hash password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Assign role automatically if studentID is provided
    $role = !empty($studentID) ? 'student' : 'guest';

    // Insert query
    $sql = "INSERT INTO users (username, lname, fname, email, password, role, studentID) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $lname, $fname, $email, $hashed_password, $role, $studentID);

    if ($stmt->execute()) {
        echo "Account created successfully! You are registered as a $role.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
