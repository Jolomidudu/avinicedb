<?php
include('server.php');
include('dbo.php');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


if(isset($_POST["email"]) && (!empty($_POST["email"]))){
  $email = $_POST["email"];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!$email) {
     $error .="<p>Invalid email address please type a valid email address!</p>";
     }else{
     $sel_query = "SELECT * FROM `customers` WHERE email='".$email."'";
     $results = mysqli_query($con,$sel_query);
     $row = mysqli_num_rows($results);

     if ($row==""){
     $error .= "<p>No user is registered with this email address!</p>";
     }
    }
     if($error!=""){
     echo "<div class='error'>".$error."</div>
     <br /><a href='javascript:history.go(-1)'>Go Back</a>";
     }else{
     $expFormat = mktime(
     date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
     $expDate = date("Y-m-d H:i:s",$expFormat);
    //  $key = md5(2418*2+$email);
     $key = md5($email);
     $addKey = substr(md5(uniqid(rand(),1)),3,10);
     $key = $key . $addKey;


  // Insert Temp Table
  mysqli_query($con,
  "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
  VALUES ('".$email."', '".$key."', '".$expDate."');");



 $output='<p>Dear Avinice user,</p>';
 $output.='<p>Please click on the following link to reset your password.</p>';
 $output.='<p>-------------------------------------------------------------</p>';
 $output.='<p><a href="https://app.avinice.com.ng/reset_password.php?
 key='.$key.'&email='.$email.'&action=reset" target="_blank">
 https://app.avinice.com.ng/reset_password.php
 ?key='.$key.'&email='.$email.'&action=reset</a></p>';		
 $output.='<p>-------------------------------------------------------------</p>';
 $output.='<p>Please be sure to copy the entire link into your browser.
 The link will expire after 1 day for security reason.</p>';
 $output.='<p>If you did not request this forgotten password email, no action 
 is needed, your password will not be reset. However, you may want to log into 
 your account and change your security password as someone may have guessed it.</p>';   	
 $output.='<p>Thanks,</p>';
 $output.='<p>Avinice Logistics</p>';
 $body = $output; 
 $subject = "Password Recovery - Avinice.com.ng";
 
 $email_to = $email;
 $fromserver = "app@avinice.com.ng"; 
//  require("PHPMailer/PHPMailerAutoload.php");
 require("vendor/autoload.php");
 $mail = new PHPMailer();
 $mail->IsSMTP();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
 $mail->Host = "mail.avinice.com.ng"; // Enter your host here
 $mail->SMTPAuth = true;
 $mail->Username = "app@avinice.com.ng"; // Enter your email here
 $mail->Password = "Avinice23!20LS"; //Enter your password here
 $mail->Port = 465;
 $mail->IsHTML(true);
 $mail->From = "app@avinice.com.ng";
 $mail->FromName = "Avinice Logistics";
 $mail->Sender = $fromserver; // indicates ReturnPath header
 $mail->Subject = $subject;
 $mail->Body = $body;
 $mail->AddAddress($email_to);
 if(!$mail->Send()){
 echo "Mailer Error: " . $mail->ErrorInfo;
 }else{
 echo "<div class='error'>
 <p>An email has been sent to you with instructions on how to reset your password.</p>
 </div><br /><br /><br />";
   }
    }


   
  }
  //  else if($error!=""){
  //  echo "<div class='error'>".$error."</div>
  //  <br /><a href='javascript:history.go(-1)'>Go Back</a>";
  //  }
  




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Forgot-password | Avinice
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/akada-dashboard.css?v=3.0.4" rel="stylesheet" />
  <style>

  .w-100 {
    width: 60% !important;
    height: 35%;
  }
.core_img {
  width: 30%;"
  height:100px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  
}


  
  </style>
</head>

<body class="bg-gray-200">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <!-- <div class="page-header align-items-start min-vh-100" style="background-image: url('assets/img/home.jpg');"> -->
    <!-- <div class="page-header align-items-start min-vh-100" style="background-image: url('assets/img/dash.jpg');"> -->
    <div class="page-header align-items-start min-vh-100" style="background-color:lightgray;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div style="border-radius: 20px;" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" >
                <div style="border: 1px solid #dddddd; border-radius:20px;" class="border-radius-lg py-3 pe-1" >
                <img src="assets/img/mainer.png" class="core_img" alt="logo">
              <p style="text-align: center;"class="mb-0">Logistics Services Ltd</p><br>
                  
                  
                </div>
                <br>

              
                
              </div>
              <h6 class="text-dark font-weight-bolder text-center mt-2 mb-0">Forgot Password ?</h6>
              <div class="card-body">
              
              

                

                <form  class="text-start" method="post" action="forgotpassword.php">
          <?php include('errors.php'); ?>

              
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Enter Your Email</label>
                    <input type="email" id="email" name="email" class="form-control">
                  </div>
                  
                  
                  <div class="text-center">
                    <button type="submit" class="bg-gradient-primary btn w-100 my-4 mb-2" name="reset-password">Submit</button>
                    
                  </div><br>
                  <p style="font-size:14px; text-align:center;" class="font-weight-medium">
                    Remember Your login details?  <a href="./" style="font-size: 13px" class="font-weight-bold">Login</a>
                   </p>
                  <p style="text-align: center;">
                 
                   
                    </p>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>

