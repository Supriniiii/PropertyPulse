<?php
require_once "../Database/db_config.php";
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/PHPMailer.php'; // Path to PHPMailer's main class file
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/SMTP.php'; // Path to SMTP class file
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/Exception.php'; // Path to Exception class file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Start the session at the beginning of the script
session_start();
unset($_SESSION["error-message"]);

try {
    // Get form data
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $contactEmail = isset($_POST['contactEmail']) ? $_POST['contactEmail'] : '';
    $contactPhone = isset($_POST['contactPhone']) ? $_POST['contactPhone'] : '';
    // $address = isset($_POST['address']) ? $_POST['address'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    // Generate a random number between 1 and 1000
    $randomNumber = mt_rand(1, 100000);
    $userType = 'property_owner';
    // Generate the username

     // Combination of random number, first name, and last letter of last name

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    do{
        $username =  $firstName . substr($lastName, -1).$randomNumber."P";// Combination of random number, first name, and last letter of last name
    
    $sql = "SELECT username FROM users WHERE username = ? ";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result =$stmt -> get_result();
    
    }while($row = $result->fetch_assoc());
    
    
    
$stmtUser = $link->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
    $stmtUser->bind_param("sss", $username, $hashedPassword, $userType);


    // Execute the statement
    if ($stmtUser->execute()) {
	
    
    
    $user_id= $stmtUser->insert_id;
            
                // Prepare and bind for Property Owner table
    $stmtOwner = $link->prepare("INSERT INTO propertyowner (FirstName, LastName, ContactEmail, ContactPhone,  UserID) VALUES (?, ?, ?, ?, ?)");
    $stmtOwner->bind_param("ssssi", $firstName, $lastName, $contactEmail, $contactPhone, $user_id);
        // Execute the statement for users
        if ($stmtOwner->execute()) {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'khensanin2002@gmail.com'; // Your Gmail email address
            $mail->Password   = 'fose pzch qsac yibl'; // Your Gmail password or app-specific password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Sender and recipient settings
            $mail->setFrom('khensanin2002@gmail.com', 'Residence'); // Your name and email address
            $mail->addAddress($contactEmail, $firstName . ' ' . $lastName); // Recipient's email address and name

            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Welcome to Our Service';
            $mail->Body    = "Dear $firstName $lastName,<br><br>Thank you for registering with our service.<br><br>Your username is: $username<br><br>Please login to access our services.<br><br>Regards,<br>Our Service";

            // Send email
            if ($mail->send()) {
                unset($_SESSION["error_message"]);
                header("Location: ../index.php?signup=success"); // Redirecting to the homepage/index page on successful user addition
            } else {
                echo "Failed to send email: " . $mail->ErrorInfo;
            }
        } else {
            // Error adding user
            echo "Error adding user: " . $stmtUser->error;
        }
    } else {
        // Error adding property owner
        echo "Error adding property owner: " . $stmtOwner->error;
    }

    // Close the property owner statement and connection
    $stmtOwner->close();
    $stmtUser->close();
    $link->close();
} catch (Exception $e) {
    // Handle exceptions
    echo "An error occurred: " . $e->getMessage();
}

?>
