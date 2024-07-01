<?php
  session_start();
  $username = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : "Guest";
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
    <link rel="stylesheet" href="./schedulingAndCalendar.css" />

    <style>
      a {
        color: #fff;
      }
    </style>
  </head>
  <body>
    <!-- partial:index.partial.html -->
    <div class="dashboard">
      <header class="menu-wrap">
        <nav>
          <figure class="user">
            <div class="user-avatar">
              <img
                src="https://media.istockphoto.com/id/1464818215/photo/black-female-plumber-at-work.jpg?s=612x612&w=0&k=20&c=Uyc34wV4r3FKo9p7A7FBDRVHqvC5u8lzgZ-E9CxwcOc="
                alt="Moipone Malema"
              />
            </div>
            <figcaption><?php echo $username; ?></figcaption>
          </figure>

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
                <a href="#">
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
                <a href="#">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M13.094 2.085l-1.013-.082a1.082 1.082 0 0 0-.161 0l-1.063.087C6.948 2.652 4 6.053 4 10v3.838l-.948 2.846A1 1 0 0 0 4 18h4.5c0 1.93 1.57 3.5 3.5 3.5s3.5-1.57 3.5-3.5H20a1 1 0 0 0 .889-1.495L20 13.838V10c0-3.94-2.942-7.34-6.906-7.915zM12 19.5c-.841 0-1.5-.659-1.5-1.5h3c0 .841-.659 1.5-1.5 1.5zM5.388 16l.561-1.684A1.03 1.03 0 0 0 6 14v-4c0-2.959 2.211-5.509 5.08-5.923l.921-.074.868.068C15.794 4.497 18 7.046 18 10v4c0 .107.018.214.052.316l.56 1.684H5.388z"
                    />
                  </svg>

                  Notifications and Alerts
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

         
        </div>
      </main>
    </div>
    <!-- partial -->
    <script>
      var monthNamesRy = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      var daysOfTheWeekRy = ["S", "M", "T", "W", "T", "F", "S"];

      var d = new Date();
      var year = d.getFullYear(); // 2016
      document.querySelector("#year").innerHTML = year;
      var thisMonth = d.getMonth(); // 0 - 11
      var today = d.getDate(); // 1 -31
      //var nthday = d.getDay();// 0 - 7
      var daysOfTheMonthDiv = document.querySelectorAll(".daysOfTheMonth");

      for (var month = 0; month < 12; month++) {
        createCalendar(month);
      }

      function createCalendar(month) {
        var monthDiv = createMonthHeader(month);

        var firstDayOfTheMonth = getFirstDayOfTheMonth(year, month);
        var daysinmonth = daysInMonth(year, month);
        var counter = 0,
          order = 6;

        for (var i = 0; i < firstDayOfTheMonth + 7; i++) {
          order++;
          createDay(month, "&nbsp;", order, monthDiv);
        }
        for (
          var i = firstDayOfTheMonth;
          i < daysInMonth(year, month) + firstDayOfTheMonth;
          i++
        ) {
          counter++;
          order++;
          createDay(month, counter, order, monthDiv);
        }

        for (var i = firstDayOfTheMonth + daysinmonth; i < 6 * 7; i++) {
          order++;
          createDay(month, "&nbsp;", order, monthDiv);
        }
      }

      function createDay(month, counter, order, monthDiv) {
        //if(order == 8){order = -1}
        var day = document.createElement("div");
        if (month == thisMonth && counter == today) {
          day.setAttribute("class", "to day");
        } else {
          day.setAttribute("class", "day");
        }
        day.setAttribute("style", "order:" + order);
        day.innerHTML = counter;
        monthDiv.appendChild(day);
        /*
<div class="monthDiv">
<div class="day">5</div>
*/
      }

      function createMonthHeader(month) {
        var calendar = document.querySelector(".calendar");

        var monthDiv = document.createElement("div");
        monthDiv.setAttribute("class", "month");
        calendar.appendChild(monthDiv);

        var h4 = document.createElement("h4");
        h4.innerHTML = monthNamesRy[month];
        monthDiv.appendChild(h4);

        for (var i = 0; i < 7; i++) {
          //var order = (i == 0) ? order = 7 : order = i;
          var hday = document.createElement("div");
          hday.setAttribute("class", "day OfWeek");
          hday.setAttribute("style", "order:" + i);
          hday.innerHTML = daysOfTheWeekRy[i].toUpperCase();
          monthDiv.appendChild(hday);
        }

        return monthDiv;

        /*
<div class="month">
	
<div class="monthHeader">
<div class="day OfWeek">Sun</div>
<div class="day OfWeek">Mon</div>
<div class="day OfWeek">Tue</div>
<div class="day OfWeek">Wed</div>
<div class="day OfWeek">Thu</div>
<div class="day OfWeek">Fri</div>
<div class="day OfWeek">Sat</div>
</div>
		
<div class="daysOfTheMonth">
*/
      }

      function daysInMonth(year, month) {
        return new Date(year, month + 1, 0).getDate(); //29/03/2016 (month + 1)
      }

      /*function leapYear(year){
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}

function getNextMonth(month){
 if (month == 11) {
    var nextMonth = 0;
} else {
    var nextMonth = month+1;
}
return nextMonth;
}
*/
      function getMonthName(month) {
        return monthNamesRy[month];
      }
      function getDayName(day) {
        return daysOfTheWeekRy[day];
      }

      function getFirstDayOfTheMonth(y, m) {
        var firstDay = new Date(y, m, 1);
        return firstDay.getDay();
      }
      function getLastDayOfTheMonth(y, m) {
        var lastDay = new Date(y, m + 1, 0);
        return lastDay.getDay();
      }

      // the popp up

      var calendar = document.querySelector(".calendar");
      var cloneCont = document.querySelector(".cloneCont");
      var requestId = false;
      calendar.addEventListener(
        "click",
        function (e) {
          if (this.querySelector(".cloneCont")) {
            this.removeChild(this.querySelector(".cloneCont"));
          } else if (e.target.parentNode.className == "month") {
            var monthClone = e.target.parentNode.cloneNode(true);
            monthClone.className += " cloneMonth";
            var cloneCont = document.createElement("div");
            cloneCont.className += " cloneCont";
            cloneCont.appendChild(monthClone);
            this.appendChild(cloneCont);
          }
        },
        false
      );
    </script>
  </body>
</html>
