<?php
require "../../Database/db_config.php";

$sql = "SELECT * FROM ttenant";
$result = $link->query($sql);

// Queries to get the counts
$totalApplicantsQuery = "SELECT COUNT(*) as total FROM residence_applications";
$approvedApplicantsQuery = "SELECT COUNT(*) as approved FROM residence_applications WHERE applicationstatus = 'accepted'";
$notApprovedApplicantsQuery = "SELECT COUNT(*) as not_approved FROM residence_applications WHERE applicationstatus = 'rejected'";
$pendingApplicantsQuery = "SELECT COUNT(*) as pending FROM residence_applications WHERE applicationstatus = 'pending'";

$totalApplicantsResult = $link->query($totalApplicantsQuery)->fetch_assoc();
$approvedApplicantsResult = $link->query($approvedApplicantsQuery)->fetch_assoc();
$notApprovedApplicantsResult = $link->query($notApprovedApplicantsQuery)->fetch_assoc();
$pendingApplicantsResult = $link->query($pendingApplicantsQuery)->fetch_assoc();

// Query to get applications over time
$applicationsOverTimeQuery = "SELECT DATE(application_date) as date, COUNT(*) as count FROM residence_applications GROUP BY DATE(application_date)";
$applicationsOverTimeResult = $link->query($applicationsOverTimeQuery);

$dates = [];
$counts = [];

while ($row = $applicationsOverTimeResult->fetch_assoc()) {
    $dates[] = $row['date'];
    $counts[] = $row['count'];
}

// Query to fetch tenants' information
$tenantsQuery = "SELECT * FROM ttenant";
$tenantsResult = $link->query($tenantsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid white;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
        }

        body {
            background-color: #2a2a3e;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        .back-button {
            background-color: green;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .chart-container {
            position: relative;
            height: 40vh;
            margin-bottom: 50px;
        }

        .back-button {
            border: 0;
            background: #28a745;
            color: #fff;
            width: auto;
            height: 3.5em;
            padding: 0 2.25em;
            border-radius: 3.5em;
            font-size: 1em;
            text-transform: uppercase;
            font-weight: 600;
            transition: background-color 0.15s;
            border-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Summary Report</h1>
        <button onclick="window.history.back()" class="back-button">
            Back
        </button>
        <h2>Applicant Statistics</h2>
        <p>Total Applicants: <?php echo $totalApplicantsResult['total']; ?></p>
        <p>Approved Applicants: <?php echo $approvedApplicantsResult['approved']; ?></p>
        <p>Not Approved Applicants: <?php echo $notApprovedApplicantsResult['not_approved']; ?></p>
        <p>Pending Applicants: <?php echo $pendingApplicantsResult['pending']; ?></p>

        <div class="chart-container">
            <canvas id="applicantStatusChart"></canvas>
        </div>
        <!--<div class="chart-container">
            <canvas id="applicationsOverTimeChart"></canvas>
        </div>-->
    </div>

    <h2>Tenants Information</h2>
    <table>
        <tr>
            <th>Tenant ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Info</th>
            <!--<th>Apartment ID</th>
            <th>Property ID</th>-->
        </tr>
        <?php
        if ($tenantsResult->num_rows > 0) {
            while ($row = $tenantsResult->fetch_assoc()) {
                echo "<tr>
                            <td>" . $row["TenantID"] . "</td>
                            <td>" . $row["FirstName"] . "</td>
                            <td>" . $row["LastName"] . "</td>
                            <td>" . $row["ContactInfo"] . "</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No tenants found</td></tr>";
        }
        ?>
    </table>
    <p></p>

    <div class="button-container">
        <button onclick="printPreview()" class="back-button">Print Preview</button>
        <button onclick="savePDF()" class="back-button">Save PDF</button>
        <button onclick="saveCSV()" class="back-button">Save CSV</button>
    </div>

    <script>
        // Bar chart for applicant statuses
        var ctx1 = document.getElementById('applicantStatusChart').getContext('2d');
        var applicantStatusChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Total', 'Approved', 'Not Approved', 'Pending'],
                datasets: [{
                    label: 'Number of Applicants',
                    data: [
                        <?php echo $totalApplicantsResult['total']; ?>,
                        <?php echo $approvedApplicantsResult['approved']; ?>,
                        <?php echo $notApprovedApplicantsResult['not_approved']; ?>,
                        <?php echo $pendingApplicantsResult['pending']; ?>
                    ],
                    backgroundColor: [
                        '#28a745',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        '#6cb6ff'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line chart for applications over time
        var ctx2 = document.getElementById('applicationsOverTimeChart').getContext('2d');
        var applicationsOverTimeChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Number of Applications',
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function printPreview() {
            window.print();
        }

        function savePDF() {
            // You can use a library like jsPDF to generate and save PDF
            // For example:
            var pdf = new jsPDF();
            pdf.text('Summary Report', 10, 10);
            // // Add more content as needed
            pdf.save('summary_report.pdf');
        }

        function saveCSV() {
            // Implement CSV generation and download functionality
            // Example:
            var csvContent = 'data:text/csv;charset=utf-8,';
            tenantsData.forEach(function (rowArray) {
                var row = rowArray.join(',');
                csvContent += row + '\r\n';
            });
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'summary_report.csv');
            document.body.appendChild(link);
            link.click();
        }
    </script>
</body>

</html>
