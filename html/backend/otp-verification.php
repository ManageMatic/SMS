<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }

    // Retrieve OTP from the form
    $entered_otp = $_POST['otp'];

    // Check if the entered OTP exists in the database
    $check_query = "SELECT * FROM store WHERE OTP = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $entered_otp);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: auth-reset-pw.php");
        exit();
    } else {
        $error_message = "Incorrect OTP. Please try again.";
    }

    mysqli_close($conn);
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OTP Verification | ManageMatic | Store Management System</title>

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
                                            <h2 class="mb-2">OTP Verification</h2>
                                            <p>Enter your OTP, we'll send you an email.</p>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="otp"
                                                                name="otp" placeholder="">
                                                            <label>OTP</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (!empty($error_message)): ?>
                                                    <p style="color: red;">
                                                        <?php echo $error_message; ?>
                                                    </p>
                                                <?php endif; ?>
                                                <button type="submit" name="submit" class="btn btn-primary">Verify
                                                    OTP</button>
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