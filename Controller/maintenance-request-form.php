<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "../Database/db_config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issueDescription = $_POST['issue-description'];
    $urgencyLevel = $_POST['urgency-level'];
    $photoUpload = $_FILES['photo-upload'];
    
   
    $stmt = $link->prepare("INSERT INTO maintenance_requests (issue_description, urgency_level, photo_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $issueDescription, $urgencyLevel, $photoPath);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Maintenance request submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $link->close();
}
?>
