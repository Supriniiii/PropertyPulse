<?php
  session_start();
  require "../../Database/db_config.php";
  $username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : "Guest";
  $application_update = $_SESSION['application_update'];
  $tenant_id=(isset($_SESSION['tenant_id'])) ? $_SESSION['tenant_id'] : "";
  $apartmentName ="";
 
  $show = isset($_SESSION['show']) ?  $_SESSION['show'] : false;
  // Fetch cities from the property table
  $sql = "SELECT PropertyID, city, name, address FROM property ORDER BY city";
  $stmt = $link->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result(); // Get the result set from the statement
  
  $cities = [];
  while ($row = $result->fetch_assoc()) {
      $cities[] = $row['PropertyID']."-".$row['city']."-".$row['name']."-".$row['address'];
  }
  
  $selected_city = 0;
  $properties = [];

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['city'])) {
    
      $selected_city = $_POST['city'];
      $sql = "SELECT * FROM property WHERE PropertyID = ?";
      $stmt = $link->prepare($sql);
      $stmt->bind_param("i", $selected_city);
      $stmt->execute();
      $result = $stmt->get_result(); // Get the result set from the statement
    
      
  // $properties = [];
  $status = 1;
  if ($row = $result->fetch_assoc()) {
    $sql1 = "SELECT * FROM apartment WHERE PropertyID = ? AND Status = ?";
    $stmt1 = $link->prepare($sql1);
    $stmt1->bind_param("is", $row['PropertyID'], $status);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $apartmentName=$row['Name'];
          //echo sizeof($properties) . $application_update."=".$selected_city."dd";
    while ($row1 = $result1->fetch_assoc()){
      
      $properties[] = $row1['ApartmentID']."-".$row1['ApartmentNumber']."-".$row1['Floor'] . "-" . $row1['Bedrooms']. "-".$row1['Bathrooms'];
  		//echo sizeof($properties) . $application_update."=".$selected_city."dcd";
    }
      }
  }

 
  ?>

<!DOCTYPE html>
<html lang="en">
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
form {
            background-color: #1b253d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        legend {
            font-weight: bold;
            padding: 0 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .agreement {
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
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

/* Hide all sections by default */
.content > div {
    display: none;
}

/* Show only the form-container and maintenance-history sections */
.content > .form-container,
.content > .maintenance-history {
    display: block;
}

/* Specifically, display the table within the maintenance-history */
.content > .maintenance-history > table {
    display: table;
}

  </style>
</head>
<body>


  
  <div class="dashboard">
  <aside class="search-wrap">
        <div class="search">
          <label for="search">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
            </svg>
                  </label>
        </div>

       <div class="user-actions">
          <button>
            <a href="../../Controller/logout.php">
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
           </a>
          </button>
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

              <?php if($show):
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
          <h1><b>Tenant Application Form</b></h1>
        </header>
		
        <?php
          if($application_update == "No application"):
        ?>
		<div class="content">
<?php if($apartmentName==""){ ?>
    <form method="post">
      <p>ID - LOCATION- NAME OF PROPERTY- ADDRESS OF PROPERTY</p>
        <label for="city">Choose a property to apply to:</label>
        <select name="city" id="city" onchange="this.form.submit()">
            <option value="">Select property</option>
            <?php foreach ($cities as $city): ?>
              <?php
                $pId = explode("-",$city);
                ?>
    <option value="<?= htmlspecialchars($pId[0]); ?>">
        <?= htmlspecialchars($city); ?>
    </option>
<?php endforeach; ?>

        </select>
    </form>
                <?php }?>      <br>
              <br>


    <?php if(!empty($properties)): ?>
      <form method="post" action="../../Controller/residenceApplication.php" onsubmit="return validateForm(event)">
               <h1><?php echo "$apartmentName" ?></h1>
        <fieldset>
            <legend>Personal Information</legend>
            <label for="idNumber">South African ID Number:</label>
            <input type="text" id="idNumber" name="idNumber" maxlength="13" pattern="\d{13}" title="Please enter exactly 13 numeric characters" required oninput="populateFields()">
            
            <label for="dob">Date of Birth:</label>
            <input type="text" id="dob" name="dob" readonly>
            
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" readonly>
            
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" readonly>
        </fieldset>

        <fieldset>
            <legend>Financial Information</legend>
            <label for="bankName">Bank Name:</label>
         
            <select id="bankName" name="bankName" required>
                <option value="fnb">First National Bank (FNB)</option>
                <option value="absa">Absa Bank</option>
                <option value="standard">Standard Bank</option>
                <option value="nedbank">Nedbank</option>
                <option value="capitec">Capitec Bank</option>
                <option value="investec">Investec</option>

          </select>
            <label for="accountType">Account Type:</label>
            <input type="text" id="accountType" name="accountType" required>
            
            <label for="accountNumber">Account Number:</label>
            <input type="text" id="accountNumber" name="accountNumber" required>
            
            <label for="monthlyIncome">Monthly Income:</label>
            <input type="text" id="monthlyIncome" name="monthlyIncome" required>
        </fieldset>

        <fieldset>
            <legend>Credit History</legend>
            <label for="creditHistory">Have you had any past credit problems? (If applicable, explain below)</label>
            <input type="text" id="creditHistory" name="creditHistory">

            <h3>Rental or Criminal History</h3>
            <label><input type="checkbox" name="evicted"> Been evicted or asked to move out?</label>
            <label><input type="checkbox" name="movedOut"> Moved out of a dwelling before the end of the lease term without the owner's consent?</label>
            <label><input type="checkbox" name="bankruptcy"> Declared bankruptcy?</label>
            <label><input type="checkbox" name="suedForRent"> Been sued for rent?</label>
            <label><input type="checkbox" name="suedForDamage"> Been sued for property damage?</label>
            <label><input type="checkbox" name="convicted"> Been convicted of a felony, misdemeanor involving a controlled substance, violence to another person or destruction of property, or a sex crime?</label>

            <div class="agreement">
                <h3>Application Agreement</h3>
                <p>The following Application Agreement will be signed by you and all co-applicants prior to signing a Lease Contract...</p>
                <p>[The full Application Agreement text goes here]</p>
            </div>
        </fieldset>

        <fieldset>
            <legend>Choose Apartment</legend>
            <p>ID-ID-APARTMENT NUMBER- FLOOR- NUM OF BEDROOMS- NUM OF BATHROOMS</p>
            <label for="property">Choose an apartment:</label>
            <select name="property" id="property">
                <?php foreach ($properties as $property): ?>
                    <option value="<?= htmlspecialchars($property); ?>">
                        <?= htmlspecialchars($property) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>
    
        <button type="submit">Submit Residence Application</button>
    </form>
        </br>
        <?php endif;?>


    <?php else: ?>
      <p><?=$application_update ?></p>
      <?php endif;?>
		</div>
    <script>
        function populateFields() {
            const idNumber = document.getElementById("idNumber").value;
            if (idNumber.length !== 13 || isNaN(idNumber)) {
                document.getElementById("dob").value = "";
                document.getElementById("age").value = "";
                document.getElementById("gender").value = "";
                return;
            }
            
            const dob = idNumber.substring(0, 6);
            const genderCode = parseInt(idNumber.substring(6, 10));
            
            const currentYear = new Date().getFullYear();
            let year = parseInt(dob.substring(0, 2), 10);
            year += (year < 50 ? 2000 : 1900);
            
            const month = dob.substring(2, 4);
            const day = dob.substring(4, 6);
            
            const birthDate = new Date(year, month - 1, day);
            const age = currentYear - year - (new Date().getMonth() < month || (new Date().getMonth() === month && new Date().getDate() < day) ? 1 : 0);
            
            const gender = genderCode >= 5000 ? "Male" : "Female";
            
            document.getElementById("dob").value = `${day}/${month}/${year}`;
            document.getElementById("age").value = age;
            document.getElementById("gender").value = gender;
        }
            function validateForm(event) {
            var age = document.getElementById('age').value;
            if (age < 18) {
                event.preventDefault(); // Prevent the form from being submitted
                alert('You must be at least 18 years old to apply.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
