<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a2e;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #2a2a3e;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #6cb6ff;
        }
        input[type="password"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #4f4f7a;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #3a3a4e;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #28a745;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .show-password {
            text-align: left;
            margin: 10px 0; /* Adjust as needed */
        }

        .show-password a {
            color: #6cb6ff;
            text-decoration: none;
            font-size: 0.9em;
        }

        .show-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <form action="../Controller/update_password.php" method="POST">
      <input type="hidden" name="username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">
      <label for="password">New Password:</label>
      <input type="password" id="password" name="password" required>
      <label for="confirm_password">Confirm New Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <input type="submit" value="Reset Password">
    </form>
  </div>
</body>
</html>
