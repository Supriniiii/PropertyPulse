<?php
require '../../Database/db_config.php';
  session_start();
  $username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : "Guest";
?>

<!DOCTYPE html>
<html lang="en">Ten
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tenant Dashboard</title>
  <style>
    * {
  box-sizing: border-box;
}
html,
body {
  color: #6cb6ff;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background: #2a2a3e;
  font-size: 16px;
  line-height: 120%;
  font-family: Open Sans, Helvetica, sans-serif;
}
.dashboard {
  display: grid;
  width: 100%;
  height: 100%;
  grid-gap: 0;
  grid-template-columns: 300px auto;
  grid-template-rows: 80px auto;
  grid-template-areas: "menu search" "menu content";
}
.search-wrap {
  grid-area: search;
  background: #2a2a3e;
  border-bottom: 1px solid #ede8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 3em;
}
.search-wrap .search {
  height: 40px;
}
.search-wrap .search label {
  display: flex;
  align-items: center;
  height: 100%;
}
.search-wrap .search label svg {
  display: block;
}
.search-wrap .search label svg path,
.search-wrap .search label svg circle {
  fill: #b6bbc6;
  transition: fill 0.15s ease;
}
.search-wrap .search label input {
  display: block;
  padding-left: 1em;
  height: 100%;
  margin: 0;
  border: 0;
}
.search-wrap .search label input:focus {
  background: #f5f5fa;
}
.search-wrap .search label:hover svg path,
.search-wrap .search label:hover svg circle {
  fill: #28a745;
}
.search-wrap .user-actions button {
  border: 0;
  background: none;
  width: 32px;
  height: 32px;
  margin: 0;
  padding: 0;
  margin-left: 0.5em;
}
.search-wrap .user-actions button svg {
  position: relative;
  top: 2px;
}
.search-wrap .user-actions button svg path,
.search-wrap .user-actions button svg circle {
  fill: #b6bbc6;
  transition: fill 0.15s ease;
}
.search-wrap .user-actions button:hover svg path,
.search-wrap .user-actions button:hover svg circle {
  fill: #28a745;
}
.menu-wrap {
  grid-area: menu;
  padding-bottom: 3em;
  overflow: auto;
  background: #2a2a3e;
  border-right: 1px solid #ede8f0;
}
.menu-wrap .user {
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin: 0;
  padding: 0 3em;
}
.menu-wrap .user .user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
}
.menu-wrap .user .user-avatar img {
  display: block;
  width: 100%;
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover;
}
.menu-wrap .user figcaption {
  margin: 0;
  padding: 0 0 0 1em;
  color: #6cb6ff;
  font-weight: 700;
  font-size: 0.875em;
  line-height: 100%;
}
.menu-wrap nav {
  display: block;
  padding: 0 3em;
}
.menu-wrap nav section {
  display: block;
  padding: 3em 0 0;
}
.menu-wrap nav h3 {
  margin: 0;
  font-size: 0.875em;
  text-transform: uppercase;
  color: #6cb6ff;
  font-weight: 600;
}
.menu-wrap nav ul {
  display: block;
  padding: 0;
  margin: 0;
}
.menu-wrap nav li {
  display: block;
  padding: 0;
  margin: 1em 0 0;
}
.menu-wrap nav li a {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.875em;
  transition: color 0.15s ease;
}
.menu-wrap nav li a svg {
  display: block;
  margin-right: 1em;
}
.menu-wrap nav li a svg path,
.menu-wrap nav li a svg circle {
  fill: #b6bbc6;
  transition: fill 0.15s ease;
}
.menu-wrap nav li a:hover {
  color: #28a745;
}
.menu-wrap nav li a:hover svg path,
.menu-wrap nav li a:hover svg circle {
  fill: #28a745;
}
.menu-wrap nav li a.active {
  color: #6cb6ff;
}
.menu-wrap nav li a.active svg path,
.menu-wrap nav li a.active svg circle {
  fill: #6cb6ff;
}
.content-wrap {
  grid-area: content;
  padding: 3em;
  overflow: auto;
}
.content-wrap .content-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.content-wrap .content-head h1 {
  font-size: 2.5em;
  line-height: 100%;
  color: #fff;
  font-weight: 1000;
  margin: 0;
  padding: 0;
}
.content-wrap .content-head .action button {
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
}
.content-wrap .content-head .action button:hover {
  background-color: #28a745;
}
.content-wrap .content-head .action button:hover:active {
  background-color: #28a745;
  transition: none;
}
.content-wrap .info-boxes {
  padding: 3em 0 2em;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  grid-gap: 2em;
}
.content-wrap .info-boxes .info-box {
  background: #fff;
  height: 160px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 0 3em;
  border: 1px solid #ede8f0;
  border-radius: 5px;
}
.content-wrap .info-boxes .info-box .box-icon svg {
  display: block;
  width: 48px;
  height: 48px;
}
.content-wrap .info-boxes .info-box .box-icon svg path,
.content-wrap .info-boxes .info-box .box-icon svg circle {
  fill: #99a0b0;
}
.content-wrap .info-boxes .info-box .box-content {
  padding-left: 1.25em;
  white-space: nowrap;
}
.content-wrap .info-boxes .info-box .box-content .big {
  display: block;
  font-size: 2em;
  line-height: 150%;
  color: #1b253d;
}
.content-wrap .info-boxes .info-box.active svg circle,
.content-wrap .info-boxes .info-box.active svg path {
  fill: #6cb6ff;
}
.content-wrap .person-boxes {
  padding: 0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  grid-gap: 2em;
}
.content-wrap .person-boxes .person-box {
  background: #fff;
  height: 400px;
  text-align: center;
  padding: 3em;
  border: 1px solid #ede8f0;
  border-radius: 5px;
  margin-top: 50px;
}
.content-wrap .person-boxes .person-box:nth-child(2n) .box-avatar .no-name {
  background: #6cb6ff;
}
.content-wrap .person-boxes .person-box:nth-child(5n) .box-avatar .no-name {
  background: #ffbb09;
}
.content-wrap .person-boxes .person-box .box-avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  margin: 0px auto;
  overflow: hidden;
}
.content-wrap .person-boxes .person-box .box-avatar img {
  display: block;
  width: 100%;
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover;
}
.content-wrap .person-boxes .person-box .box-avatar .no-name {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: #fff;
  font-size: 1.5em;
  font-weight: 600;
  text-transform: uppercase;
  width: 100%;
  height: 100%;
  background: #fa5b67;
}
.content-wrap .person-boxes .person-box .box-bio {
  white-space: no-wrap;
}
.content-wrap .person-boxes .person-box .box-bio .bio-name {
  margin: 2em 0 0.75em;
  color: #1b253d;
  font-size: 1em;
  font-weight: 700;
  line-height: 100%;
}
.content-wrap .person-boxes .person-box .box-bio .bio-position {
  margin: 0;
  font-size: 0.875em;
  line-height: 100%;
}
.content-wrap .person-boxes .person-box .box-actions {
  margin-top: 1.25em;
  padding-top: 1.25em;
  width: 100%;
  border-top: 1px solid #ede8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.content-wrap .person-boxes .person-box .box-actions button {
  border: 0;
  background: none;
  width: 32px;
  height: 32px;
  margin: 0;
  padding: 0;
}
.content-wrap .person-boxes .person-box .box-actions button svg {
  position: relative;
  top: 2px;
}
.content-wrap .person-boxes .person-box .box-actions button svg path,
.content-wrap .person-boxes .person-box .box-actions button svg circle {
  fill: #b6bbc6;
  transition: fill 0.15s ease;
}
.content-wrap .person-boxes .person-box .box-actions button:hover svg path,
.content-wrap .person-boxes .person-box .box-actions button:hover svg circle {
  fill: #28a745;
}

 .form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* CSS styles for the maintenance history section */
        .maintenance-history {
            margin-top: 20px;
        }

        .maintenance-history table {
            width: 100%;
            border-collapse: collapse;
        }

        .maintenance-history th,
        .maintenance-history td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* CSS styles for the status updates section */
        .status-updates {
            margin-top: 20px;
        }

        .status-updates .update {
            margin-bottom: 10px;
        }

        /* CSS styles for the feedback and ratings section */
        .feedback-ratings {
            margin-top: 20px;
        }

        .feedback-ratings textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        /* CSS styles for the help and support section */
        .help-support {
            margin-top: 20px;
        }

        

label {
  cursor: pointer;
}


/* hide radio buttons */

input[name="star"] {
  display: inline-block;
  width: 0;
  opacity: 0;
  margin-left: -2px;
}

/* hide source svg */

.star-source {
  width: 0;
  height: 0;
  visibility: hidden;
}


/* set initial color to transparent so fill is empty*/

.star {
  color: transparent;
  transition: color 0.2s ease-in-out;
   width: 3rem;
  height: 3rem;
  padding: 0.15rem;
}


/* set direction to row-reverse so 5th star is at the end and ~ can be used to fill all sibling stars that precede last starred element*/

.star-container {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
}

label:hover ~ label .star,
svg.star:hover,
input[name="star"]:focus ~ label .star,
input[name="star"]:checked ~ label .star {
  color: #4CAF50;
}

input[name="star"]:checked + label .star {
  animation: starred 0.5s;
}

input[name="star"]:checked + label {
  animation: scaleup 1s;
}

@keyframes scaleup {
  from {
    transform: scale(1.2);
  }
  to {
    transform: scale(1);
  }
}

@keyframes starred {
  from {
    color: #00791e;
  }
  to {
    color: #4CAF50;
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
          <a href="../../Controller/logout.php"><button>
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
            
          </div>
          <figcaption><?echo $username; ?></figcaption>
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
        <header class="content-head">
          <h1><b>Maintenance Request Form</b></h1>
        </header>
		
		<div class="content">
             <div class="form-container">
             <form id="maintenance-request-form" action="../../Controller/task_status.php" method="POST" enctype="multipart/form-data">
    <br />
    <label for="issue-description">Issue Description:</label>
    <br />
    <select id="issue-description" name="serviceworker-description" required>
      <option value="Electrician">Electricity problems</option>
      <option value="Plumber">Water problems </option>
      <option value="Glazier">Glass problems</option>
      <option value="Security">Security problems</option>
      <option value="Cleaner">Tile problems</option>
      <option value="Carpenter">Carpentry problems</option>
    </select>
    <br />

<label for="full-description">Full Description:</label>
<br />
<textarea type="text-area" id="full-description" name="description" rows="4"></textarea>

    <br />

    <!--<label for="photo-upload">Photo Upload:</label>
    <br />
    <input type="file" id="photo-upload" name="photo">-->

    <br />

    <label for="urgency-level">Urgency Level:</label>
    <select id="urgency-level" name="urgency_level">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
        <option value="emergency">Emergency</option>
    </select>

    <br />

    <label for="contact-method">Contact Method:</label>
    <select id="contact-method" name="contact_method">
        <option value="email">Email</option>
    </select>

    <br />

    <button type="submit" name="submit">Submit Request</button>
</form>
    </div>

    <div class="maintenance-history">
        <h2>Maintenance History</h2>
        <h3>1- Bad, 2- Not Good, 3- Moderate, 4- Good, 5- Excellent </h3>
        <table>
            <thead>
                <tr>
                    <th>Date Submitted</th>
                    <th>Issue Description</th>
                    <th>Status</th>
                    <th>Rate Service</th>
                </tr>
                    
            </thead>
            <tbody>
                    <?php 
                    $tenantID = $_SESSION['tenant_id'];
                    
$tenantID = $link->real_escape_string($tenantID); // Sanitize input
$sql = "SELECT * FROM tmaintenancerequest b JOIN tworkorder a ON b.RequestID = a.RequestID WHERE b.TenantID = ? AND a.Rating IS NULL";

$stmt = $link->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $link->error);
}

$stmt->bind_param("s", $tenantID);

if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
        
        echo '<form action="rating.php" method="POST">';
        echo '<input type=hidden value="'.$row['WorkOrderID'].'" name="workorder_id">';
        echo '<tr>';
        echo '<td>'.$row['DateSubmitted'].'</td>';
        echo '<td>'.$row['Description'].'</td>';
        echo '<td>'.$row['Status'].'</td>';
        echo '<td><input type="number" min=1 max=5 name="rating"></td>';
        echo '<td><input type = "submit" value="Submit" </td>';
        echo '</tr>';
        echo '</form>';
}

                
                    
                    
// Close statement
$stmt->close();
                    ?>
                    
            </tbody>
        </table>
    </div>

   <!-- <div class="status-updates">
        <h2>Status Updates</h2>
        <div id="status-updates-container">
            <!-- Real-time updates will be dynamically displayed here using JavaScript 
        </div>
    </div>

    <div class="feedback-ratings">
        <h2>Feedback</h2>
        <textarea id="feedback" rows="4"></textarea>
        <button id="submit-feedback">Submit Feedback</button>

       <h2>Ratings</h2> 
<div class="star-source">
  <svg>
         <linearGradient x1="50%" y1="5.41294643%" x2="87.5527344%" y2="65.4921875%" id="grad">
            <stop stop-color="#4CAF50" offset="0%"></stop>
            <stop stop-color="#4CAF50" offset="60%"></stop>
            <stop stop-color="#4CAF50" offset="100%"></stop>
        </linearGradient>
    <symbol id="star" viewBox="153 89 106 108">   
      <polygon id="star-shape" stroke="url(#grad)" stroke-width="5" fill="currentColor" points="206 162.5 176.610737 185.45085 189.356511 150.407797 158.447174 129.54915 195.713758 130.842203 206 95 216.286242 130.842203 253.552826 129.54915 222.643489 150.407797 235.389263 185.45085"></polygon>
    </symbol>
</svg>

</div>
<div class="star-container">
  <input type="radio" name="star" id="five">
  <label for="five">
    <svg class="star">
      <use xlink:href="#star"/>
    </svg>
  </label>
  <input type="radio" name="star" id="four">
  <label for="four">
    <svg class="star">
      <use xlink:href="#star"/>
    </svg>
  </label>
  <input type="radio" name="star" id="three">
  <label for="three">
    <svg  id="stars" class="star">
      <use xlink:href="#star"/>
    </svg>
  </label>
  <input type="radio" name="star" id="two">
  <label for="two">
    <svg class="star">
      <use xlink:href="#star" />
    </svg>
  </label>
  <input type="radio" name="star" id="one">
  <label for="one">
   <svg class="star">
    <use xlink:href="#star" />
   </svg>
  </label>

</div>
    </div>

    <div class="help-support">
        <h2>Help and Support</h2>
        <p>FAQs and Troubleshooting Tips:</p>
        <ul>
            <li>Question 1: Answer to question 1</li>
            <li>Question 2: Answer to question 2</li>
            <!-- Add more FAQs and answers here 
        </ul>
        <p>Contact Information: <a href="tel:1234567890">123-456-7890</a> | <a href="mailto:admin@example.com">admin@example.com</a></p>
    </div>

    <!-- <script>
        // JavaScript code for submitting the maintenance request form
        const maintenanceRequestForm = document.getElementById('maintenance-request-form');
        maintenanceRequestForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Get form values
            const issueDescription = document.getElementById('issue-description').value;
            const urgencyLevel = document.getElementById('urgency-level').value;
            const contactMethod = document.getElementById('contact-method').value;
            
            // Perform necessary actions (e.g., send request to server, display success message)
            // ...
            
            // Clear form fields
            maintenanceRequestForm.reset();
        });

        // JavaScript code for retrieving and displaying previous requests, real-time updates, and submitting feedback
        // ...
    </script> -->
                <button onclick="window.location.href='../Tenant_Dashboard_Tabs/summary_report.php'">Request History</button>
		</div>
  
</body>
</html>
