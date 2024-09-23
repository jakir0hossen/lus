<?php
session_start();
if (isset($_SESSION['Email_Session'])) {
    header("Location: Home.php");
    die();
}
include('config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$msg = "";
$Error_Pass = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conx, $_POST['Username']);
    $email = mysqli_real_escape_string($conx, $_POST['Email']);
    $Password = $_POST['Password'];
    $Confirm_Password = $_POST['Conf-Password'];
    $Code = mysqli_real_escape_string($conx, md5(rand()));

    // Email validation regex for Gmail, Yahoo, and University
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|lus\.ac\.bd)$/';
    if (!preg_match($emailPattern, $email)) {
        $msg = "<div class='alert alert-danger'>Invalid email format. Please use a valid Gmail, Yahoo, or university email.</div>";
    } else {
        // Password validation regex
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $Password)) {
            $msg = "<div class='alert alert-danger'>Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</div>";
            $Error_Pass = 'style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
        } else {
            $Password = mysqli_real_escape_string($conx, md5($Password));
            $Confirm_Password = mysqli_real_escape_string($conx, md5($Confirm_Password));

            if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register WHERE email='{$email}'")) > 0) {
                $msg = "<div class='alert alert-danger'>This Email: '{$email}' already exists.</div>";
            } else {
                if ($Password === $Confirm_Password) {
                    $query = "INSERT INTO register(`Username`, `email`, `Password`, `CodeV`) VALUES ('$name','$email','$Password','$Code')";
                    $result = mysqli_query($conx, $query);
                    if ($result) {
                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'jhbjakir@gmail.com'; // Your Gmail
                            $mail->Password = 'keaxyfvlxszsypaj'; // Your App Password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('jhbjakir@gmail.com', $name); // Sender
                            $mail->addAddress($email, $name); // Recipient
                            $mail->isHTML(true);
                            $mail->Subject = 'Welcome to My Website';
                            $mail->Body = '<p>This is the Verification Link: <b><a href="http://localhost:3000/SignIn.php?Verification='.$Code.'">http://localhost:3000/SignIn.php?Verification='.$Code.'</a></b></p>';
                            $mail->send();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                        $msg = "<div class='alert alert-info'>We've sent a verification code to your email address.</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
                    $Error_Pass = 'style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
                }
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign up</title>
   
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="Username" placeholder="Username" value="<?php if (isset($_POST['Username'])) {
                                                                                                echo $name;
                                                                                            } ?>" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="Email" placeholder="Email" value="<?php if (isset($_POST['Email'])) {
                                                                                        echo $email;
                                                                                    } ?>" />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Password" placeholder="Password" />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Conf-Password" placeholder="Confirm Password" />
                    </div>
                    <input type="submit" name="submit" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>LU Magazine</h3>
                    <p>Unlock personalized content, campus updates, and student-driven articles</p>
                    <a href="SignIn.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
                        Sign in
                                                                                </a>
                </div>
                <img src="../images/logo.png" class="image" alt="" />
            </div>
        </div>
    </div>
    </div>
</body>

</html>
