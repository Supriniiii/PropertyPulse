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
                "zoned", "vacant", "plumbing", "detectors",
                "lighting", "access", "parking", "noise", "amenities"
            ];

            let yesCount = 0;

            for (let i = 0; i < questions.length; i++) {
                if (form[questions[i]][0].checked) {
                    yesCount++;
                }
            }

            if (yesCount >= 6) {
                alert("Application Accepted! Redirecting to registration page.");
                window.location.href = "add_propertyowner.php";
                return false; // prevent form submission
            } else {
                alert("Application Unaccepted!");
                return false; // prevent form submission
            }
        }
    </script>
</head>

<body>

    <div class="container">
        <h2>Property Owner Application Form</h2>
        <form name="propertyForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
            onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Is the property legally zoned for rental use?</label>
                <input type="radio" id="zonedYes" name="zoned" value="Yes" required> Yes
                <input type="radio" id="zonedNo" name="zoned" value="No"> No
            </div>
            <div class="form-group">
                <label>Is the property currently vacant and ready for occupancy?</label>
                <input type="radio" id="vacantYes" name="vacant" value="Yes" required> Yes
                <input type="radio" id="vacantNo" name="vacant" value="No"> No
            </div>
            <div class="form-group">
                <label>Does the property have adequate plumbing and sanitation facilities?</label>
                <input type="radio" id="plumbingYes" name="plumbing" value="Yes" required> Yes
                <input type="radio" id="plumbingNo" name="plumbing" value="No"> No
            </div>
            <div class="form-group">
                <label>Are there working smoke detectors and fire extinguishers installed?</label>
                <input type="radio" id="detectorsYes" name="detectors" value="Yes" required> Yes
                <input type="radio" id="detectorsNo" name="detectors" value="No"> No
            </div>
            <div class="form-group">
                <label>Is there adequate lighting in and around the property?</label>
                <input type="radio" id="lightingYes" name="lighting" value="Yes" required> Yes
                <input type="radio" id="lightingNo" name="lighting" value="No"> No
            </div>
            <div class="form-group">
                <label>Is there secure access to the property (e.g., locks, gates)?</label>
                <input type="radio" id="accessYes" name="access" value="Yes" required> Yes
                <input type="radio" id="accessNo" name="access" value="No"> No
            </div>
            <div class="form-group">
                <label>Does the property have adequate parking facilities?</label>
                <input type="radio" id="parkingYes" name="parking" value="Yes" required> Yes
                <input type="radio" id="parkingNo" name="parking" value="No"> No
            </div>
            <div class="form-group">
                <label>Is the property free from any major noise disturbances (e.g., construction, traffic)?</label>
                <input type="radio" id="noiseYes" name="noise" value="Yes" required> Yes
                <input type="radio" id="noiseNo" name="noise" value="No"> No
            </div>
            <div class="form-group">
                <label>Is the property within a reasonable distance from essential amenities (e.g., grocery stores,
                    schools)?</label>
                <input type="radio" id="amenitiesYes" name="amenities" value="Yes" required> Yes
                <input type="radio" id="amenitiesNo" name="amenities" value="No"> No
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Submit Application</button>
            </div>
        </form>
    </div>

</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $ownerId = $_POST['ownerId'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $propertyName = $_POST['propertyName'];
    $propertyAddress = $_POST['propertyAddress'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Processing and validation can be added here if needed

    // Redirect to registration page if application is accepted (logic handled in JavaScript)
    // No additional PHP processing is needed here for redirection since it's handled client-side
}
?>