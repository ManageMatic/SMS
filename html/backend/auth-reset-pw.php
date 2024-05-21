<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }

    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $update_query = "UPDATE store SET SPASS = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("s", $hashed_password);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        header("Location: auth-sign-in.php");
        exit();
    } else {
        $error_message = "Failed to update password. Please try again.";
    }

    mysqli_close($conn);
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password | ManageMatic | Store Management System</title>

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
                                            <h2 class="mb-2">Reset Password</h2>
                                            <p>Enter Your new password for reset.</p>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password"
                                                                name="pass" placeholder="">
                                                            <label>Reset Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password"
                                                                name="cpass" placeholder="">
                                                            <label>Confirm Reset Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (!empty($error_message)): ?>
                                                    <p style="color: red;">
                                                        <?php echo $error_message; ?>
                                                    </p>
                                                <?php endif; ?>
                                                <button type="submit" name="submit" data-toggle="modal"
                                                    data-target="#OTP" class="btn btn-primary">Reset</button>
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

    <script src="../assets/js/table-treeview.js"></script>

    <script src="../assets/js/customizer.js"></script>

    <script async src="../assets/js/chart-custom.js"></script>

    <script src="../assets/js/app.js"></script>
</body>

</html>