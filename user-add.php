<?php
session_start();
$path_prefix = "";
require_once $path_prefix . 'includes/config.php';

$admin_name = '';
$admin_email = '';

if (isset($_SESSION['admin_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_SESSION['admin_user'];
    $fetch_query = "SELECT ANAME, AEMAIL FROM admin WHERE AEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($admin_name, $admin_email);
        $fetch_stmt->fetch();
    }

}

if (isset($_POST['add'])) {
    $name = $_POST['sname'];
    $storename = $_POST['stname'];
    $email = $_POST['semail'];
    $phone = $_POST['sphone'];
    $bdate = $_POST['sbdate'];
    $address = $_POST['saddress'];

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

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
        $insert_query = "INSERT INTO store (SNAME, STNAME, SEMAIL, SPHONE, SBDATE, SADDRESS) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ssssss", $name, $storename, $email, $phone, $bdate, $address);

        if ($insert_stmt->execute()) {
            header("location: user-list.php");
            exit();
        } else {
            echo "";
        }
    }

    mysqli_close($conn);

}
?>

<?php
$page_title = "Add User";
require_once $path_prefix . 'includes/header.php';
?>
        <?php require_once $path_prefix . 'includes/sidebar.php'; ?>
<?php require_once $path_prefix . 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Add User</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="new-user-info">
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input type="text" name="sname" class="form-control"
                                                    placeholder="Enter name">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Store Name *</label>
                                                <input type="text" name="stname" class="form-control"
                                                    placeholder="Enter store name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email *</label>
                                                <input type="text" name="semail" class="form-control"
                                                    placeholder="Enter email">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile *</label>
                                                <input type="text" name="sphone" class="form-control"
                                                    placeholder="Enter mobile no.">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pdate">B'Date *</label>
                                                <input type="date" class="form-control" id="sbdate" name="sbdate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address *</label>
                                                <input type="text" name="saddress" class="form-control"
                                                    placeholder="Enter Address">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="add">Add New User</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php require_once $path_prefix . 'includes/footer.php'; ?>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>