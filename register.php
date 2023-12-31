<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

//  use PHPMailer\PHPMailer-master\src\Exception;
//  use PHPMailer\PHPMailer-master\src\SMTP;
//  use PHPMailer\PHPMailer-master\src\PHPMailer;
    
 
    //Load Composer's autoloader
    require 'vendor/autoload.php';
 
    if (isset($_POST["register"]))
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
 
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
 
        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
 
            //Send using SMTP
            $mail->isSMTP();
 
            //Set the SMTP server to send through
            $mail->Host = 'mail.gentleboard.org';
 
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
 
            //SMTP username
            $mail->Username = 'app@gentleboard.org';
            // $mail->Username = 'jollofdudu@gmail.com';
 
            //SMTP password
            $mail->Password = 'MyJolomi97#';
 
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->SMTPSecure = "ssl";
 
            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            // $mail->Port = 587;
            $mail->Port = 465;
 
            //Recipients
            $mail->setFrom('app@gentleboard.org', 'Myer Logistics Ltd');
            
             
 
            //Add a recipient
            $mail->addAddress($email, $name);
 
            //Set email format to HTML
            $mail->isHTML(true);
 
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
 
            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
 
            $mail->send();
            // echo 'Message has been sent';
 
            $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
 
            // connect with database

            $conn = mysqli_connect("localhost", "gentlebo_myapp1", "MyJolomi97#", "gentlebo_myapp");


 
            // insert in users table
            $sql = "INSERT INTO users(name, email, password, verification_code, email_verified_at) VALUES ('" . $name . "', '" . $email . "', '" . $encrypted_password . "', '" . $verification_code . "', NULL)";
            mysqli_query($conn, $sql);
 
            header("Location: email_verification.php?email=" . $email);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <br><br><br>
    <div style="text-align:center;">
        
        <form method="POST">
    <input type="text" name="name" placeholder="Enter name" required /> <br><br>
    <input type="email" name="email" placeholder="Enter email" required /><br><br>
    <input type="password" name="password" placeholder="Enter password" required /><br><br>
 
    <input type="submit" name="register" value="Register">
</form><br><br>

<a href="./">Back to login</a>
        
    </div>

</body>
</html>
