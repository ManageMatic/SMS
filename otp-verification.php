<?php
session_start();
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }

    $entered_otp = $_POST['otp'];

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



<?php
$page_title = "OTP Verification";
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
                                            <h2 class="mb-2">OTP Verification</h2>
                                            <p>Enter your OTP, we'll send you an email.</p>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="otp"
                                                                name="otp" placeholder="Enter OTP!">
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