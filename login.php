<?php
session_start();
require 'db_connect.php'; // <-- your mysqli connection file

// Get username & password from form
$username = $_POST['username'];
$password = $_POST['password'];

// Query for the user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // this is the take note pinalitan ko yung password verify na command kasi di 
    // sya nagana kasi di naman naka hash yung password ko at plain text lang ito
    // For plain text password (change to password_verify() later if hashed)
    if ($password === $row['password']) {

        // Save session data
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] === 'admin') {
            header("Location: adminpage.html");
        } elseif ($row['role'] === 'student') {
            header("Location: studentpage.html");
        } else {
            echo "Unknown role.";
        }
        exit();

    } else {
        echo "Invalid password.";
    }

} else {
    echo "No account found with that username.";
}

$stmt->close();
$conn->close();
?>
