document.getElementById("addSomeoneForm").onsubmit = function (event) {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirmPassword").value;
  var firstName = document.getElementById("firstName").value;
  var lastName = document.getElementById("lastName").value;
  var contactInfo = document.getElementById("contactInfo").value;
  var apartmentAddress = document.getElementById("apartmentAddress").value;

  if (!isValidLastName(lastName)) {
    event.preventDefault();
  }

  if (!isValidName(firstName)) {
    event.preventDefault();
  }

  if (!isValidEmail(contactInfo)) {
    event.preventDefault();
  }

  if (password === confirmPassword) {
    isValidPassword(password);
  } else {
    event.preventDefault();
    alert("Passwords dont match");
  }
};

function isValidName(name) {
  // let errorMsg = document.getElementById("name_error");
  // if (name.length === 0) {
  //   errorMsg.innerText = "Provide name";
  //     return false;
  // }

  for (let i = 0; i < name.length; i++) {
    let character = name[i];
    if (
      !(character >= "A" && character <= "Z") &&
      !(character >= "a" && character <= "z")
    ) {
      // errorMsg.innerText = "Provide proper name";
      alert("Provide proper name");
      return false;
    }
  }
  errorMsg.innerText = "";
  return true;
}

function isValidLastName(lastname) {
  // let errorMsg = document.getElementById("lastname_error");
  // if (name.length === 0) {
  //   errorMsg.innerText = "Provide name";
  //     return false;
  // }

  for (let i = 0; i < lastname.length; i++) {
    let character = lastname[i];
    if (
      !(character >= "A" && character <= "Z") &&
      !(character >= "a" && character <= "z")
    ) {
      // errorMsg.innerText = "Provide proper lastname";
      alert("Provide proper lastname");

      return false;
    }
  }
  errorMsg.innerText = "";
  return true;
}

function isValidEmail(email) {
  let atIndex = email.indexOf("@");
  if (atIndex === -1 || atIndex !== email.lastIndexOf("@")) {
    alert("There should only be one '@' sign");
    return false; // Ensure there is exactly one '@' character
  }

  let parts = email.split("@");
  let localPart = parts[0];
  let domainPart = parts[1];

  if (localPart.length === 0 || domainPart.length === 0) {
    alert(
      "Please provide email with the following format: example@something.com"
    );
    return false;
  }

  if (domainPart.indexOf(".") === -1) {
    alert(
      "Please provide email with the following format: example@something.com"
    );
    return false;
  }

  let domainParts = domainPart.split(".");
  for (let i = 0; i < domainParts.length; i++) {
    if (domainParts[i].length === 0) {
      alert(
        "Please provide email with the following format: example@something.com"
      );
      return false; // Ensure no part of the domain is empty
    }
  }

  return true;
}

function isValidPassword(password) {
  if (password.length < 8) {
    event.preventDefault();
    alert("Password too short");
    return false;
  }

  let hasLowercase = false;
  let hasUppercase = false;
  let hasDigit = false;

  for (let i = 0; i < password.length; i++) {
    let character = password[i];
    if (character >= "a" && character <= "z") {
      hasLowercase = true;
    } else if (character >= "A" && character <= "Z") {
      hasUppercase = true;
    } else if (character >= "0" && character <= "9") {
      hasDigit = true;
    }

    if (hasLowercase && hasUppercase && hasDigit) {
      return true;
    }
  }
  alert(
    "Password Doesn't contain : lowercase letter, UPPERCASE LETTER or a number"
  );
  event.preventDefault();
  return false;
}
