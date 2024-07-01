<?php
require '../Database/db_config.php';
require '../Model/verify_user.php'; 

$authenticator = new UserAuthenticator($link);

$username = $_POST['username'];
$password = $_POST['password'];

$user = $authenticator->verifyCredentials($username, $password);
if($user==0){
    $authenticator->initUserSession($username);
}elseif($user==1){
    $error_message ="Wrong Password.";
    $_SESSION["error_message"]=$error_message;
    header("Location: ../index.php");
}else{
    $error_message ="User not available please sign uop.";
    $_SESSION["error_message"]=$error_message;
    header("Location: ../index.php");
}

?>
