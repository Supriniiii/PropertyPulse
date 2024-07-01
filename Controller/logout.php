<?php
  session_start();

  unset($_SESSION['error_message']);
  unset($_SESSION['user_id']);
  unset($_SESSION['user_type']);
  unset($_SESSION['user_username']);

  header("Location: ../index.php");
?>