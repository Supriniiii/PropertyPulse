<?php
require_once "../Database/db_config.php";
// 2. Form Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apartmentNumbers = $_POST["apartmentNumber"];
    $floors = $_POST["floor"];
    $bedrooms = $_POST["bedrooms"];
    $bathrooms = $_POST["bathrooms"];
    $statuses = $_POST["status"];
   
     // Prepare and execute the insert query for each apartment
    $stmt = $conn->prepare("INSERT INTO apartment (ApartmentNumber, floor, bedrooms, bathrooms, status) VALUES (?, ?, ?, ?, ?)");

    for($i = 0; $i < count($apartmentNumbers); $i++) {
        $stmt->bind_param("siiis", $apartmentNumbers[$i], $floors[$i], $bedrooms[$i], $bathrooms[$i], $statuses[$i]);
        
        if ($stmt->execute() === TRUE) {
            echo "Apartment added successfully<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }
    
    $stmt->close(); 
}
// 3. Redirect (optional)// Redirect back to the form page (adjust the path if needed)
exit;
?>
