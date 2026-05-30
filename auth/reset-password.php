<?php
session_start();
$path_prefix = "../";
require_once $path_prefix . 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

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
        header("Location: sign-in.php");
        exit();
    } else {
        $error_message = "Failed to update password. Please try again.";
    }

    mysqli_close($conn);
}
?>


<?php
$page_title = "Reset Password";
require_once $path_prefix . 'includes/header.php';
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
                                        <img src="<?php echo $path_prefix; ?>assets/images/login/01.png" class="img-fluid image-right" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>
