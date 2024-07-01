<?php
// db_config.php
define('DB_SERVER', 'pdb1053.awardspace.net');
define('DB_USERNAME', '4445469_propertypulse');
define('DB_PASSWORD', '4(uRZHO51RDUhjiB');
define('DB_NAME', '4445469_propertypulse');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
