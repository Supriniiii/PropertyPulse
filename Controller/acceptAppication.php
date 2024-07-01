<?php
require_once "../Database/db_config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['show'] = true;
    $ownerID = $_SESSION["owner_id"];
    $applicationID = $_POST['applicationID'];

    // Fetch application details
    $sql1 = "SELECT * FROM residence_applications WHERE ApplicationID = ?";
    $stmt1 = $link->prepare($sql1);
    $stmt1->bind_param("i", $applicationID);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Ensure the TenantID and ApartmentID are fetched correctly
        $tenantID = $row['TenantID'];
        $apartmentID = $row['ApartmentID'];

        // Update apartment with tenantID
        $sql3 = "UPDATE apartment SET tenantID = ? WHERE ApartmentID = ?";
        $stmt3 = $link->prepare($sql3);
        $stmt3->bind_param("ii", $tenantID, $apartmentID);
        $stmt3->execute();

        // Update apartment status
        $sql4 = "UPDATE apartment SET status = 3 WHERE tenantID = ?";
        $stmt4 = $link->prepare($sql4);
        $stmt4->bind_param("i", $tenantID);
        $stmt4->execute();

        // Update residence application approval status
        $sql2 = "UPDATE residence_applications SET approved = 1 WHERE tenantID = ?";
        $stmt2 = $link->prepare($sql2);
        $stmt2->bind_param("i", $tenantID);
        $stmt2->execute();
        
        // Close the statements
        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
    } else {
        // Handle the case where the application ID does not exist
        // You might want to set an error message or log this
        $_SESSION['error'] = "Application ID not found.";
    }

    // Redirect to notifications page
    header("Location: ../View/Property_Owner_Dashboard_Tabs/notifications.php");
    exit();
}

// Close the database connection
$link->close();
?>
