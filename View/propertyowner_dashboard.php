<?php
  require "../Database/db_config.php";
  require_once "../Model/verify_user.php";

  $_SESSION["owner_id"]="";

  $sql = "SELECT * FROM propertyowner WHERE userID =?";
  $stmt = $link->prepare($sql);
  $stmt->bind_param("i",$_SESSION['user_id']);
  $stmt->execute();
  $result = $stmt->get_result();

  if($row = $result->fetch_assoc())
  {
    $_SESSION["owner_id"]=$row["OwnerID"];
  }

$username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : 'Guest';

$serviceId = $_SESSION["user_id"];

$getproperyCount = mysqli_query($link,"SELECT * FROM property WHERE OwnerID = $serviceId");
$row = mysqli_num_rows($getproperyCount);

$userName = $_SESSION["user_username"];

$getGroupCount = mysqli_query($link,"SELECT * FROM chatroom WHERE creator = '{$userName}' OR Member = '{$userName}'");
$rowGroup = mysqli_num_rows($getGroupCount);

  
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Property Owner Dashboard</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Property_Owner_Dashboard_Tabs/style.css" />
    
        <style>
  .tab {
    overflow: hidden;
    background-color: #2a2a3e;
    cursor: pointer;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    font-size: 14px;
  }

  .tab-content {
    display: none;
    padding: 15px;
    border: 1px solid #ccc;
    border-top: none;
  }

  .tab-content.active {
    display: block;
  }

  .tab-content a {
    display: block;
    margin-bottom: 10px;
  }

  .tab-content img {
    vertical-align: middle;
    margin-right: 5px;
  } 
  .icon-space {
    margin-right: 10px;
    
  }
#addFormButton {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: none;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
}

#addFormButton i {
    font-size: 20px;
}

#addFormButton .fa-plus {
    color: #4CAF50;  /* Green color for the plus icon */
}

#addFormButton .fa-building {
    color: #2196F3;  /* Blue color for the building icon */
}
                
                
    </style>
  </head>
  <body>
    <!-- partial:index.partial.html -->
    <div class="dashboard">
    <aside class="search-wrap">
        <div class="search">
         <!-- <label for="search">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
            </svg>-->
        </div>

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
            <h3>Discover</h3>

            <ul>
              <li>
                <!-- Mixed up names on purpose for the sake of time -->
                <a href="Property_Owner_Dashboard_Tabs/propertyowner_dashboard.php">
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
                  Property Overview
                </a>
              </li>

              <li>
                <a href="Property_Owner_Dashboard_Tabs/owner_calender.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.353 2.355-6.049-.002-8.416zm-1.412 7.002L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002 1.563 1.571 1.564 4.025.002 5.588z"
                    />
                  </svg>
                  Calendar
                </a>
              </li>

          

              
              

              <li>
                <a href="Property_Owner_Dashboard_Tabs/communications.php">
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
                  Communications
                </a>
              </li>

              <li>
                <a href="Property_Owner_Dashboard_Tabs/documentationAccess.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M20 10H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V11a1 1 0 0 0-1-1zm-1 10H5v-8h14v8zM5 6h14v2H5zM7 2h10v2H7z"
                    />
                  </svg>
                  Documentation Access
                </a>
              </li>
                    
            <li>
                <a href="Property_Owner_Dashboard_Tabs/update_details.php">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M3,21c0,0.553,0.448,1,1,1h16c0.553,0,1-0.447,1-1v-1c0-3.714-2.261-6.907-5.478-8.281C16.729,10.709,17.5,9.193,17.5,7.5 C17.5,4.468,15.032,2,12,2C8.967,2,6.5,4.468,6.5,7.5c0,1.693,0.771,3.209,1.978,4.219C5.261,13.093,3,16.287,3,20V21z M8.5,7.5 C8.5,5.57,10.07,4,12,4s3.5,1.57,3.5,3.5S13.93,11,12,11S8.5,9.43,8.5,7.5z M12,13c3.859,0,7,3.141,7,7H5C5,16.141,8.14,13,12,13z"
                    />
                  </svg>
                  Account Management
                </a>
              </li>
                          <li>
                <a href="https://www.property24.com/">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M3,21c0,0.553,0.448,1,1,1h16c0.553,0,1-0.447,1-1v-1c0-3.714-2.261-6.907-5.478-8.281C16.729,10.709,17.5,9.193,17.5,7.5 C17.5,4.468,15.032,2,12,2C8.967,2,6.5,4.468,6.5,7.5c0,1.693,0.771,3.209,1.978,4.219C5.261,13.093,3,16.287,3,20V21z M8.5,7.5 C8.5,5.57,10.07,4,12,4s3.5,1.57,3.5,3.5S13.93,11,12,11S8.5,9.43,8.5,7.5z M12,13c3.859,0,7,3.141,7,7H5C5,16.141,8.14,13,12,13z"
                    />
                  </svg>
                  View Properties to View
                </a>
              </li>
<li>                   
<div class="tab" onclick="toggleTab()">
    <img src="media icon.png" width="30" height="20" alt="media" class="icon-space">Media Links</div>

<div id="mediaLinks" class="tab-content">
  <a href="https://www.instagram.com/pro.pertypulse?utm_source=qr&igsh=MTRlN3VibmdlZnZt" target="_blank" title="Find Property Pulse on Instagram">
    <img src="https://img.icons8.com/?size=20&id=32323&format=png" alt="Instagram icon">Instagram
  </a>
  <a href="https://www.facebook.com/profile.php?id=61561137584881&sfnsn=scwspwa&mibextid=RUbZ1f" target="_blank" title="Find Property Pulse on Facebook">
    <img src="https://img.icons8.com/?size=20&id=118497&format=png" alt="Facebook icon">Facebook
  </a>
  <a href="https://x.com/Properpulse?t=UOZO_nz9dvPaQEtUjkQOEg&s=09g" target="_blank" title="Find Property Pulse on Twitter">
    <img src="https://img.icons8.com/?size=20&id=ClbD5JTFM7FA&format=png" alt="Twitter icon">Twitter
  </a>
  <a href="https://www.youtube.com/watch?v=uYed9wqZSF8" target="_blank" title="Find Property Pulse on Youtube">
    <img src="https://img.icons8.com/?size=20&id=19318&format=png" alt="Youtube icon">Youtube
  </a>
  <a href="https://pin.it/7GOf7hUYf" target="_blank" title="Find Property Pulse on Pinterest">
    <img src="https://img.icons8.com/?size=15&id=1481&format=png" alt="Pinterest icon">Pinterest
  </a>
</div>
<li>
                    
            </ul>
          </section>

        </nav>
      </header>

      <main class="content-wrap">
        <header class="content-head">
          <h1><b>Property Owner</b></h1>
        </header>

        <div class="content">
          <section class="info-boxes">
            <div class="info-box">
              <div class="box-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M21 20V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1zm-2-1H5V5h14v14z"
                  />
                  <path
                    d="M10.381 12.309l3.172 1.586a1 1 0 0 0 1.305-.38l3-5-1.715-1.029-2.523 4.206-3.172-1.586a1.002 1.002 0 0 0-1.305.38l-3 5 1.715 1.029 2.523-4.206z"
                  />
                </svg>
              </div>

     

                  <div class="box-content">
                <span class="big"><a href="Property_Owner_Dashboard_Tabs/documentationAccess.php">Documents</a></span>
                Documentation Access 
              </div>
            </div>


            <div class="info-box active">
              <div class="box-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M3,21c0,0.553,0.448,1,1,1h16c0.553,0,1-0.447,1-1v-1c0-3.714-2.261-6.907-5.478-8.281C16.729,10.709,17.5,9.193,17.5,7.5 C17.5,4.468,15.032,2,12,2C8.967,2,6.5,4.468,6.5,7.5c0,1.693,0.771,3.209,1.978,4.219C5.261,13.093,3,16.287,3,20V21z M8.5,7.5 C8.5,5.57,10.07,4,12,4s3.5,1.57,3.5,3.5S13.93,11,12,11S8.5,9.43,8.5,7.5z M12,13c3.859,0,7,3.141,7,7H5C5,16.141,8.14,13,12,13z"
                  />
                </svg>
              </div>

             

            
              <div class="box-content">
                <span class="big"><a href="Property_Owner_Dashboard_Tabs/communications.php">Conversations</a></span>
                Conversations
              </div>
            </div>
          </section>

          <section class="person-boxes">
            <div class="person-box">
              <div class="user-avatar mb-3">
               <i class="fas fa-user-circle fa-4x"></i>
              </div>
              <div class="box-bio">
                <h2 class="bio-name"><?php echo $username;?></h2>
                <p class="bio-position">Property owner</p>
              </div>

              <div class="box-actions">
             

                <button>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                             <a href="Property_Owner_Dashboard_Tabs/documentationAccess.php">
                    <path
                      d="M18 18H6V6h7V4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-8h-2v7z"
                    />
                                   </a>
                    <path
                      d="M17.465 5.121l-6.172 6.172 1.414 1.414 6.172-6.172 2.12 2.121L21 3h-5.657z"
                    />
                  </svg>
                </button>

                <button>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                           <a href="Property_Owner_Dashboard_Tabs/communications.php">
                    <path
                      d="M12 3C6.486 3 2 6.364 2 10.5c0 2.742 1.982 5.354 5 6.678V21a.999.999 0 0 0 1.707.707l3.714-3.714C17.74 17.827 22 14.529 22 10.5 22 6.364 17.514 3 12 3zm0 13a.996.996 0 0 0-.707.293L9 18.586V16.5a1 1 0 0 0-.663-.941C5.743 14.629 4 12.596 4 10.5 4 7.468 7.589 5 12 5s8 2.468 8 5.5-3.589 5.5-8 5.5z"
                    />
                                   </a>
                  </svg>
                </button>
                      

                     

         
              
          </section>

<script>
         
function toggleTab() {
  var content = document.getElementById("mediaLinks");
  content.classList.toggle("active");
        
}
</script>
