<?php
    require_once "../../../Database/db_config.php";

    session_start();
    //Select all users who are service workers and property owners
    $getUsers = mysqli_query($link,"SElECT * FROM users WHERE userType like 'tenant' OR userType like 'property_owner'");
    

    

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create a group chat</title>
    <style>
    .container {
      width: 100%;
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      background-color: #2a2a3e; /* Adjusted background color */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
      
    }

    h2 {
      text-align: center;
      color: #6cb6ff; /* Adjusted text color */
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #1a1a2e; /* Twilight background color */
    }

    .users{
        height: 200px;
        width: 100%;
        max-width: 700px;
        overflow-y: auto;
    }
    .back{
        display: flex;
        justify-content: flex-end;
        align-content: top;
    }
    .link{
        color: #6cb6ff;
        text-decoration: none;
    }
    .link:hover{
        color: blueviolet;
    }

    </style>
  </head>

  <body>
    <div class="container">
        <div>
            <span class="back">
                <a class="link" href="createGroup.php">back</a>
            </span> 

            <h2>Usernames</h2>
        </div>
        <div class="users">
        
            <table>
                        
                
                <?php for($i = 1 ; $i<= mysqli_num_rows($getUsers);$i++){
                    $row = mysqli_fetch_assoc($getUsers);
                ?>   
                    
                    <tr>
                        <td>
                            <?php echo $row['username'];?>
                        </td>
                    </tr>

                <?php
                    }
                
                ?>
            </table>
        </div>
        
    </div>
    
  </body>
</html>