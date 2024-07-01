<?php
session_start();
$username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : 'Guest';
require "../../Database/db_config.php";
if(!isset( $_SESSION["view_maintance"] )) {
 $_SESSION["view_maintance"] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenant Dashboard</title>
  <link rel="stylesheet" href="../../css/basicAlluse.css">
  <style>
    .hidden {
      display: none;
    }
    body {
            margin: 0;
            font-family: sans-serif;
            background: #2a2a3e;
        }
        .content-wrap {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-head {
            background: #2a2a3e;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-head h1 {
            margin: 0;
        }
        .container {
            background: #2a2a3e;
            box-sizing: border-box;
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
        }
        .card {
            background: #1b253d;
            border: 5px solid white;
            box-sizing: border-box;
            color: #2a2a3e;
            padding: 20px;
            border-radius: 15px;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        input[type="submit"] {
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
            transition: background-color 0.15s ease;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .hidden {
            display: none;
        }
        .action {
            text-align: center;
            margin-top: 20px;
        }
  display: none;
        }
  </style>
</head>
<body>
  <div class="dashboard">
    <aside class="search-wrap">
      <!-- Search and User Actions -->
      
        <div class="search">
          <!--<label for="search">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
              <path
                d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"
              />
            </svg>
            <input type="text" id="search" style="width: 100%" />
          </label>-->
        </div>

        <div class="user-actions">
                
        
        </div>
      
            
    </aside>

    <header class="menu-wrap">
      <!-- User Avatar and Navigation Menu -->
      <figure class="user">
          <div class="user-avatar">
              <img
                src="WhatsApp Image 2024-06-25 at 08.13.41.jpeg"
                alt=""
              />
          </div>
          <figcaption><?php echo $username ?></figcaption>
        </figure>

       <nav>
          <section class="dicover">

            <ul>
              <li>
                <a href="../tenant_dashboard.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z"
                    />
                  </svg>
                  Home
                </a>
              </li>


            <?php 
              if( $_SESSION["view_maintance"] ){
        ?>
              <li>
              <a href="requestMaintenance.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M5.707 19.707L12 13.414l4.461 4.461L14.337 20H20v-5.663l-2.125 2.124L13.414 12l4.461-4.461L20 9.663V4h-5.663l2.124 2.125L12 10.586 5.707 4.293 4.293 5.707 10.586 12l-6.293 6.293z"
                    />
                  </svg>
                  Request Maintenance
                </a>
              </li>
          <?php  }
                  
          ?>

              <li>
                <a href="update_details.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M12 3C6.486 3 2 6.364 2 10.5c0 2.742 1.982 5.354 5 6.678V21a.999.999 0 0 0 1.707.707l3.714-3.714C17.74 17.827 22 14.529 22 10.5 22 6.364 17.514 3 12 3zm0 13a.996.996 0 0 0-.707.293L9 18.586V16.5a1 1 0 0 0-.663-.941C5.743 14.629 4 12.596 4 10.5 4 7.468 7.589 5 12 5s8 2.468 8 5.5-3.589 5.5-8 5.5z"
                    />
                  </svg>
                  Update My Details
                </a>
              </li>

            </ul>
          </section>
        </nav>
    </header>

    <main class="content-wrap">
        <div class="content-wrap">
        <header class="content-head">
            <h1>Update Details</h1>
            <div class="action">
          <button onclick="window.history.back()">Back</button>
        </div>
        </header>
        <div class="container">
            <div class="card">
                <h2 class="card-title">Update Your Information</h2>
                <form action="../../Controller/update_details.php" method="POST" id="updateForm">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="fields[]" value="name" onclick="toggleField('name')">
                            Name
                        </label>
                        <input type="text" id="name" name="name" class="hidden">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="fields[]" value="last_name" onclick="toggleField('last_name')">
                            Last Name
                        </label>
                        <input type="text" id="last_name" name="last_name" class="hidden">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="fields[]" value="email" onclick="toggleField('email')">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" class="hidden">
                    </div>
                    <div class="action">
                        <input type="submit" value="Submit details to update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
  </div>

  <script>
    // Function to toggle field visibility based on checkbox selection
    function toggleField(fieldName) {
      var field = document.getElementById(fieldName);
      if (field.classList.contains('hidden')) {
        field.classList.remove('hidden');
      } else {
        field.classList.add('hidden');
      }
    }
  </script>
</body>
</html>
