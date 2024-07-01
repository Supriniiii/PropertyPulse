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

// Query to generate the summary report for service providers using username
$sql = "
SELECT
    sw.WorkerID AS service_provider_id,
    u.username AS service_provider_name,
    sw.FirstName AS first_name,
    sw.LastName AS last_name,
    sw.CompanyName AS company_name,
    sw.ContactEmail AS contact_email,
    sw.ContactPhone AS contact_phone,
    sw.Specialization AS specialization,
    (SELECT COUNT(*) FROM tworkorder w WHERE w.WorkerID = sw.WorkerID) AS total_service_requests
FROM
    users u
    LEFT JOIN serviceworker sw ON u.UserID = sw.UserID
WHERE
    u.username = ?
    AND u.userType = 'service_worker';
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
    $pdf->Cell(0, 10, 'Service Provider Summary Report', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(50, 10, 'Service Provider ID:', 1);
        $pdf->Cell(140, 10, $row['service_provider_id'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Service Provider Name:', 1);
        $pdf->Cell(140, 10, $row['first_name'] . ' ' . $row['last_name'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Company Name:', 1);
        $pdf->Cell(140, 10, $row['company_name'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Contact Email:', 1);
        $pdf->Cell(140, 10, $row['contact_email'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Contact Phone:', 1);
        $pdf->Cell(140, 10, $row['contact_phone'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Specialization:', 1);
        $pdf->Cell(140, 10, $row['specialization'], 1);
        $pdf->Ln();

        $pdf->Cell(50, 10, 'Total Service Requests:', 1);
        $pdf->Cell(140, 10, $row['total_service_requests'], 1);
        $pdf->Ln();

        // Service Requests
        $pdf->Cell(0, 10, 'Service Requests:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        
        $service_request_sql = "
        SELECT
            m.RequestID,
            m.Description,
            m.UrgencyLevel,
            m.ServiceRequired,
            w.Status
        FROM
            tmaintenancerequest m
        JOIN
            tworkorder w ON m.RequestID = w.RequestID
        WHERE
            w.WorkerID = ?
        ";

        $service_request_stmt = $conn->prepare($service_request_sql);
        $service_request_stmt->bind_param("i", $row['service_provider_id']);
        $service_request_stmt->execute();
        $service_request_result = $service_request_stmt->get_result();

        if ($service_request_result->num_rows > 0) {
            while ($service_request_row = $service_request_result->fetch_assoc()) {
                $pdf->Cell(50, 10, 'Request ID:', 1);
                $pdf->Cell(140, 10, $service_request_row['RequestID'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Description:', 1);
                $pdf->Cell(140, 10, $service_request_row['Description'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Urgency Level:', 1);
                $pdf->Cell(140, 10, $service_request_row['UrgencyLevel'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Service Required:', 1);
                $pdf->Cell(140, 10, $service_request_row['ServiceRequired'], 1);
                $pdf->Ln();

                $pdf->Cell(50, 10, 'Status:', 1);
                $pdf->Cell(140, 10, $service_request_row['Status'], 1);
                $pdf->Ln();

                // Add a line break between service requests
                $pdf->Ln(5);
            }
        } else {
            $pdf->Cell(0, 10, 'No service requests found.', 0, 1, 'L');
        }

        // Add a line break between service providers
        $pdf->Ln(10);
    }

    $pdf->Output('D', 'service_provider_summary_report.pdf');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Provider Summary Report</title>
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
        <h2>Service Provider Summary Report</h2>
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
                <th>Service Provider ID</th>
                <th>Service Provider Name</th>
                <th>Company Name</th>
                <th>Contact Email</th>
                <th>Contact Phone</th>
                <th>Specialization</th>
                <th>Total Service Requests</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['service_provider_id'] . "</td>
                    <td>" . $row['first_name'] . ' ' . $row['last_name'] . "</td>
                    <td>" . $row['company_name'] . "</td>
                    <td>" . $row['contact_email'] . "</td>
                    <td>" . $row['contact_phone'] . "</td>
                    <td>" . $row['specialization'] . "</td>
                    <td>" . $row['total_service_requests'] . "</td>
                    </tr>";

                    // Service Requests
                    echo "<tr><td colspan='7'><b>Service Requests:</b></td></tr>";
                    $service_request_sql = "
                    SELECT
                        m.RequestID,
                        m.Description,
                        m.UrgencyLevel,
                        m.ServiceRequired,
                        w.Status
                    FROM
                        tmaintenancerequest m
                    JOIN
                        tworkorder w ON m.RequestID = w.RequestID
                    WHERE
                        w.WorkerID = ?
                    ";

                    $service_request_stmt = $conn->prepare($service_request_sql);
                    $service_request_stmt->bind_param("i", $row['service_provider_id']);
                    $service_request_stmt->execute();
                    $service_request_result = $service_request_stmt->get_result();

                    if ($service_request_result->num_rows > 0) {
                        echo "<tr>
                        <th>Request ID</th>
                        <th>Description</th>
                        <th>Urgency Level</th>
                        <th>Service Required</th>
                        <th>Status</th>
                        </tr>";
                        while ($service_request_row = $service_request_result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $service_request_row['RequestID'] . "</td>
                            <td>" . $service_request_row['Description'] . "</td>
                            <td>" . $service_request_row['UrgencyLevel'] . "</td>
                            <td>" . $service_request_row['ServiceRequired'] . "</td>
                            <td>" . $service_request_row['Status'] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No service requests found.</td></tr>";
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
