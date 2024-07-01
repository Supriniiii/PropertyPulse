<?php

require_once "../Database/db_config.php";
require_once "../Model/verify_user.php";

//session_start();
// Default value for application update session variable



try {
    // Prepare SQL statement to get TenantID based on UserID
    $sql = "SELECT TenantID FROM ttenant WHERE UserID = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the TenantID and store in session
    if ($row = $result->fetch_assoc()) {
        $_SESSION['tenant_id'] = $row['TenantID'];
        $tenant_id=$_SESSION['tenant_id'];
    }
    function Check_application_Status($link, $tenant_id) {
      $sql_check_application = "SELECT applicationstatus FROM residence_applications WHERE tenant_id = ?";
      $stmt_check_application = $link->prepare($sql_check_application);
      
      if ($stmt_check_application === false) {
          die('Error preparing statement: ' . $link->error);
      }
      
      $stmt_check_application->bind_param("s", $tenant_id);
      $stmt_check_application->execute();
      $result_check_application = $stmt_check_application->get_result();
      
      if ($result_check_application === false) {
          die('Error executing statement: ' . $stmt_check_application->error);
      }
      
      $user_result = $result_check_application->fetch_assoc();
      
      if ($user_result !== null) {
          $_SESSION['show'] = true;
          
          switch ($user_result['applicationstatus']) {
              case 'accepted':
                  $_SESSION['Approved'] = 1;
                  break;
              case 'review':
                  $_SESSION['Approved'] = 0;
                  break;
              case 'rejected':
                  $_SESSION['Approved'] = -1;
                  break;
              default:
                  $_SESSION['Approved'] = null; // or handle other statuses
                  break;
          }
      } else {
          $_SESSION['show'] = false;
          $_SESSION['Approved'] = null;
      }
      
      $stmt_check_application->close();
  }
  
    Check_application_Status($link ,$tenant_id);
    // Close the statement
    $stmt->close();

    // // Prepare SQL statement to check if the tenant has an apartment
    // $sql = "SELECT * FROM apartment WHERE TenantID = ?";
    // $stmt = $link->prepare($sql);
    // $stmt->bind_param("i", $_SESSION['tenant_id']);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // // Check if the result has at least one row and set the session variable
    // if ($row = $result->fetch_assoc()) {
    //     $_SESSION['show'] = true;
    // }

    // Close the statement
    // $stmt->close();
} catch (Exception $e) {
    // Handle any errors
    error_log("Error: " . $e->getMessage());
    // You can also set a user-friendly message to display
    $_SESSION['error_message'] = "An error occurred while processing your request.";
}

  
  if(isset($_SESSION['Approved'])){
  if($_SESSION['Approved'] === 1){
    $_SESSION['application_update']= "Approved";
    $application_update = $_SESSION['application_update'];
  }else if($_SESSION['Approved'] === 0){
    $_SESSION['application_update']= "Application Pending";
    $application_update = $_SESSION['application_update'];
  }else if($_SESSION['Approved'] === -1){
    $_SESSION['application_update']= "Unsuccessful Application";
    $application_update = $_SESSION['application_update'];
  }
  
}else{
  $_SESSION['application_update'] = "No application";
  $application_update = $_SESSION['application_update'];
  }

  if($application_update == "Approved"){
    $_SESSION['show']=true;
  }
  $show = isset($_SESSION['show']) ?  $_SESSION['show'] : false;
   $_SESSION["view_maintance"]=$show && $application_update=="Approved";
// Close the database connection
$link->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tenant Dashboard</title>
  <link rel="stylesheet" href="Tenant_Dashboard_Tabs/style.css">
        
  <style>
         
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2a2a3e;
            color: #333;
            width: 100%;
        }
        .content-wrap {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .content-head {
            background-color: #1b253d;
            color: white;
            padding: 30px 40px;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .content-head h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: 1px;
        }
        .content {
            background-color: #1b253d;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .dashboard-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .dashboard-section h3 {
            color: #2a2a3e;
            border-bottom: 2px solid #2a2a3e;
            padding-bottom: 15px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .dashboard-section p {
            margin: 15px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .welcome-message {
            font-size: 22px;
            color: #2a2a3e;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .status {
            font-weight: bold;
            color: #28a745;
            background-color: #e6f4ea;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>
<?php
  $username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : 'Guest';
?>
  
  <div class="dashboard">
           <aside class="search-wrap">
       
        <div class="user-actions">
          <a href="../Controller/logout.php"><button>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
              <path
                d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z"
              />
              <path d="M11 2h2v10h-2z" />
            </svg>
          </button></a>
        </div>
      </aside>

      <header class="menu-wrap">
        <figure class="user">
            <div class="user-avatar">
              <img
                src="WhatsApp Image 2024-06-25 at 08.13.41.jpeg"
                alt=""
              />
            </div>
            <figcaption><?php echo $username; ?></figcaption>
          </figure>

       <nav>
          <section class="dicover">

            <ul>
              <li>
                <a href="tenant_dashboard.php">
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


              <!-- <li>
                <a href="View/pay_rent.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M12.707 2.293A.996.996 0 0 0 12 2H3a1 1 0 0 0-1 1v9c0 .266.105.52.293.707l9 9a.997.997 0 0 0 1.414 0l9-9a.999.999 0 0 0 0-1.414l-9-9zM12 19.586l-8-8V4h7.586l8 8L12 19.586z"
                    />
                    <circle cx="7.507" cy="7.505" r="1.505" />
                  </svg>
                  Pay Rent
                </a>
              </li> -->

              <?php if($show && $application_update=="Approved"):
              ?>
              <li>
              <a href="Tenant_Dashboard_Tabs/requestMaintenance.php">
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
              <?php endif; ?>
              <?php if(!$show):?>
              <li>
              <a href="Tenant_Dashboard_Tabs/residenceApplication.php">
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
                 Residence Application 
                </a>
              </li>
              <?php endif; ?>
              <li>
                <a href="Tenant_Dashboard_Tabs/update_details.php">
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
        <header class="content-head">
            <h1><b>Tenant Dashboard</b></h1>
        </header>
        
        <div class="content">
            <div class="dashboard-section">
                <p class="welcome-message">Welcome, <?php echo htmlspecialchars($username); ?>!</p>
                <p>Here's what's happening with your tenancy:</p>
            </div>
            <div class="dashboard-section">
                <h3>Your Details</h3>
                <p><strong>Username:</strong> <?php echo $username; ?></p>
              
                    <p><strong>Application Status:</strong> <span class="status"><?php echo $application_update; ?></span></p>
              
                <?php if($show): ?>
                    <p><strong>Lease Expiry:</strong> <?php echo $application_update; ?></p>
                <?php endif; ?>
            </div>
         
        </div>
    </main>

  
</body>
</html>
