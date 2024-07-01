<?php
  session_start();
  $username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : "Guest";
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
    <link rel="stylesheet" href="./style.css" />

    <style>
      a {
        color: #fff;
      }

      .alert > .start-icon {
        margin-right: 0;
        min-width: 20px;
        text-align: center;
      }

      .alert > .start-icon {
        margin-right: 5px;
      }

      .greencross {
        font-size: 18px;
        color: #25ff0b;
        text-shadow: none;
      }

      .alert-simple.alert-success {
        border: 1px solid rgba(36, 241, 6, 0.46);
        background-color: rgba(7, 149, 66, 0.12156862745098039);
        box-shadow: 0px 0px 2px #259c08;
        color: #0ad406;
        text-shadow: 2px 1px #00040a;
        transition: 0.5s;
        cursor: pointer;
      }
      .alert-success:hover {
        background-color: rgba(7, 149, 66, 0.35);
        transition: 0.5s;
      }
      .alert-simple.alert-info {
        border: 1px solid rgba(6, 44, 241, 0.46);
        background-color: rgba(7, 73, 149, 0.12156862745098039);
        box-shadow: 0px 0px 2px #0396ff;
        color: #0396ff;
        text-shadow: 2px 1px #00040a;
        transition: 0.5s;
        cursor: pointer;
      }

      .alert-info:hover {
        background-color: rgba(7, 73, 149, 0.35);
        transition: 0.5s;
      }

      .blue-cross {
        font-size: 18px;
        color: #0bd2ff;
        text-shadow: none;
      }

      .alert-simple.alert-warning {
        border: 1px solid rgba(241, 142, 6, 0.81);
        background-color: rgba(220, 128, 1, 0.16);
        box-shadow: 0px 0px 2px #ffb103;
        color: #ffb103;
        text-shadow: 2px 1px #00040a;
        transition: 0.5s;
        cursor: pointer;
      }

      .alert-warning:hover {
        background-color: rgba(220, 128, 1, 0.33);
        transition: 0.5s;
      }

      .warning {
        font-size: 18px;
        color: #ffb40b;
        text-shadow: none;
      }

      .alert-simple.alert-danger {
        border: 1px solid rgba(241, 6, 6, 0.81);
        background-color: rgba(220, 17, 1, 0.16);
        box-shadow: 0px 0px 2px #ff0303;
        color: #ff0303;
        text-shadow: 2px 1px #00040a;
        transition: 0.5s;
        cursor: pointer;
      }

      .alert-danger:hover {
        background-color: rgba(220, 17, 1, 0.33);
        transition: 0.5s;
      }

      .danger {
        font-size: 18px;
        color: #ff0303;
        text-shadow: none;
      }

      .alert-simple.alert-primary {
        border: 1px solid rgba(6, 241, 226, 0.81);
        background-color: rgba(1, 204, 220, 0.16);
        box-shadow: 0px 0px 2px #03fff5;
        color: #03d0ff;
        text-shadow: 2px 1px #00040a;
        transition: 0.5s;
        cursor: pointer;
      }

      .alert-primary:hover {
        background-color: rgba(1, 204, 220, 0.33);
        transition: 0.5s;
      }

      .alertprimary {
        font-size: 18px;
        color: #03d0ff;
        text-shadow: none;
      }

      .col-sm-12 {
        margin-bottom: 15px;
      }

      .row {
        margin-top: 30px;
      }
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
    </style>
  </head>
  <body>
       <!-- partial:index.partial.html -->
       <div class="dashboard">
        <aside class="search-wrap">
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
                   <a href="../../Controller/logout.php">
            <button>
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
            </button>
           </a>
                           
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
                  <a href="../Property_Owner_Dashboard_Tabs/propertyowner_dashboard.php">
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
                  <a href="../Property_Owner_Dashboard_Tabs/owner_calender.php">
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
                  <a href="../Property_Owner_Dashboard_Tabs/taskStatusUpdate.php">
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
                    Maintanance & Repairs
                  </a>
                </li>
  
  
                <li>
                  <a href="../Property_Owner_Dashboard_Tabs/communications.php">
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
                  <a href="../Property_Owner_Dashboard_Tabs/documentationAccess.php">
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
                  <a href="update_details.php">
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
                  <a href=" https://www.property24.com/">
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
                          View properties
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
  <a href="https://youtu.be/QYKTpYEJRcQ" target="_blank" title="Find Property Pulse on Youtube">
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
          <h1>Task Status Update</h1>

          <div class="action">
            <!--Redirect to the previous page-->
            <button onclick="window.history.back()" class="back-button">
        	    Back
        	</button>
          </div>
        </header>

        <div class="content">
          <section>
            <div class="square_box box_three"></div>
            <div class="square_box box_four"></div>
            <div class="container mt-5">
              <div class="row">
                <div class="col-sm-12">
                  <div
                    class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                  >
                    <button
                      type="button"
                      class="close font__size-18"
                      data-dismiss="alert"
                    >
                      <span aria-hidden="true"
                        ><a> <i class="fa fa-times greencross"></i> </a
                      ></span>
                      <span class="sr-only">Close</span>
                    </button>
                    <i
                      class="start-icon far fa-check-circle faa-tada animated"
                    ></i>
                    <strong class="font__weight-semibold"
                      >Drain blockage</strong
                    >
                    maintenance complete!
                  </div>
                </div>

                <div class="col-sm-12">
                  <div
                    class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                    role="alert"
                    data-brk-library="component__alert"
                  >
                    <button
                      type="button"
                      class="close font__size-18"
                      data-dismiss="alert"
                    >
                      <span aria-hidden="true">
                        <i class="fa fa-times danger"></i>
                      </span>
                      <span class="sr-only">Close</span>
                    </button>
                    <i
                      class="start-icon far fa-times-circle faa-pulse animated"
                    ></i>
                    <strong class="font__weight-semibold"
                      >Shower leakage maintenance</strong
                    >
                    unsuccessful, shower is still leaking.
                  </div>
                </div>

                <div class="col-sm-12">
                  <div
                    class="alert fade alert-simple alert-primary alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                    role="alert"
                    data-brk-library="component__alert"
                  >
                    <button
                      type="button"
                      class="close font__size-18"
                      data-dismiss="alert"
                    >
                      <span aria-hidden="true"
                        ><i class="fa fa-times alertprimary"></i
                      ></span>
                      <span class="sr-only">Close</span>
                    </button>
                    <i
                      class="start-icon fa fa-thumbs-up faa-bounce animated"
                    ></i>
                    <strong class="font__weight-semibold"
                      >Drain blockage</strong
                    >
                    still in progress.
                  </div>
                </div>

                <div class="col-sm-12">
                  <div
                    class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                    role="alert"
                    data-brk-library="component__alert"
                  >
                    <button
                      type="button"
                      class="close font__size-18"
                      data-dismiss="alert"
                    >
                      <span aria-hidden="true">
                        <i class="fa fa-times warning"></i>
                      </span>
                      <span class="sr-only">Close</span>
                    </button>
                    <i
                      class="start-icon fa fa-exclamation-triangle faa-flash animated"
                    ></i>
                    <strong class="font__weight-semibold">Pending!</strong>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
    <!-- partial -->
  </body>
<script>
         
function toggleTab() {
  var content = document.getElementById("mediaLinks");
  content.classList.toggle("active");
        
}
</script>
</html>
