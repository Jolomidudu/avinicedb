<?php
     
    if (isset($_POST["login"]))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
 
        // connect with database
       
        $conn = mysqli_connect("localhost", "gentlebo_myapp1", "MyJolomi97#", "gentlebo_myapp");
        
 
        // check if credentials are okay, and email is verified
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $result = mysqli_query($conn, $sql);
 
        if (mysqli_num_rows($result) == 0)
        {
            die("Email not found.");
        }
 
        $user = mysqli_fetch_object($result);
 
        if (!password_verify($password, $user->password))
        {
            die("Password is not correct");
        }
 
        if ($user->email_verified_at == null)
        {
            die("Please verify your email <a href='email-verification.php?email=" . $email . "'>from here</a>");
        }
 
        echo "<p>Your login logic here</p>";
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<br><br><br>
<div style="text-align: center;">
    <form method="POST">
    <input type="email" name="email" placeholder="Enter email" required /> <br><br>
    <input type="password" name="password" placeholder="Enter password" required /> <br><br>
 
    <input type="submit" name="login" value="Login">
</form><br><br>

<a href="register.php">Register Now</a>
</div>

</body>
</html>
