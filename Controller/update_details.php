<?php
session_start();
require '../Database/db_config.php';
require '../Model/verify_user.php'; 

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_username']; 

//$firstName = $_POST['firstName'];
//$lastName = $_POST['lastName'];
//$email = $_POST['email'];

$FirstName = $_POST['name'] ?? null;
$LastName = $_POST['last_name'] ?? null;

$ContactInfo = $_POST['email'] ?? null;

$CompanyName = $_POST['CompanyName'] ?? null;
$ContactPhone = $_POST['phoneNumber'] ?? null;
$Specialization=$_POST['Specialization'] ?? null;

// Build the SQL statement dynamically based on provided input
$fieldsToUpdate = [];
$types = '';
$values = [];


if ($Specialization !== null && $Specialization !== '') {
    $fieldsToUpdate[] = "Specialization=?";
    $types .= 's';
    $values[] = $Specialization;
}
if ($LastName !== null && $LastName !== '') {
    $fieldsToUpdate[] = "LastName=?";
    $types .= 's';
    $values[] = $LastName;
}
if ($FirstName !== null && $FirstName !== '') {
    $fieldsToUpdate[] = "FirstName=?";
    $types .= 's';
    $values[] = $FirstName;
}
if ($ContactInfo !== null && $ContactInfo !== '') {
    $fieldsToUpdate[] = "ContactInfo=?";
    $types .= 's';
    $values[] = $ContactInfo;
}

//CompanyName
if ($ContactPhone !== null && $ContactPhone !== '') {
    $fieldsToUpdate[] = "ContactPhone=?";
    $types .= 'i';
    $values[] = $ContactPhone;
}

if ($CompanyName !== null && $CompanyName !== '') {
    $fieldsToUpdate[] = "CompanyName=?";
    $types .= 's';
    $values[] = $CompanyName;
}

$userType=$_SESSION['user_type'];
$location ='';

if($userType == 'tenant'){
    $sql = "UPDATE ttenant SET " . implode(", ", $fieldsToUpdate) . " WHERE UserID=?";
    $location='Location: ../View/Tenant_Dashboard_Tabs/update_details.php';
}else if($userType =='property_owner'){
    
    $sql = "UPDATE propertyowner SET " . implode(", ", $fieldsToUpdate) . " WHERE UserID=?";
    $location= 'Location: ../View/Property_Owner_Dashboard_Tabs/update_details.php';
}else if($userType =='service_worker'){

    $sql = "UPDATE serviceworker SET " . implode(", ", $fieldsToUpdate) . " WHERE UserID=?";
    $location= 'Location: ../View/Service_Provider_Dashboard_Tabs/update_details.php';
}
//Service_Provider_Dashboard_Tabs

if (!empty($fieldsToUpdate)) {
   // $sql = "UPDATE ttenant SET " . implode(", ", $fieldsToUpdate) . " WHERE UserID=?";
    $stmt = $link->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $link->error);
    }

    $types .= 'i';
    $values[] = $user_id;
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
       // echo "Record updated successfully for user ID: " . $user_id;
        header($location);
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No fields to update or missing user_id.";
}

$link->close();


?>
