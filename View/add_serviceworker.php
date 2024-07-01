<?php
require_once "../Database/db_config.php";


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Service Provider Registration</title>
    <style>
      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #1a1a2e;
        color: #d4d4d4;
        margin: 0;
        padding: 20px;
      }
      .container {
        max-width: 400px;
        margin: auto;
        background: #2a2a3e;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h2 {
        color: #6cb6ff;
        text-align: center;
        margin-bottom: 20px;
      }
      label {
        color: #c6c6c6;
        display: block;
        margin-bottom: 5px;
      }
      input[type="text"],
      input[type="email"],
      input[type="submit"],
      input[type="password"],
      textarea,
      select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #4f4f7a;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #3a3a4e;
        color: #fff;
      }
      input[type="submit"] {
        background-color: #28a745;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
      }
      input[type="submit"]:hover {
        background-color: #218838;
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
      <h2>Register as a Service Provider</h2>
      <table>
        <tr>
          <h3>Example:</h3>
          <th>Name</th>
          <th>Contact Email</th>
          <th>Contact Phone</th>
        </tr>
        <!-- Repeat for each tenant -->
        <tr>
          <td>John Doe</td>
          <td>johndoe@example.com</td>
          <td>0224234234</td>
        </tr>
      </table>
      <form
        id="serviceProviderForm"
        action="../Controller/add_serviceworker.php"
        method="post"
      >
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required />

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required />

        <label for="companyName">Company Name:</label>
        <input type="text" id="companyName" name="companyName" required />

        <label for="contactEmail">Contact Email:</label>
        <input type="email" id="contactEmail" name="contactEmail" required />

        <label for="contactPhone">Contact Phone:</label>
        <input type="text" id="contactPhone" name="contactPhone" required />


        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        <span id="togglePassword" class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required />

        <input type="submit" value="Register" />
      </form>
    </div>
    <div id="popup" class="popup hidden">
      <h4>Errors:</h4>
      <ul id="errorMessages"></ul>
      <button onclick="closePopup()">Close</button>
    </div>
  </body>
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

    document.getElementById("serviceProviderForm").onsubmit = function (event) {
      var errorMessages = [];

      // Validate each field according to specific criteria
      if (!isValidName(document.getElementById("firstName").value)) {
        errorMessages.push("Invalid first name.");
      }
      if (!isValidName(document.getElementById("lastName").value)) {
        errorMessages.push("Invalid last name.");
      }
      if (!isValidCompanyName(document.getElementById("companyName").value)) {
        errorMessages.push("Company name cannot be empty.");
      }
      if (!isValidEmail(document.getElementById("contactEmail").value)) {
        errorMessages.push("Invalid email address.");
      }
      if (!isValidPhoneNumber(document.getElementById("contactPhone").value)) {
        errorMessages.push("Invalid phone number.");
      }
      if (!isValidSpecialization(document.getElementById("specialization").value)) {
        errorMessages.push("Specialization cannot be empty.");
      }
      if (!isValidPassword(document.getElementById("password").value)) {
        errorMessages.push("Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.");
      }
      if (document.getElementById("password").value !== document.getElementById("confirmPassword").value) {
        errorMessages.push("Passwords do not match.");
      }

      // Show error messages if there are any
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

    function isValidCompanyName(name) {
      return name.trim() !== ""; // Add more criteria if necessary
    }

    function isValidEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isValidPhoneNumber(phoneNumber) {
      // Basic validation for phone numbers (customize regex as needed)
      return /^\+?[0-9\s]+$/.test(phoneNumber);
    }

    function isValidSpecialization(specialization) {
      return specialization.trim() !== "";
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
</html>
