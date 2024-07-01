<?php
require "../../Database/db_config.php";

// Create connection



$sql = "SELECT * FROM residence_applications";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>List of Applicants</title>
    <style>
        body {
            background-color: #2a2a3e;
            color: white;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid white;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
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
    <h1>List of Applicants</h1>
    <button onclick="window.history.back()" class="back-button">
        Back
    </button>

    <p>
        Approved status :
    <ul>
        <li>-1 means the application is PENDING</li>
        <li> 1 means the application is APPROVED</li>
        <li> 0 means the application is NOT APPROVED</li>
    </ul>
    </p>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
              <tr>
                <th>ApplicationID</th>
                <th>TenantID</th>
                <th>OwnerID</th>
                <th>City</th>
                <th>Address</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Application Date</th>
                <th>Approved</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["ApplicationID"] . "</td>
                <td>" . $row["TenantID"] . "</td>
                <td>" . $row["OwnerID"] . "</td>
                <td>" . $row["city"] . "</td>
                <td>" . $row["address"] . "</td>
                <td>" . $row["bedrooms"] . "</td>
                <td>" . $row["bathrooms"] . "</td>
                <td>" . $row["application_date"] . "</td>
                <td>" . $row["Approved"] . "</td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $link->close();
    ?>
</body>

</html>