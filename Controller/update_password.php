<?php
session_start();
unset($_SESSION["error-message"]);

require_once "../Database/db_config.php"; // Include the file containing the function definitions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Check if passwords match
    if ($password != $confirm_password) {
        $_SESSION["error-message"] = "Passwords do not match.";
        header("Location: reset_password.php?username=$username");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE users SET password = ? WHERE username = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $username);
    $stmt->execute();

    // Check if the password was updated successfully
    if ($stmt->affected_rows > 0) {
        // Password updated successfully
        $_SESSION["success-message"] = "Password updated successfully.";
        header("Location: ../index.php"); // Redirect to login page or any other page
        exit();
    } else {
        // Failed to update password
        $_SESSION["error-message"] = "Failed to update password. Please try again later.";
        header("Location: reset_password.php?username=$username");
        exit();
    }

    $stmt->close();
} else {
    // Redirect to reset password page if accessed directly without POST request
    header("Location: reset_password.php");
    exit();
}
?>
