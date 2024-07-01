<?php
require_once "../../Database/db_config.php";
session_start();
$userId=$_SESSION["user_id"];
$username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : "Guest";
/*$sql = "SELECT * FROM serviceworker WHERE UserID= ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $workerId=$row['WorkerID'];
    } else {
        $workerId=-1;
    }
    $result->close(); 
} else {
    echo "Error executing query: " . $stmt->error;
}

$stmt->close(); */
//Query gets workerid using the user_id from the session
$getname = mysqli_query($link,"SELECT * FROM serviceworker WHERE UserID = {$_SESSION["user_id"]}");
$nameRow =  mysqli_fetch_assoc($getname);
$workerID = $nameRow['WorkerID'];
/*$getT = mysqli_query($link,"SELECT tw.WorkerID,tm.Description,tm.Urgencylevel FROM tworkorder tw,tmaintenancerequest tm WHERE tw.WorkerID = {$workerID} AND tw.RequestID = tm.RequestID");
$getMaintance =  mysqli_fetch_assoc($getT);*/
//Query selects ales from tworkorder using workerid
$getname = mysqli_query($link,"SELECT * FROM tworkorder WHERE WorkerID = {$workerID}");



/*echo $row['Description'];
echo $row['UrgencyLevel'];
echo $getNamwRow['Status'];*/

?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8" />
                <title>Service Provider Dashboard</title>
                <link
                      rel="stylesheet"
                      href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"
                      />
                <link
                      rel="stylesheet"
                      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
                      />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                <link rel="stylesheet" href="./style.css" />
                <style>

.content-head {
  margin-bottom: 50px;
}
.work-orders {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.no-requests {
  padding: 20px;
  text-align: center;
  color: #666;
}

.work-order-table {
  width: 100%;
  border-collapse: collapse;
  padding: 5px;
}

.work-order-table th,
.work-order-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.work-order-table th {
  background-color: #1b253d;
  font-weight: bold;
  color: white;
}

.work-order-table tr:hover {
  background-color: #f5f5f5;
}

.urgency-level {
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
}

.urgency-level.high {
  background-color: #ff6b6b;
  color: white;
}

.urgency-level.medium {
  background-color: #feca57;
  color: #333;
}

.urgency-level.low {
  background-color: #48dbfb;
  color: #333;
}
.search-form {
        max-width: 400px;
        margin: 20px auto;
    }

    .search-container {
        display: flex;
        border: 2px solid #ddd;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .search-input {
        flex-grow: 1;
        padding: 10px 15px;
        border: none;
        outline: none;
        font-size: 16px;
    }

    .search-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #0056b3;
    }

    .search-button i {
        font-size: 18px;
    }
                </style>
                
        </head>
        <body>
                <!-- partial:index.partial.html -->
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
                                                        <path
                                                              d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"
                                                              />
                                                </svg>
                                                <form action="search.php" method="post" class="search-form">
                                                  <div class="search-container">
                                                    <input type="text" name="searchkey" placeholder="Filter by urgency level" class="search-input" />
                                                     <button type="submit" class="search-button">
                                                      <i class="fas fa-search"></i>
                                                     </button>
                                                  </div>
                                                </form>
                                        </label>
                                </div>

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
                                                                <a href="../Service_Provider_Dashboard_Tabs/workOrdersAndRequests.php">
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
                                                                        Work Orders and Requests
                                                                </a>
                                                        </li>

                                                        <li>
                                                                <a href="service_provider_calender.php">
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
                                                                        Scheduling and Calendar
                                                                </a>
                                                        </li>

                                                        <li>
                                                                <a href="../Service_Provider_Dashboard_Tabs/taskStatusUpdate.php">
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
                                                                        Task Status Update
                                                                </a>
                                                        </li>



                                                        <li>
                                                                <a href="../Service_Provider_Dashboard_Tabs/communications.php">
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
                                                                <a href="../Service_Provider_Dashboard_Tabs/documentationAccess.php">
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
                                                </ul>
                                        </section>
                                </nav>
                        </header>

                        <main class="content-wrap">
  <header class="content-head">
    <h1>Work Orders & Requests</h1>
    <div class="action">
      <button onclick="window.history.back()" class="back-button">Back</button>
    </div>
  </header>
  
  <section class="work-orders">
    <?php 
    if(mysqli_num_rows($getname) == 0) {
      echo "<p class='no-requests'>No requests at the moment. Check back later.</p>";
    } else {
    ?>
    <table class="work-order-table">
      <thead>
        <tr>
          <th>Description</th>
          <th>Urgency Level</th>
          <th>Schedule</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($getNamwRow = mysqli_fetch_assoc($getname)) {
          $getMaintance = mysqli_query($link, "SELECT * FROM tmaintenancerequest WHERE RequestID = {$getNamwRow['RequestID']}");
          while($row = mysqli_fetch_assoc($getMaintance)) {
        ?>              
                <tr>
                      <td><?php echo htmlspecialchars($row['Description']); ?></td>
                    <td><span class="urgency-level <?php echo strtolower($row['UrgencyLevel']); ?>"><?php echo htmlspecialchars($row['UrgencyLevel']); ?></span></td>
                  <td>
                 <form method = "POST" action="service_provider_calender.php?ScheduleRequestID=<?php echo $row['RequestID']; ?>">
                     <input type="hidden"   name="Description" value="<?php echo htmlspecialchars($row['Description']); ?>">
                     <input type="hidden" value="<?php echo htmlspecialchars($getNamwRow['WorkerID']); ?>">
                     <a href="service_provider_calender.php"><button type="submit" >Schedule</button></a>
                  </form>
                  </td>	
              </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
    <?php } ?>
  </section> 
</main>
                
        <!-- partial -->
        </body>
</html>