<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h2>Error</h2>
    <p><?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "An unexpected error occurred."; ?></p>
    <p><a href="../index.php">Sign Up</a></p>
</body>
</html>
