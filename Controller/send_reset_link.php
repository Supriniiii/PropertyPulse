<?php
session_start();
unset($_SESSION["error-message"]);

require_once "../Database/db_config.php"; // Include the file containing the function definitions
// Define the getUserByUsername() function
function getUserByUsername($username) {
    global $link;
    
    // Prepare a SELECT statement
    $sql = "SELECT * FROM users WHERE username = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        
        // Set parameters
        $param_username = $username;
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Get result set
            $result = mysqli_stmt_get_result($stmt);
            
            // Check if a row was returned
            if (mysqli_num_rows($result) == 1) {
                // Fetch result row as an associative array
                $row = mysqli_fetch_assoc($result);
                return $row; // Return the user's information
            } else {
                return false; // User not found
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}
try {
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // Check if the username exists in the database
    // You need to implement this function in db_config.php
    $user = getUserByUsername($username);

    if ($user) {
        // Redirect the user to the password reset page with the username as a parameter
        header("Location: ../View/reset_password.php?username=$username");
        exit(); // Stop further execution
    } else {
        $_SESSION["error-message"] = "Username not found in the database.";
        header("Location: forgot_password.php");
        exit(); // Stop further execution
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
