<?php
session_start();

$login_error = '';

if (isset($_POST['signIn'])) {
   $aemail = $_POST['signupEmail'];
   $password = $_POST['signupSpass'];

   $conn = mysqli_connect("localhost", "smsuser", "test123", "sms");

   if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
   }

   $admin_check_query = "SELECT AID, APASS FROM admin WHERE AEMAIL=? LIMIT 1";
   $admin_check_stmt = $conn->prepare($admin_check_query);
   $admin_check_stmt->bind_param("s", $aemail);
   $admin_check_stmt->execute();
   $admin_check_stmt->store_result();

   if ($admin_check_stmt->num_rows > 0) {
      $admin_check_stmt->bind_result($storedAID, $storedPassword);
      $admin_check_stmt->fetch();

      if ($password === $storedPassword) {
         $_SESSION['admin_user'] = $aemail;
         header("location: admin-dashboard.php");
         exit();
      } else {
         $login_error = "Invalid email or password";
      }
   } else {
      $store_check_query = "SELECT SID, SPASS FROM store WHERE SEMAIL=? LIMIT 1";
      $store_check_stmt = $conn->prepare($store_check_query);
      $store_check_stmt->bind_param("s", $aemail);
      $store_check_stmt->execute();
      $store_check_stmt->store_result();

      if ($store_check_stmt->num_rows > 0) {
         $store_check_stmt->bind_result($storedSID, $storedPassword);
         $store_check_stmt->fetch();

         if (password_verify($password, $storedPassword)) {
            $_SESSION['login_user'] = $aemail;
            header("location: dashboard.php");
            exit();
         } else {
            $login_error = "Invalid email or password";
         }
      } else {
         $login_error = "Email does not exist";
      }
   }

   mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Sign In | ManageMatic | Store Management System</title>
   <link rel="shortcut icon" href="../assets/images/favicon.ico" />
   <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
   <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
   <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
   <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">
</head>

<body class=" ">

   <div id="loading">
      <div id="loading-center">
      </div>
   </div>

   <div class="wrapper">
      <section class="login-content">
         <div class="container">
            <div class="row align-items-center justify-content-center height-self-center">
               <div class="col-lg-8">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-7 align-self-center">
                              <div class="p-3">
                                 <h2 class="mb-2">Sign In</h2>
                                 <p>Login to stay connected.</p>
                                 <form action="" method="post">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" name="signupEmail"
                                                id="signupEmail" required>
                                             <label>Email</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password"
                                                name="signupSpass" id="signupSpass" required>
                                             <label>Password</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="custom-control custom-checkbox mb-3">
                                             <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                required>
                                             <label class="custom-control-label control-label-1"
                                                for="customCheck1">Remember Me</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <a href="auth-recoverpw.php" class="text-primary float-right">Forgot
                                             Password?</a>
                                       </div>
                                    </div>
                                    <?php if (!empty($login_error)): ?>
                                       <p style="color: red;">
                                          <?php echo $login_error; ?>
                                       </p>
                                    <?php endif; ?>
                                    <button type="submit" name="signIn" id="signIn" class="btn btn-primary">Sign
                                       In</button>
                                    <p class="mt-3">
                                       Create an Account <a href="auth-sign-up.php" class="text-primary">Sign Up</a>
                                    </p>
                                 </form>
                              </div>
                           </div>
                           <div class="col-lg-5 content-right">
                              <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>

   <script src="../assets/js/backend-bundle.min.js"></script>

   <script src="../assets/js/customizer.js"></script>

   <script async src="../assets/js/chart-custom.js"></script>

   <script src="../assets/js/app.js"></script>
</body>

</html>