<?php
session_start();

// Include database configuration file
require_once '../../Database/db_config.php';

// Check if the username is set in the session
if (!isset($_SESSION['user_username'])) {
    die("Username not set in session.");
}

$username = $_SESSION['user_username'];

// Database connection
$conn = $link; // Use the connection from db_config.php

// Query to get the property owner's ID
$ownerIDQuery = "
SELECT propertyowner.OwnerID
FROM users
JOIN propertyowner ON users.UserID = propertyowner.UserID
WHERE users.username = ?;
";

$ownerIDStmt = $conn->prepare($ownerIDQuery);
$ownerIDStmt->bind_param("s", $username);
$ownerIDStmt->execute();
$ownerIDResult = $ownerIDStmt->get_result();
$ownerIDRow = $ownerIDResult->fetch_assoc();
$ownerID = $ownerIDRow['OwnerID'];

// Query to list tenant applications for the property owner's properties
$sql = "
SELECT 
    po.FirstName AS OwnerFirstName,
    po.LastName AS OwnerLastName,
    p.Name AS PropertyName,
    a.ApartmentNumber,
    t.FirstName AS TenantFirstName,
    t.LastName AS TenantLastName,
    ra.monthly_income,
    ra.property_choice,
    ra.applicationstatus
FROM 
    propertyowner po
JOIN 
    property p ON po.OwnerID = p.OwnerID
JOIN 
    apartment a ON p.PropertyID = a.PropertyID
JOIN 
    residence_applications ra ON a.ApartmentID = ra.property_choice
JOIN 
    ttenant t ON ra.tenant_id = t.TenantID
WHERE 
    po.OwnerID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ownerID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Tenant Applications</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a2e; /* Twilight background color */
        }
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2a2a3e; /* Adjusted background color */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        h2 {
            text-align: center;
            color: #6cb6ff; /* Adjusted text color */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff; /* Adjusted text color */
        }
        th, td {
            padding: 10px;
            border: 1px solid #4f4f7a; /* Adjusted border color */
            text-align: left;
            color: #fff; /* Adjusted text color */
            white-space: nowrap; /* Ensure table cells don't wrap */
        }
        th {
            background-color: #3e3e5e; /* Adjusted background color for header */
        }
        tr:nth-child(even) {
            background-color: #3e3e5e; /* Adjusted background color for even rows */
        }
        .no-records {
            text-align: center;
            color: #fff;
            margin-top: 20px;
        }
        .table-container {
            overflow-x: auto; /* Make table responsive */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tenant Applications</h2>
        <div class="table-container">
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                <tr>
                <th>Owner First Name</th>
                <th>Owner Last Name</th>
                <th>Property Name</th>
                <th>Apartment Number</th>
                <th>Tenant First Name</th>
                <th>Tenant Last Name</th>
                <th>Monthly Income</th>
                <th>Property Choice</th>
                <th>Application Status</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['OwnerFirstName'] . "</td>
                    <td>" . $row['OwnerLastName'] . "</td>
                    <td>" . $row['PropertyName'] . "</td>
                    <td>" . $row['ApartmentNumber'] . "</td>
                    <td>" . $row['TenantFirstName'] . "</td>
                    <td>" . $row['TenantLastName'] . "</td>
                    <td>" . $row['monthly_income'] . "</td>
                    <td>" . $row['property_choice'] . "</td>
                    <td>" . $row['applicationstatus'] . "</td>
                    </tr>";
                }

                echo "</table>";
            } else {
                echo "<div class='no-records'>No records found.</div>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
