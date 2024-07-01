<!DOCTYPE html>
<html>
  <head>
    <title>Tenant Management System</title>
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
        margin: 20px auto;
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

      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        color: #fff; /* Adjusted text color */
      }

      th, td {
        padding: 10px;
        border: 1px solid #4f4f7a; /* Adjusted border color */
        text-align: left;
        color: #fff; /* Adjusted text color */
      }

      th {
        background-color: #3a3a4e; /* Adjusted header background color */
      }

      tr:nth-child(even) {
        background-color: #323347; /* Adjusted even row background color */
      }

      .form-input {
        margin-bottom: 15px;
        color: #fff; /* Adjusted text color for form */
      }

      .form-input label {
        display: block;
        margin-bottom: 5px;
        color: #6cb6ff; /* Adjusted label color */
      }

      .form-input input,
      .form-input select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #4f4f7a; /* Adjusted border color */
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #3a3a4e; /* Adjusted input background color */
        color: #fff; /* Adjusted text color */
      }

      button {
        background-color: #4caf50; /* Green */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      button:hover {
        background-color: #45a049;
      }

      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      input[type="submit"] {
        background-color: #28a745;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
      }

      input[type="submit"]:hover {
        background-color: #218838;
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

      #name_error, #lastname_error{
        color: red;
        font-size: small;
        margin: 0px;
      }

      h3 {
        color: #6cb6ff;
      }

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
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Tenants</h2>
      <!-- Tenant List -->
      <table>
        <h3>Example:</h3>
        <tr>
          <th>Name</th>
          <th>Contact Info</th>
         
        </tr>
        <!-- Repeat for each tenant -->
        <tr>
          <td>John Doe</td>
          <td>johndoe@example.com</td>
        </tr>
      </table>

      <h2>Add Tenant</h2>
      <form id="addTenantForm" action="../Controller/add_tenant.php" method="post">
        <div class="form-input">
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" name="firstName" required />
          <p id="name_error"></p>
        </div>
        
        <div class="form-input">
          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" name="lastName" required />
          <p id="lastname_error"></p>
        </div>

        <div class="form-input">
          <label for="contactInfo">Contact Info:</label>
          <input type="text" id="contactInfo" name="contactInfo" required />
        </div>

        <div class="form-input">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
          <span id="togglePassword" class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
        </div>

        <div class="form-input">
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required />
        </div>

        
        <input type="submit" value="Add Tenant">
      </form>
    </div>  
    <div id="popup" class="popup hidden">
      <h4>Errors:</h4>
      <ul id="errorMessages"></ul>
      <button onclick="closePopup()">Close</button>
    </div>
    <script>
      function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var toggleIcon = document.getElementById('togglePassword');

        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          toggleIcon.textContent = "🔒";
        } else {
          passwordInput.type = "password";
          toggleIcon.textContent = "👁️";
        }
      }

      function closePopup() {
        var popup = document.getElementById('popup');
        popup.classList.add('hidden');
        setTimeout(function () {
          popup.style.display = 'none';
        }, 500); // Match the transition duration
      }

      document.getElementById("addTenantForm").onsubmit = function(event) {
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var contactInfo = document.getElementById("contactInfo").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        var errorMessages = [];

        if (!isValidName(firstName)) errorMessages.push("Invalid first name.");
        if (!isValidName(lastName)) errorMessages.push("Invalid last name.");
        if (!isValidEmail(contactInfo)) errorMessages.push("Invalid contact info.");
        if (!isValidPassword(password)) errorMessages.push("Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.");
        if (password !== confirmPassword) errorMessages.push("Passwords do not match.");

        if (errorMessages.length > 0) {
          event.preventDefault(); // Prevent form submission
          var errorList = document.getElementById('errorMessages');
          errorList.innerHTML = '';
          errorMessages.forEach(function (message) {
            var li = document.createElement('li');
            li.textContent = message;
            errorList.appendChild(li);
          });
          var popup = document.getElementById('popup');
          popup.classList.remove('hidden');
          setTimeout(function () {
            popup.style.top = '20px';
          }, 0); // Match the transition duration
        }
      };

      function isValidName(name) {
        return name.trim() !== "" && /^[A-Za-z\s]+$/.test(name);
      }

      function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      }

      function isValidPassword(password) {
        // Check for minimum length
        if (password.length < 8) {
          return false;
        }
        // Check for at least one uppercase letter
        if (!/[A-Z]/.test(password)) {
          return false;
        }
        // Check for at least one lowercase letter
        if (!/[a-z]/.test(password)) {
          return false;
        }
        // Check for at least one digit
        if (!/[0-9]/.test(password)) {
          return false;
        }
        // Check for at least one special character
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
          return false;
        }
        // If all checks pass
        return true;
      }
    </script>
  </body>
</html>
