<?php
require_once '../../Database/db_config.php'; // Ensure this file includes database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming $_POST data is validated and sanitized properly
    $ScheduleID = $_POST['ScheduleID'];
    $ServiceDescription = $_POST['ServiceDescription'];
    $Notes = $_POST['Notes'];
    $StartDateTime = $_POST['StartDateTime'];
    $EndDateTime = $_POST['EndDateTime'];
    $Status = $_POST['Status'];
   // $WorkOrderID = (int)$_POST['ScheduleRequestID']; // Assuming ScheduleRequestID is from your form

    if (empty($ScheduleID)) {
        // Insert new schedule
        $sql = "INSERT INTO service_schedule (StartDateTime, EndDateTime, ServiceDescription, Status, Notes) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("sssss", $StartDateTime, $EndDateTime, $ServiceDescription, $Status, $Notes);
    } else {
        // Update existing schedule
        $sql = "UPDATE service_schedule SET StartDateTime = ?, EndDateTime = ?, ServiceDescription = ?, Status = ?, Notes = ? 
                WHERE ScheduleID = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("sssss", $StartDateTime, $EndDateTime, $ServiceDescription, $Status, $Notes, $ScheduleID);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Schedule Successfully Saved.'); window.location.href = './';</script>";
        exit;
    } else {
        echo "<pre>";
        echo "An Error occurred.<br>";
        echo "Error: " . $stmt->error . "<br>";
        echo "SQL: " . $sql . "<br>";
        echo "</pre>";
    }

    $stmt->close();
    $link->close();
}
?>
