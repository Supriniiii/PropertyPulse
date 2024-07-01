<!DOCTYPE html>
<html lang="en">
        
        <!-- 
#2a2a3e; //dark blue
#6cb6ff;//sky blue
#ede8f0; //white
#b6bbc6; //gray
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Owner Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2a2a3e;
        }

        .container {
            width: 50%;
            margin: auto;
            background:#fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            color:#6cb6ff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #2a2a3e;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #2a2a3e;
            border-radius: 5px;
        }

        input[type="radio"] {
            margin-right: 10px;
            color:#fff;
        }

        .btn {
            display: inline-block;
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #4cae4c;
        }
    </style>
   <script>
           function validateForm() {
    const form = document.forms["propertyForm"];
    const questions = [
        "licensed_insured", "experience_residential", "emergency_services",
        "written_estimate", "warranty"
    ];

    let yesCount = 0;

    for (let i = 0; i < questions.length; i++) {
        if (form[questions[i]][0].checked && form[questions[i]][0].value === "Yes") {
            yesCount++;
        }
    }

    if (yesCount >= 3) {
        alert("Application Accepted! Redirecting to registration page.");
        window.location.href = "add_serviceworker.php";
        return false; // prevent form submission
    } else {
        alert("Application Unaccepted!");
             window.location.href = "../index.php";
        return false; // prevent form submission
    }
}

           
           </script>
</head>

<body>

<div class="container">
    <h2>Specialization Application Form</h2>
    <form name="propertyForm" action="" method="post" onsubmit="return validateForm()">
        <?php
        // Get the selected specialization from the form
        $specialization = $_POST['specialization'];

        // Display questions based on the selected specialization
        if ($specialization == "Plumber") {
            echo '<label>Is the plumber licensed and insured? <br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the plumber have experience with residential plumbing? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the plumber available for emergency services? <br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the plumber provide a written estimate before starting the job? <br>
                  <input type="radio" name="written_estimate" value="Yes" required> Yes
                  <input type="radio" name="written_estimate" value="No"> No
                  </label><br><br>';

            echo '<label>Does the plumber offer a warranty on their work? <br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        } elseif ($specialization == "Electrician") {
            echo '<label>Is the electrician licensed and insured? <br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the electrician have experience with residential electrical systems? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the electrician available for emergency services? <br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the electrician provide a written estimate before starting the job? <br>
                  <input type="radio" name="written_estimate" value="Yes" required> Yes
                  <input type="radio" name="written_estimate" value="No"> No
                  </label><br><br>';

            echo '<label>Does the electrician offer a warranty on their work? <br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        } elseif ($specialization == "Glazier") {
            echo '<label>Is the glazier licensed and insured? <br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the glazier have experience with residential glazing projects? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the glazier available for emergency services?<br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the glazier provide a written estimate before starting the job? <br>
                  <input type="radio" name="written_estimate" value="Yes" required> Yes
                  <input type="radio" name="written_estimate" value="No"> No
                  </label><br><br>';

            echo '<label>Does the glazier offer a warranty on their work?<br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        } elseif ($specialization == "Security") {
            echo '<label>Is the security provider licensed and insured? <br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the security provider have experience with residential security systems? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the security provider available for emergency services?<br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the security provider offer a range of security solutions (e.g., alarms, cameras)? <br>
                  <input type="radio" name="range_solutions" value="Yes" required> Yes
                  <input type="radio" name="range_solutions" value="No"> No
                  </label><br><br>';

            echo '<label>Does the security provider offer a warranty on their equipment and installation? <br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        } elseif ($specialization == "Tile Installer") {
            echo '<label>Is the tile installer licensed and insured?<br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the tile installer have experience with residential tile installations? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the tile installer available for emergency services? <br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the tile installer provide a written estimate before starting the job? <br>
                  <input type="radio" name="written_estimate" value="Yes" required> Yes
                  <input type="radio" name="written_estimate" value="No"> No
                  </label><br><br>';

            echo '<label>Does the tile installer offer a warranty on their work? )<br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        } elseif ($specialization == "Carpenter") {
            echo '<label>Is the carpenter licensed and insured?<br>
                  <input type="radio" name="licensed_insured" value="Yes" required> Yes
                  <input type="radio" name="licensed_insured" value="No"> No
                  </label><br><br>';

            echo '<label>Does the carpenter have experience with residential carpentry projects? <br>
                  <input type="radio" name="experience_residential" value="Yes" required> Yes
                  <input type="radio" name="experience_residential" value="No"> No
                  </label><br><br>';

            echo '<label>Is the carpenter available for emergency services? <br>
                  <input type="radio" name="emergency_services" value="Yes" required> Yes
                  <input type="radio" name="emergency_services" value="No"> No
                  </label><br><br>';

            echo '<label>Does the carpenter provide a written estimate before starting the job?<br>
                  <input type="radio" name="written_estimate" value="Yes" required> Yes
                  <input type="radio" name="written_estimate" value="No"> No
                  </label><br><br>';

            echo '<label>Does the carpenter offer a warranty on their work? <br>
                  <input type="radio" name="warranty" value="Yes" required> Yes
                  <input type="radio" name="warranty" value="No"> No
                  </label><br><br>';
        }
        ?>

        <button type="submit" class="btn">Submit Application</button>
    </form>
</div>

</body>

</html>

<?php

?>