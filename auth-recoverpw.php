<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
   $conn = mysqli_connect(hostname: "localhost", username: "root", password: "", database: "sms");

   if (!$conn) {
      die("Connection failed:" . mysqli_connect_error());
   }

   $email = $_POST['email'];

   $check_query = "SELECT * FROM store WHERE SEMAIL = ?";
   $check_stmt = $conn->prepare($check_query);
   $check_stmt->bind_param("s", $email);
   $check_stmt->execute();
   $result = $check_stmt->get_result();

   if ($result->num_rows > 0) {
      $otp = rand(100000, 999999);

      $insert_query = "UPDATE store SET OTP = ? WHERE SEMAIL = ?";
      $insert_stmt = $conn->prepare($insert_query);
      $insert_stmt->bind_param("is", $otp, $email);
      $insert_stmt->execute();

      $mail = new PHPMailer(true);
      try {
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'ishanmahida123@gmail.com';
         $mail->Password = 'lilfubmwxgqvpwmr';
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Port = 587;

         $mail->setFrom('ishanmahida123@gmail.com', 'Ishan Mahida');
         $mail->addAddress($email);

         $mail->isHTML(true);
         $mail->Subject = 'OTP for Password Reset';
         $mail->Body = 'Your OTP for password reset is: ' . $otp;

         $mail->send();
         header("Location: otp-verification.php");
         exit();
      } catch (Exception $e) {
         $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   } else {
      $error_message = "Email does not exist!";
   }

   mysqli_close($conn);
}
?>



<?php
$page_title = "Recover Password";
require_once 'includes/header.php';
?>
      <section class="login-content">
         <div class="container">
            <div class="row align-items-center justify-content-center height-self-center">
               <div class="col-lg-8">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-7 align-self-center">
                              <div class="p-3">
                                 <h2 class="mb-2">Reset Password</h2>
                                 <p>Enter your email address and we'll send you an email with instructions to reset your
                                    password.</p>
                                 <form action="" method="post">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" name="email"
                                                placeholder="">
                                             <label>Email</label>
                                          </div>
                                       </div>
                                    </div>
                                    <?php if (!empty($error_message)): ?>
                                       <p style="color: red;">
                                          <?php echo $error_message; ?>
                                       </p>
                                    <?php endif; ?>
                                    <button type="submit" name="submit" data-toggle="modal" data-target="#OTP"
                                       class="btn btn-primary">Send OTP</button>
                                 </form>
                              </div>
                           </div>
                           <div class="col-lg-5 content-right">
                              <img src="assets/images/login/01.png" class="img-fluid image-right" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
   <?php require_once 'includes/scripts.php'; ?>