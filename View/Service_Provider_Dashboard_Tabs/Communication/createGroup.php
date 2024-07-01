<?php
require_once "../../../Database/db_config.php";

session_start();
//Select all users who are service workers and property owners
$getUsers = mysqli_query($link,"SElECT * FROM users WHERE userType = 'service_worker' OR userType = 'property_owner'");




?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8" />
                <title>Create a group chat</title>
                <style>
                        body {
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                margin: 0;
                                padding: 0;
                                background-color: #1a1a2e; /* Twilight background color */
                        }

                        .centre{
                                display: flex;
                                align-items: center;
                                justify-content: center;
                        }
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

                        p{
                                color: #6cb6ff;
                        }

                        input[type="text"],select,option,
                        input[type="submit"] {
                                width: 100%;
                                padding: 10px;
                                margin: 8px 0;
                                display: inline-block;
                                border: 1px solid #4f4f7a; /* Adjusted border color */
                                border-radius: 4px;
                                box-sizing: border-box;
                                background-color: #3a3a4e; /* Adjusted input background color */
                                color: #fff; /* Adjusted text color */
                        }

                        input[type="submit"] {
                                background-color: #28a745;
                                cursor: pointer;
                                transition: background-color 0.3s ease-in-out;
                        }

                        input[type="submit"]:hover {
                                background-color: #218838;
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
                        <span class="back">
                                <a class="link" href="../communications.php">back</a>

                        </span>

                        <h2>
                                Create a group chat 
                        </h2>

                        <div class="centre">
                                <?php //echo mysqli_num_rows($getUsers);  ?>
                                <form action="db_create_group.php" method="post">
                                        <table>
                                                <tr>
                                                        <td>
                                                                <select name = "otheruser">
                                                                        <option SELECTED >-select a user-</option>
                                                                        <?php for($i = 1; $i<= mysqli_num_rows($getUsers);$i++){  
        																	$row =  mysqli_fetch_assoc($getUsers);
                                                                        ?>

                                                                        <option value="<?php echo $row['username'] ;?>"><?php echo $row['username'];?></option>

                                                                        <?php }?>
                                                                </select>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td>
                                                                <input name="chatname" type="text" placeholder="Enter the group chat name" required>
                                                        </td>
                                                </tr>

                                                <tr>
                                                        <td>
                                                                <input type="submit" value="Create">
                                                        </td>
                                                </tr>
                                        </table>
                                </form>
                        </div>
                        <p>
                                <!--Click <a class="link" href="user.php">here</a> to get all the users in th system.-->
                        </p>
                </div>


                <script src="">



                </script>

        </body>


</html>  
