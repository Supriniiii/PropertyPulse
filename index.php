<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Property Management System Login</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #1a1a2e; /* Twilight background color */
            background-image: url('WhatsApp Image 2024-06-25 at 08.13.41.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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
    input[type="password"],
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

    .signup-link {
      text-align: center;
      color: #6cb6ff; /* Adjusted text color */
    }

    .signup-link a {
      color: #6cb6ff; /* Adjusted text color */
      text-decoration: none;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 10px;
    }

    /* Popup style */
    .popup {
      position: fixed;
      top: -100px;
      left: 50%;
      transform: translate(-50%, 0);
      padding: 20px;
      background-color: #2a2a3e;
      border: 1px solid #4f4f7a;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      color: #fff;
      z-index: 1000;
      text-align: center;
      transition: top 0.5s ease-in-out, opacity 0.5s ease-in-out;
      opacity: 1;
    }

    .popup.hidden {
      top: -100px;
      opacity: 0;
    }

    .popup button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #28a745;
      border: none;
      border-radius: 4px;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    .popup button:hover {
      background-color: #218838;
    }
    
          .logo {
            width: 100%; /* Ensures the logo div takes up full width of body */
            text-align: center; /* Centers the content horizontally */
        }

        .logo img {
            max-width: 100%;
            max-height: 100%;
            display: block; /* Ensures the image behaves as a block element */
            margin: auto; /* Centers the image vertically within its container */
        }
         
  </style>
</head>
<body>
      
<?php
    if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
        echo "<div class='popup' id='popup'>
                <p>An email has been sent to you with your new username. Please use the new username to login.</p>
                <button onclick='closePopup()'>Close</button>
              </div>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() { 
                  document.getElementById('popup').style.top = '20px'; 
                });
              </script>";
    }
?>
  <div class="container" id="login-container">
    <?php
        $error_message = (isset($_SESSION["error_message"])) ? $_SESSION["error_message"] : "";
    ?>
    <h2>Login</h2>
    <?php if(isset($error_message) && !empty($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="Controller/verify_user.php" method="post" id="login-form">
      <input type="text" name="username" placeholder="Username" required /><br />
      <input type="password" name="password" placeholder="Password" required /><br />
      <input type="submit" value="Login"  />
    </form>
    <div class="signup-link">
      <p>Don't have an account? <a href="View/signup.php">Sign up</a></p>
      <p>Forgot password? <a href="View/forgot_password[1].php">Forgot password</a></p>
    </div>
  </div>
  <script>
    function closePopup() {
      var popup = document.getElementById('popup');
      popup.classList.add('hidden');
      setTimeout(function() {
        popup.style.display = 'none';
      }, 500); // Match the transition duration
    }
  </script>
</body>
</html>
