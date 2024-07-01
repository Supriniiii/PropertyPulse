<?php
require_once '../../Database/db_config.php';

if(!isset($_GET['id'])){
    echo "<script> alert('Undefined Schedule ID.'); location.replace('./') </script>";
    $link->close();
    exit;
}

$delete = $link->query("DELETE FROM `service_schedule` WHERE ScheduleID = '{$_GET['id']}'");

if($delete){
    echo "<script> alert('Event has been deleted successfully.'); location.replace('./') </script>";
} else {
    echo "<pre>";
    echo "An Error occurred.<br>";
    echo "Error: ".$link->error."<br>";
    echo "SQL: DELETE FROM `service_schedule` WHERE ScheduleID = '{$_GET['id']}'<br>";
    echo "</pre>";
}

$link->close();
?>