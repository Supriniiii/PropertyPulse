<?php
	require '../../Database/db_config.php';
if (isset($_POST['rating'])) {
    $rating = (int)$_POST['rating'];

    // Ensure there is an ID to specify which record to update
    if (isset($_POST['workorder_id']) && is_numeric($_POST['workorder_id'])) {
        $workorder_id = (int)$_POST['workorder_id'];

        // Prepare the SQL statement
        $sql = "UPDATE tworkorder SET Rating = ? WHERE WorkOrderID = ?";
        $stmt = $link->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ii", $rating, $workorder_id);
            $stmt->execute();
            header("Location: requestMaintenance.php");
            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                echo "Rating updated successfully.";
            } else {
                echo "No records were updated. Please check the WorkOrderID.";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    } else {
        echo "Invalid or missing WorkOrderID.";
    }
} else {
    echo "Invalid or missing rating.";
}

// Close the connection
$link->close();
	
?>