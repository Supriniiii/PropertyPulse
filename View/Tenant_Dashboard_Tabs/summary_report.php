<?php
session_start();

// Include database configuration file
require_once '../../Database/db_config.php';

// Include FPDF library
require_once '../../fpdf186/fpdf.php';

// Check if the username is set in the session
if (!isset($_SESSION['user_username'])) {
    die("Username not set in session.");
}

$username = $_SESSION['user_username'];

// Database connection
$conn = $link; // Use the connection from db_config.php

// Query to generate the summary report for tenants using username
$sql = "
SELECT
    t.TenantID AS tenant_id,
    u.username AS tenant_name,
    t.FirstName AS tenant_first_name,
    t.LastName AS tenant_last_name,
    t.ContactInfo AS tenant_contact,
    t.IsActive AS tenant_status,
    p.Name AS property_name,
    a.ApartmentNumber AS apartment_number,
    p.Address AS property_address,
    p.City AS property_city,
    p.State AS property_state,
    p.ZipCode AS property_zipcode,
    (SELECT COUNT(*) FROM tmaintenancerequest m WHERE m.TenantID = t.TenantID) AS total_maintenance_requests
FROM
    users u
    LEFT JOIN ttenant t ON u.UserID = t.UserID
    LEFT JOIN apartment a ON t.TenantID = a.TenantID
    LEFT JOIN property p ON a.PropertyID = p.PropertyID
WHERE
    u.username = ?
    AND u.userType = 'tenant';
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['download_pdf'])) {
    // Generate PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    
    // Add report title
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Tenant Summary Report', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(50, 10, 'Tenant ID:', 1);
        $pdf->Cell(140, 10, $row['tenant_id'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Tenant Name:', 1);
        $pdf->Cell(140, 10, $row['tenant_first_name'] . ' ' . $row['tenant_last_name'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Contact Info:', 1);
        $pdf->Cell(140, 10, $row['tenant_contact'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Status:', 1);
        $pdf->Cell(140, 10, $row['tenant_status'] ? 'Active' : 'Inactive', 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Property Name:', 1);
        $pdf->Cell(140, 10, $row['property_name'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Apartment Number:', 1);
        $pdf->Cell(140, 10, $row['apartment_number'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Property Address:', 1);
        $pdf->Cell(140, 10, $row['property_address'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'City:', 1);
        $pdf->Cell(140, 10, $row['property_city'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'State:', 1);
        $pdf->Cell(140, 10, $row['property_state'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Zip Code:', 1);
        $pdf->Cell(140, 10, $row['property_zipcode'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Total Maintenance Requests:', 1);
        $pdf->Cell(140, 10, $row['total_maintenance_requests'], 1);
        $pdf->Ln();

        // Maintenance Requests
        $pdf->Cell(0, 10, 'Maintenance Requests:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        
        $maintenance_sql = "
        SELECT
            m.RequestID,
            m.Description,
            m.UrgencyLevel,
            m.ServiceRequired
        FROM
            tmaintenancerequest m
        WHERE
            m.TenantID = ?
        ";

        $maintenance_stmt = $conn->prepare($maintenance_sql);
        $maintenance_stmt->bind_param("i", $row['tenant_id']);
        $maintenance_stmt->execute();
        $maintenance_result = $maintenance_stmt->get_result();

        if ($maintenance_result->num_rows > 0) {
            while ($maintenance_row = $maintenance_result->fetch_assoc()) {
                $pdf->Cell(50, 10, 'Request ID:', 1);
                $pdf->Cell(140, 10, $maintenance_row['RequestID'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Description:', 1);
                $pdf->Cell(140, 10, $maintenance_row['Description'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Urgency Level:', 1);
                $pdf->Cell(140, 10, $maintenance_row['UrgencyLevel'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Service Required:', 1);
                $pdf->Cell(140, 10, $maintenance_row['ServiceRequired'], 1);
                $pdf->Ln();

                // Add a line break between maintenance requests
                $pdf->Ln(5);
            }
        } else {
            $pdf->Cell(0, 10, 'No maintenance requests found.', 0, 1, 'L');
        }

        // Add a line break between tenants
        $pdf->Ln(10);
    }

    $pdf->Output('D', 'tenant_summary_report.pdf');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tenant Summary Report</title>
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
        .download-button {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .download-button button {
            background-color: #6cb6ff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tenant Summary Report</h2>
        <form method="post">
            <div class="download-button">
                <button type="submit" name="download_pdf">Download PDF</button>
            </div>
        </form>
        <div class="table-container">
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                <tr>
                <th>Tenant ID</th>
                <th>Tenant Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Info</th>
                <th>Status</th>
                <th>Property Name</th>
                <th>Apartment Number</th>
                <th>Property Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Total Maintenance Requests</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['tenant_id'] . "</td>
                    <td>" . $row['tenant_name'] . "</td>
                    <td>" . $row['tenant_first_name'] . "</td>
                    <td>" . $row['tenant_last_name'] . "</td>
                    <td>" . $row['tenant_contact'] . "</td>
                    <td>" . ($row['tenant_status'] ? 'Active' : 'Inactive') . "</td>
                    <td>" . $row['property_name'] . "</td>
                    <td>" . $row['apartment_number'] . "</td>
                    <td>" . $row['property_address'] . "</td>
                    <td>" . $row['property_city'] . "</td>
                    <td>" . $row['property_state'] . "</td>
                    <td>" . $row['property_zipcode'] . "</td>
                    <td>" . $row['total_maintenance_requests'] . "</td>
                    </tr>";

                    // Maintenance Requests
                    echo "<tr><td colspan='13'><b>Maintenance Requests:</b></td></tr>";
                    $maintenance_sql = "
                    SELECT
                        m.RequestID,
                        m.Description,
                        m.UrgencyLevel,
                        m.ServiceRequired
                    FROM
                        tmaintenancerequest m
                    WHERE
                        m.TenantID = ?
                    ";

                    $maintenance_stmt = $conn->prepare($maintenance_sql);
                    $maintenance_stmt->bind_param("i", $row['tenant_id']);
                    $maintenance_stmt->execute();
                    $maintenance_result = $maintenance_stmt->get_result();

                    if ($maintenance_result->num_rows > 0) {
                        echo "<tr>
                        <th>Request ID</th>
                        <th>Description</th>
                        <th>Urgency Level</th>
                        <th>Service Required</th>
                        </tr>";
                        while ($maintenance_row = $maintenance_result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $maintenance_row['RequestID'] . "</td>
                            <td>" . $maintenance_row['Description'] . "</td>
                            <td>" . $maintenance_row['UrgencyLevel'] . "</td>
                            <td>" . $maintenance_row['ServiceRequired'] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No maintenance requests found.</td></tr>";
                    }
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