<?php
session_start();

$RequestIDFG = $_GET["ids"];
$name = $_GET["name"];
$Status = $_POST["task_status"];
$submit = $_POST["submit"];

require '../Database/db_config.php';


function updateStatus($link, $RequestIDFG, $newStatus) {
    $statusUpdate = "UPDATE service_schedule SET Status = ? WHERE WorkOrderID = ?";
    $stmt = $link->prepare($statusUpdate);
    if ($stmt === false) {
        die("Failed to prepare the statement: " . $link->error);
    }
    $stmt->bind_param('si', $newStatus, $RequestIDFG);
    if ($stmt->execute()) {
        header('Location: ../View/Service_Provider_Dashboard_Tabs/taskStatusUpdate.php');
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

if ($Status == "In Progress") {
    updateStatus($link, $RequestIDFG, "In Progress");
} elseif ($Status == "Pending") {
    updateStatus($link, $RequestIDFG, "Pending");
} elseif ($Status == "Completed") {
    updateStatus($link, $RequestIDFG,"Completed");
}




?>
