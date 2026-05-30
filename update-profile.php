<?php
session_start();
$path_prefix = "";
require_once $path_prefix . 'includes/config.php';

$name = '';
$store_name = '';
$email = '';
$phone = '';
$bdate = '';
$staddress = '';
$sid = '';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID, SNAME, STNAME, SEMAIL, SPHONE, SBDATE, SADDRESS FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($sid, $name, $store_name, $email, $phone, $bdate, $staddress); // Add $sid here
        $fetch_stmt->fetch();
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {

        $name = $_POST['sname'];
        $store_name = $_POST['stname'];
        $email = $_POST['semail'];
        $phone = $_POST['sphone'];
        $bdate = $_POST['sbdate'];
        $staddress = $_POST['saddress'];

        $update_query = "UPDATE store SET SNAME=?, STNAME=?, SEMAIL=?, SPHONE=?, SBDATE=?, SADDRESS=? WHERE SID = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssssssi", $name, $store_name, $email, $phone, $bdate, $staddress, $sid); // Use 'i' for integer type SID
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            header("Location: profile.php");
            exit();
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }

        mysqli_close($conn);
    }
}
?>


<?php
$page_title = "Update Profile";
require_once $path_prefix . 'includes/header.php';
?>
        <div class="card-body">
            <div class="p-3">
                <h2 class="mb-2">Update Your Profile!</h2>
                <p>Enter Your details.</p>
            </div>
            <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="sname" class="form-control" value="<?php echo $name ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Store Name *</label>
                            <input type="text" name="stname" class="form-control" value="<?php echo $store_name ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="text" name="semail" class="form-control" value="<?php echo $email ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobile *</label>
                            <input type="text" name="sphone" class="form-control" value="<?php echo $phone ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pdate">Date *</label>
                            <input type="date" class="form-control" id="sbdate" name="sbdate" required
                                value="<?php echo $bdate ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address *</label>
                            <input type="text" name="saddress" class="form-control" placeholder="Enter Address" required
                                value="<?php echo $staddress ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="add" id="add">Save</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>