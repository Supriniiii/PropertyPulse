<?php
require_once "../Database/db_config.php";
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/PHPMailer.php'; // Path to PHPMailer's main class file
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/SMTP.php'; // Path to SMTP class file
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/Exception.php'; // Path to Exception class file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
unset($_SESSION["error-message"]);

// Get form data
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$companyName = isset($_POST['companyName']) ? $_POST['companyName'] : '';
$contactEmail = isset($_POST['contactEmail']) ? $_POST['contactEmail'] : '';
$contactPhone = isset($_POST['contactPhone']) ? $_POST['contactPhone'] : '';
$specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
// $availability = isset($_POST['availability']) ? $_POST['availability'] : '';
// $isActive = isset($_POST['isActive']) ? $_POST['isActive'] : 'false';

// Generate a random number between 1 and 1000
$randomNumber = mt_rand(1, 100000);

// Generate the username
 // Combination of random number, first name, and last letter of last name

$password = isset($_POST['password']) ? $_POST['password'] : '';
// Assuming 'service_worker' as the default userType for this form submission
$userType = 'service_worker';

// Convert isActive to boolean for SQL
$isActive =  0;
// $user_id= $link->insert_id;
// Hash the password for storage
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

do{
    $username =  $firstName . substr($lastName, -1).$randomNumber."SW";// Combination of random number, first name, and last letter of last name

$sql = "SELECT username FROM users WHERE username = ? ";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result =$stmt -> get_result();

}while($row = $result->fetch_assoc());


$stmtUser = $link->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
$stmtUser->bind_param("sss", $username, $hashedPassword, $userType);




// Execute the statement for ServiceWorker
if ($stmtUser->execute()) {
    // Prepare and bind for users table
    // Execute the statement for users

    $user_id= $stmtUser->insert_id;

// Prepare and bind for ServiceWorker table
$stmtServiceWorker = $link->prepare("INSERT INTO serviceworker (FirstName, LastName, CompanyName, ContactEmail, ContactPhone, Specialization, UserID) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmtServiceWorker->bind_param("ssssssi", $firstName, $lastName, $companyName, $contactEmail, $contactPhone, $specialization, $user_id);
    if ($stmtServiceWorker->execute()) {
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
        echo "Error adding user: " . $stmtUser->error;
    }
} else {
    echo "Error adding service provider: " . $stmtServiceWorker->error;
}

// Close statement and connection
$stmtServiceWorker->close();
$stmtUser->close();
$link->close();
?>
