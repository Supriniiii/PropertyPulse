<?php
    require_once "../../../Database/db_config.php";

    session_start();

    // Get form data
    $otherUser = isset($_POST['otheruser']) ? $_POST['otheruser'] : '';
    $chatName = isset($_POST['chatname']) ? $_POST['chatname'] : '';
    $creator = $_SESSION['user_username'];


    $stmtChatRoom = $link->prepare("INSERT INTO chatroom (creator, Member, room_name) VALUES (?, ?, ?)");
    $stmtChatRoom->bind_param("sss", $creator, $otherUser, $chatName);


    try {
        // Execute the statements
        if ($stmtChatRoom->execute()) {
            // Success, redirect to homepage/index page
            $getgroupDetails = mysqli_query($link,"SELECT * FROM chatroom WHERE creator LIKE '{$creator}' AND Member LIKE '$otherUser' AND room_name LIKE '$chatName'");
            if(mysqli_num_rows($getgroupDetails) >0){
                $row = mysqli_fetch_assoc($getgroupDetails);
                //$_SESSION['groudId'] = $row['ChatRoomID'];
                //echo  $row['ChatRoomID'];
            }
            
            header("Location: ../communications.php");
        } else {
            echo "Error creating a group chat: " . $stmtChatRoom->error;
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "An error occurred: " . $e->getMessage();
    }



?>