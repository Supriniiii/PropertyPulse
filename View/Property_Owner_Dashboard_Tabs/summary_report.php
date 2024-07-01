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
$conn = $link; // Use the connection from db_config.php LEFT JOIN tmaintenancerequest m ON a.ApartmentID = m.PropertyID

// Query to generate the summary report using username
$sql = "
SELECT
    po.OwnerID AS owner_id,
    u.username AS owner_name,
    u.userType AS owner_type,
    p.Name AS property_name,
    p.Address AS property_address,
    p.City AS property_city,
    p.State AS property_state,
    p.ZipCode AS property_zipcode,
    COUNT(DISTINCT a.ApartmentID) AS total_apartments,
    COUNT(DISTINCT t.TenantID) AS total_tenants,
    COUNT(DISTINCT m.RequestID) AS total_maintenance_requests
FROM
    users u
    LEFT JOIN propertyowner po ON u.UserID = po.UserID
    LEFT JOIN property p ON po.OwnerID = p.OwnerID
    LEFT JOIN apartment a ON p.PropertyID = a.PropertyID
    LEFT JOIN ttenant t ON a.TenantID = t.TenantID
    LEFT JOIN tmaintenancerequest m ON t.TenantID = m.TenantID
WHERE
    u.username = ?
    AND u.userType = 'property_owner'
GROUP BY
    po.OwnerID, u.username, u.userType, p.Name, p.Address, p.City, p.State, p.ZipCode;

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
    $pdf->Cell(0, 10, 'Summary Report', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(50, 10, 'Owner ID:', 1);
        $pdf->Cell(140, 10, $row['owner_id'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Owner Name:', 1);
        $pdf->Cell(140, 10, $row['owner_name'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Owner Type:', 1);
        $pdf->Cell(140, 10, $row['owner_type'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Property Name:', 1);
        $pdf->Cell(140, 10, $row['property_name'], 1);
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

        $pdf->Cell(50, 10, 'Total Apartments:', 1);
        $pdf->Cell(140, 10, $row['total_apartments'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Total Tenants:', 1);
        $pdf->Cell(140, 10, $row['total_tenants'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Total Maintenance Requests:', 1);
        $pdf->Cell(140, 10, $row['total_maintenance_requests'], 1);
        $pdf->Ln();
        
        // Add a line break between properties
        $pdf->Ln(5);
    }

    $pdf->Output('D', 'summary_report.pdf');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Summary Report</title>
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
        <h2>Property Owner Summary Report</h2>
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
                <th>Owner ID</th>
                <th>Owner Name</th>
                <th>Owner Type</th>
                <th>Property Name</th>
                <th>Property Address</th>
                <th>Property City</th>
                <th>Property State</th>
                <th>Property ZipCode</th>
                <th>Total Apartments</th>
                <th>Total Tenants</th>
                <th>Total Maintenance Requests</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['owner_id'] . "</td>
                    <td>" . $row['owner_name'] . "</td>
                    <td>" . $row['owner_type'] . "</td>
                    <td>" . $row['property_name'] . "</td>
                    <td>" . $row['property_address'] . "</td>
                    <td>" . $row['property_city'] . "</td>
                    <td>" . $row['property_state'] . "</td>
                    <td>" . $row['property_zipcode'] . "</td>
                    <td>" . $row['total_apartments'] . "</td>
                    <td>" . $row['total_tenants'] . "</td>
                    <td>" . $row['total_maintenance_requests'] . "</td>
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
