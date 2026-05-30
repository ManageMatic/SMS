<?php
session_start();
require_once 'includes/config.php';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->bind_result($user_id);

    $fetch_stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {

        $cstname = $_POST['cstname'];
        $cstemail = $_POST['cstemail'];
        $cstnumber = $_POST['cstnumber'];
        $cstaddress = $_POST['cstaddress'];
        $cstcity = $_POST['cstcity'];
        $cststate = $_POST['cststate'];

        $insert_query = "INSERT INTO customer(UID, CSTNAME, CSTEMAIL, CSTNUM, CSTADDRESS, CSTCITY, CSTSTATE) VALUES ( ? , ? , ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param('issssss', $user_id, $cstname, $cstemail, $cstnumber, $cstaddress, $cstcity, $cststate);

        if ($insert_stmt->execute()) {
            header("Location: customer-list.php");
            exit();
        } else {
            header("Location: pages-error.html");
            echo "Error: " . $insert_stmt->error;
        }
    }
} else {
    header("Location: auth-sign-in.php");
    exit();
}
mysqli_close($conn);
?>

<?php
$page_title = "Add Customers";
require_once 'includes/header.php';
?>

        <?php require_once 'includes/sidebar.php'; ?>
<?php require_once 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid add-form-list">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Add Customer</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input type="text" name="cstname" class="form-control"
                                                    placeholder="Enter Name" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email *</label>
                                                <input type="email" name="cstemail" class="form-control"
                                                    placeholder="Enter Email" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number *</label>
                                                <input type="text" name="cstnumber" class="form-control"
                                                    placeholder="Enter Phone Number" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="cstaddress" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>City *</label>
                                                <input type="text" name="cstcity" class="form-control"
                                                    placeholder="Enter City" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>State *</label>
                                                <input type="text" name="cststate" class="form-control"
                                                    placeholder="Enter State" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary mr-2">Add Customer</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <?php require_once 'includes/scripts.php'; ?>