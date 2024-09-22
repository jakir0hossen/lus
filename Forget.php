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

//Load Composer's autoloader
require 'vendor/autoload.php';

$msg = "";
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conx, $_POST['email']);
    $CodeReset = mysqli_real_escape_string($conx, md5(rand()));
    if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conx, "UPDATE register SET CodeV='{$CodeReset}' WHERE email='{$email}'");
        if ($query) {
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jhbjakir@gmail.com';
                $mail->Password   = 'keaxyfvlxszsypaj';
                $mail->SMTPSecure = 'Tls';
                $mail->Port       = 587;
                $mail->setFrom('jhbjakir@gmail.com', 'Eagle');
                $mail->addAddress($email);
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Welecom To My Website';
                $mail->Body    = '<p> This is the Verifecation Link<b><a href="http://localhost:3000/change-Password.php?Reset=' . $CodeReset . '">"http://localhost:3000/change-Password.php?Reset=' . $CodeReset . '"</a></b></p>';
                //    '<p>This is the Verification Link: <b><a href="http://localhost:3000/?Verification='.$Code.'">Verify Here</a></b></p>';
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            $msg = "<div class='alert alert-info'>we've send a verification code on Your email Address</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>This email:'{$email}' don't found </div>";
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
    <title>Sign in & Sign up Form</title>
    <style>
        .alert {
            padding: 1rem;
            border-radius: 5px;
            color: white;
            margin: 1rem 0;
            font-weight: 500;
            width: 65%;
        }

        .alert-success {
            background-color: #42ba96;
        }

        .alert-danger {
            background-color: #fc5555;
        }

        .alert-info {
            background-color: #2E9AFE;
        }

        .alert-warning {
            background-color: #ff9966;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup" style="left: 50%;z-index:99;">
                <form action="" method="POST" class="sign-in-form">
                    <h2 class="title">Forget Password</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Email" />
                    </div>
                    <input type="submit" name="submit" value="Send" class="btn solid" />
                    <p class="social-text">Or Sign in with social platforms</p>
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

        
    </div>

    <script src="app.js"></script>
</body>

</html>
