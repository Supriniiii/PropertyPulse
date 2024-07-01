<?php
     require_once "../../../Database/db_config.php";

     session_start();

     $msg = isset($_POST['msg']) ? $_POST['msg'] : '';



     $stmtmsg = $link->prepare("INSERT INTO chatmessage ( ChatRoomID, UserID, MessageText) VALUES (?, ?, ?)");
     $stmtmsg->bind_param("sss", $_SESSION['chatRoomId'], $_SESSION['user_id'], $msg);

    try {
        // Execute the statements
        if ($stmtmsg->execute()) {
            // Success, redirect to homepage/index page
        	$abx=$_SESSION['chatRoomId'];
            header("Location: chats.php?ChatRoomID=$abx");
        } else {
            echo "Error adding user/tenant: " . $stmtChatRoom->error;
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "An error occurred: " . $e->getMessage();
    }


?>