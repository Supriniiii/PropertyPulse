<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Owner Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            color:#6cb6ff;;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #4cae4c;
        }
    </style>
   
</head>

<body>

   <div class="container">
        <h2>Service Provider Specialization</h2>

        <form action="process_specialization.php" method="post">
            <h3><label for="specialization">Choose a specialization:</label></h3>
            <select id="specialization" name="specialization" required>
                <option value="Plumber">Plumber</option>
                <option value="Electrician">Electrician</option>
                <option value="Glazier">Glazier</option>
                <option value="Security">Security</option>
                <option value="Tile Installer">Tile Installer</option>
                <option value="Carpenter">Carpenter</option>
            </select>
                <br />
            <button type="submit" class="btn">Submit Specialization</button>

        </form>

    </div>

</body>

</html>

<?php

?>