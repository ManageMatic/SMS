<?php
session_start();

$signup_error = '';

if (isset($_POST['submitSignup'])) {
    $fullname = $_POST['signupSname'];
    $storename = $_POST['signupSTname'];
    $email = $_POST['signupEmail'];
    $phone = $_POST['signupPhone'];
    $password = $_POST['signupSpass'];
    $confirm_password = $_POST['signupSCpass'];

    if ($password !== $confirm_password) {
        $signup_error = "Passwords do not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $conn = mysqli_connect("localhost", "root", "", "sms");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $check_query = "SELECT SNAME FROM store WHERE SNAME=? OR SEMAIL=? LIMIT 1";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ss", $storename, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $signup_error = "Store Name or Email is already registered";
        } else {
            $insert_query = "INSERT INTO store (SNAME, STNAME, SEMAIL, SPHONE, SPASS) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sssss", $fullname, $storename, $email, $phone, $hashed_password);

            if ($insert_stmt->execute()) {
                $_SESSION['login_user'] = $storename;
                header("location: auth-sign-in.php");
                exit();
            } else {
                $signup_error = "Error creating user. Please try again later.";
            }
        }

        mysqli_close($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up | ManageMatic | Store Management System</title>

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
                                            <h2 class="mb-2">Sign Up</h2>
                                            <p>Create your ManageMatic account.</p>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupSname" id="signupSname" type="text"
                                                                required>
                                                            <label>Full Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupSTname" id="signupSTname" type="text"
                                                                required>
                                                            <label>Store Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupEmail" id="signupEmail" type="email"
                                                                required>
                                                            <label>Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupPhone" id="signupPhone" type="text"
                                                                required>
                                                            <label>Phone No.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupSpass" id="signupSpass" type="password"
                                                                required>
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control"
                                                                name="signupSCpass" id="signupSCpass" type="password"
                                                                required>
                                                            <label>Confirm Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck1" required>
                                                            <label class="custom-control-label" for="customCheck1">I
                                                                agree with the
                                                                terms of use</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (!empty($signup_error)): ?>
                                                    <p style="color: red;">
                                                        <?php echo $signup_error; ?>
                                                    </p>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary" name="submitSignup">Sign
                                                    Up</button>
                                                <p class="mt-3">
                                                    Already have an Account <a href="auth-sign-in.php"
                                                        class="text-primary">Sign
                                                        In</a>
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