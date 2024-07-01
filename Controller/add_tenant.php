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

// Include database configuration file
require_once "../Database/db_config.php";

try {
    // Get form data
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $contactInfo = isset($_POST['contactInfo']) ? $_POST['contactInfo'] : '';
    // $apartmentAddress = isset($_POST['apartmentAddress']) ? $_POST['apartmentAddress'] : ''; // New address input
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Generate a random number between 1 and 1000
    $randomNumber = mt_rand(1, 100000);


  
    // Assuming 'tenant' as the default userType for this form submission
    $userType = 'tenant';

    // Convert isActive to boolean for SQL
    $isActive =0;

    // Hash the password for storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Generate the username
    do{
        $username =  $firstName . substr($lastName, -1).$randomNumber."T"; // Combination of random number, first name, and last letter of last name
    
    $sql = "SELECT username FROM users WHERE username = ? ";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result =$stmt -> get_result();
    
    }while($row = $result->fetch_assoc());
    

    
    // Prepare and bind for users table
    
    $stmtUser = $link->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
    $stmtUser->bind_param("sss", $username, $hashedPassword, $userType);


    

    
    // Execute the statements
    if ($stmtUser->execute() ) {
        // Create a new PHPMailer instance

        $user_id= $stmtUser->insert_id;
    

    // Prepare and bind for TTenant table including the address
    $stmtTenant = $link->prepare("INSERT INTO ttenant (UserID, FirstName, LastName, ContactInfo) VALUES (?, ?, ?, ?)");
    $stmtTenant->bind_param("isss", $user_id,$firstName, $lastName, $contactInfo);

    if($stmtTenant->execute()){
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
        $mail->addAddress($contactInfo, $firstName . ' ' . $lastName); // Recipient's email address and name

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Welcome to Tenant Management System';
        $mail->Body    = "Dear $firstName $lastName,<br><br>Thank you for registering with Tenant Management System.<br><br>Your username is: $username<br><br>Please login to manage your tenant information.<br><br>Regards,<br>Tenant Management System";

        // Send email
        if ($mail->send()) {
            // Email sent successfully
            unset($_SESSION["error_message"]);
            header("Location: ../index.php?signup=success"); // Redirecting to the homepage/index page on successful user addition
        } else {
            // Failed to send email
            echo "Failed to send email: " . $mail->ErrorInfo;
        }

    }
            } else {
        echo "Error adding user/tenant: " . $stmtUser->error;
    }

    // Close statement and connection
    $stmtTenant->close();
    $stmtUser->close();
    $link->close();
} catch (Exception $e) {
    // Handle exceptions
    echo "An error occurred: " . $e->getMessage();
}

?>
