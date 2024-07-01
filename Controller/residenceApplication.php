<?php
session_start();
require "../Database/db_config.php";  // Adjust the path as per your file structure
$_SESSION['exitOrNot'] ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNumber = $_POST['idNumber'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $bankName = $_POST['bankName'];
    $accountType = $_POST['accountType'];
    $accountNumber = $_POST['accountNumber'];
    $monthlyIncome = $_POST['monthlyIncome'];
    $property = $_POST['property'];
    $user_id= $_SESSION['user_id'];
    $tenant_id= $_SESSION['tenant_id'] ;

    
    // Additional applicant information
    $creditHistory = $_POST['creditHistory'];
    $evicted = isset($_POST['evicted']) ? 1 : 0;
    $movedOut = isset($_POST['movedOut']) ? 1 : 0;
    $bankruptcy = isset($_POST['bankruptcy']) ? 1 : 0;
    $suedForRent = isset($_POST['suedForRent']) ? 1 : 0;
    $suedForDamage = isset($_POST['suedForDamage']) ? 1 : 0;
    $convicted = isset($_POST['convicted']) ? 1 : 0;
    
         // Split the string by the hyphen delimiter
         $parts = explode('-', $property);

         // Get the last part of the split string
         $lastPart = end($parts);
 
         // Convert the last part to a float first and then to an integer
         $lastNumber = (int) floatval($lastPart);
         $property1 = $lastNumber;
         $_SESSION['property'] =$property1;
         $price =$property1*3000;
         $amount =(int)  $monthlyIncome;



    // Check if the user has already applied
    $sql_check_application = "SELECT id_number FROM residence_applications WHERE tenant_id = ?";
    $stmt_check_application = $link->prepare($sql_check_application);
    $stmt_check_application->bind_param("s", $tenant_id);
    $stmt_check_application->execute();
    $stmt_check_application->store_result();

    if ($stmt_check_application->num_rows > 0) {
        header("Location: ../View/Tenant_Dashboard_Tabs/residenceApplicationOutCome.php");
        $_SESSION['exitOrNot'] = "You have already submitted an application.";
    } else {

        if( $price>$amount){
            $_SESSION['exitOrNot'] = "You do not qualify for this apartment due to not meeting the minimum salary requirements for it";
            $_SESSION['application_status'] ='rejected';
           // $application_status = 'rejected';
            header("Location: ../View/Tenant_Dashboard_Tabs/residenceApplicationOutCome.php");
            exit();
        }
    // Determine application status based on additional information
    $application_status = 'pending'; // Default status
    
    // Define acceptance criteria logic
    if ($evicted || $movedOut || $bankruptcy || $suedForRent || $suedForDamage || $convicted & $monthlyIncome > 10000) {
        $application_status = 'rejected';
    } elseif (strpos(strtolower($creditHistory), 'problem') !== false) {
        $application_status = 'review';
    } else {
        
        $application_status = 'accepted';
        $application_status1 = 0;
        $sql1="UPDATE apartment SET TenantID = '$tenant_id' , Status = '$application_status1' WHERE ApartmentID = '$property'";
        $sql1 =$link->query($sql1);
    }

    // Prepare SQL statement with correct number of placeholders
    $sql = "INSERT INTO residence_applications (id_number, age, gender, bank_name, account_type, account_number, monthly_income, property_choice, applicationstatus,tenant_id, dob,application_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, CURDATE())";
    $stmt = $link->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sisssssssss", $idNumber, $age, $gender, $bankName, $accountType, $accountNumber, $monthlyIncome, $property, $application_status,$tenant_id, $dob);

        // Execute statement
        if ($stmt->execute()) {
            header("Location: ../View/Tenant_Dashboard_Tabs/residenceApplicationOutCome.php");
            $_SESSION['exitOrNot'] = "Application submitted successfully with status: " ;
            $_SESSION['application_status'] =$application_status;
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $link->error;
    }
   
    // Close database connection
    $link->close();
  }
}
?>
