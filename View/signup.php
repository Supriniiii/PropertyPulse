<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Property Management System Selection</title>
  <style>
    /* Include your CSS here, as it remains unchanged */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #1a1a2e; /* Twilight background color */
    }

    .container {
      width: 100%;
      max-width: 400px;
      margin: 100px auto;
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

    #button{
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #4f4f7a; /* Adjusted border color */
      border-radius: 4px;
      box-sizing: border-box;
      background-color: #3a3a4e; /* Adjusted input background color */
      color: #fff; /* Adjusted text color */
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    input[type="button"]:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="container" id="selection-container">
    <h2>Select Your Role</h2>
    <div class="role-selection">
      <a href="add_tenant.php" ><button id="button" > Tenant </button></a>
      <a href="propertyApplication.php"><button id="button"> Property Owner </button></a>
      <a href="Specialization.php"><button id="button"> Service Provider</button></a>
    </div>
  </div>
</body>
</html>
