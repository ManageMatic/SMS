<?php
session_start();

$name = '';
$store_name = '';
$email = '';
$phone = '';
$bdate = '';
$staddress = '';
$sid = '';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

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
            header("Location: user-profile.php");
            exit();
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }

        mysqli_close($conn);
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Profile | ManageMatic | Store Management System</title>

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
    <script src="../assets/js/backend-bundle.min.js"></script>

    <script src="../assets/js/table-treeview.js"></script>

    <script src="../assets/js/customizer.js"></script>

    <script async src="../assets/js/chart-custom.js"></script>

    <script src="../assets/js/app.js"></script>
</body>

</html>