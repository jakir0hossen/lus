<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['Email_Session'])) {
    header("Location: index.php"); // Redirect to signup/login page if not logged in
    exit();
}

// Retrieve the user's email from the session
$user_email = $_SESSION['Email_Session'];

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to signup/login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_email); ?>!</h1>
        <p>You are successfully logged in.</p>
        
        <form action="" method="POST">
            <input type="submit" name="logout" value="Logout" class="btn">
        </form>
    </div>
</body>
</html>
