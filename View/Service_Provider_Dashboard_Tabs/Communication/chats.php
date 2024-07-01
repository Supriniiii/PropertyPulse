<?php 
require_once "../../../Database/db_config.php";

session_start();

$ChatRoomID = $_GET['ChatRoomID'];
$_SESSION['chatRoomId'] = $ChatRoomID;

// Use prepared statements to avoid SQL injection
/*$stmt = $link->prepare("SELECT * FROM chatmessage WHERE ChatRoomID = ?");
    $stmt->bind_param("s", $ChatRoomID);
    $stmt->execute();
    $getMsg = $stmt->get_result();

    // Fetch all results if needed
    $messages = $getMsg->fetch_all(MYSQLI_ASSOC);

    // Close statement
    $stmt->close();*/
$id = $_SESSION["user_id"];
$getMsg = mysqli_query($link,"SELECT * FROM chatmessage WHERE ChatRoomID = $ChatRoomID");





$getMember = mysqli_query($link,"SELECT * FROM chatroom WHERE ChatRoomID = $ChatRoomID");

?>

<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8" />
                <title>chats</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<style>
body {
    background-color:#2a2a3e;
    font-family: Arial, sans-serif;
}

.chat-card {
    max-width: 800px;
    margin: 20px auto;
    background-color: #1b253d;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.chat-header {
    background-color: #28a745;
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
}

.chat-header h2 {
    margin: 0;
    flex-grow: 1;
    text-align: center;
}

.back .link {
    color: white;
    text-decoration: none;
}

.chat-container {
    height: 500px;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message-wrapper {
    display: flex;
    width: 100%;
}

.message-wrapper.left {
    justify-content: flex-end;
}

.message-wrapper.right {
    justify-content: flex-start;
}

.message {
    max-width: 70%;
    padding: 10px;
    border-radius: 10px;
    position: relative;
}

.message-wrapper.left .message {
    background-color: #4169E1;
}

.message-wrapper.right .message {
    background-color: #6cb6ff;
}

.username {
    display: block;
    font-size: 0.8em;
    color: white;
    margin-top: 5px;
}

.sentbar {
    padding: 15px;
    background-color: #28a745;
}

.sentbar form {
    display: flex;
    gap: 10px;
}

.sentbar input[type="text"] {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 20px;
}

.sentbar input[type="submit"] {
    padding: 10px 20px;                          
    background-color: green;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}
 .back-button {
    color: white;
    text-decoration: none;
    font-size: 20px;
    padding: 5px 10px;
    border-radius: 50%;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>
      
        </head>  

        <body>

<div class="chat-card">
    <div class="chat-header">
        <a class="back-button" href="../communications.php">
            <i class="fas fa-arrow-left"></i>
        </a>    
        <h2>
            <?php 
            $member = mysqli_fetch_assoc($getMember);
            if($member['Member'] != $_SESSION['user_username'] ){
                echo $member['Member'];   
            }else{
                echo $member['creator'];   
            }
            ?>
        </h2>
    </div>

    <div class="chat-container">
        <?php
        for($i = 1 ; $i<= mysqli_num_rows($getMsg);$i++)
        {
            $row = mysqli_fetch_assoc($getMsg);
            $getUsername = mysqli_query($link,"SELECT * FROM users WHERE UserID = {$row['UserID']}");
            $nam = mysqli_fetch_assoc($getUsername);
            
            if($nam['username'] != $_SESSION['user_username']){
        ?>
        <div class="message-wrapper left">
            <div class="message">
                <?php echo $row['MessageText']; ?>
                <span class="username">
                    from <?php echo $nam['username']; ?>
                </span>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="message-wrapper right">
            <div class="message">
                <?php echo $row['MessageText']; ?>
                <span class="username">
                    from <?php echo $nam['username']; ?>
                </span>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>

    <div class="sentbar">
        <form action="add_message.php" method="post">
            <input class="message" type="text" name="msg" placeholder="Type a message...">
            <input type="submit" value="Send">
        </form>
    </div>
</div>
        </body>


</html>