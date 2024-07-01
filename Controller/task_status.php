<?php
session_start();
require '../Model/MaintenanceRequest.php';
require '../Database/db_config.php';

if (isset($_POST['submit'])) {
    $serviceworkerDescription=$_POST["serviceworker-description"];
    $urgencyLevel = $_POST["urgency_level"];
    $description = $_POST["description"];

    // Ensure both tenant and user IDs are valid (adjust query if needed)
    $userId = $_SESSION["user_id"];
	
    $stmt = $link->prepare("SELECT TenantID FROM ttenant WHERE UserID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($tenantId);

    if ($stmt->fetch()) { // Check if tenant exists for this user
        $stmt->close();

        $stmt = $link->prepare("INSERT INTO tmaintenancerequest (TenantID, UrgencyLevel, Description,Servicerequired) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $tenantId, $urgencyLevel, $description, $serviceworkerDescription);
		
        if ($stmt->execute()) {
                // Assuming $dbConnection is your database connection
$maintenanceRequest = new MaintenanceRequest($link);
$selectedWorkerId = $maintenanceRequest->findServiceWorkersForOrder($serviceworkerDescription);

                $requestID = $stmt->insert_id;
                $status="Pending";
        $stmt = $link->prepare("INSERT INTO tworkorder (RequestID,Status,WorkerID) VALUES (?, ?,?)");
        $stmt->bind_param("isi", $requestID, $status, $selectedWorkerId);
        $stmt->execute();
            header("Location: ../View/Tenant_Dashboard_Tabs/requestMaintenance.php"); // Success redirect
            exit();
        } else {
            echo "Error: " . $stmt->error; // Error handling (display a more user-friendly message in production)
        }

    } else {
        // Handle case where the user is not associated with a tenant
        echo "Error: You are not authorized to submit a maintenance request."; 
        // (Or redirect to an error page)
    }
        
        
    $stmt->close();
    $link->close();
}
?>
