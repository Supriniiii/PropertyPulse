<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>
  <style>
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

    input[type="text"],
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #4f4f7a; /* Adjusted border color */
      border-radius: 4px;
      box-sizing: border-box;
      background-color: #3a3a4e; /* Adjusted input background color */
      color: #fff; /* Adjusted text color */
    }

    input[type="submit"] {
      background-color: #28a745;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    input[type="submit"]:hover {
      background-color: #218838;
    }

    .login-link {
      text-align: center;
      color: #6cb6ff; /* Adjusted text color */
    }

    .login-link a {
      color: #6cb6ff; /* Adjusted text color */
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    
      unset($_SESSION["error_message"]);
    ?>
    
    <h2>Forgot Password</h2>
    <?php if(isset($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="../Controller/send_reset_link.php" method="POST">
      <?php if(isset($error_message) && $error_message === "Email not found"): ?>
        <p class="error-message">Email not found in the database.</p>
      <?php endif; ?>
      <input type="text" name="username" placeholder="Enter your username" required /><br />
      <input type="submit" value="Reset Password" />
    </form>

    <div class="login-link">
    <p>Remember your password? <a href="../index.php">Log in</a></p>
    </div>
  </div>
</body>
</html>
