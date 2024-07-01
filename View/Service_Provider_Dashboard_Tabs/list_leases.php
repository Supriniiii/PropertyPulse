<?php
require "../../Database/db_config.php";
$sql = "SELECT * FROM tlease";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>List of Leases</title>
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

    <h1>List of Leases</h1>


    <button onclick="window.history.back()" class="back-button">
        Back
    </button>

    <p>
        <br />
    </p>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
              <tr>
                <th>LeaseID</th>
                <th>TenantID</th>
                <th>StartDate</th>
                <th>EndDate</th>
                <th>Rent</th>
                <th>RentEscalation</th>
                <th>PropertyID</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["LeaseID"] . "</td>
                <td>" . $row["TenantID"] . "</td>
                <td>" . $row["StartDate"] . "</td>
                <td>" . $row["EndDate"] . "</td>
                <td>" . $row["Rent"] . "</td>
                <td>" . $row["RentEscalation"] . "</td>
                <td>" . $row["PropertyID"] . "</td>
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