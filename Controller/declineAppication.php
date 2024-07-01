<?php
require_once "../Database/db_config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ownerID = $_SESSION["owner_id"];
    $tenantID = $_POST['applicationID'];

    // Update residence application rejection status
    $sql = "UPDATE residence_applications SET approved = -1 WHERE tenantID = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $tenantID);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Redirect to notifications page
    header("Location: ../View/Property_Owner_Dashboard_Tabs/notifications.php");
    exit();
}
?>
