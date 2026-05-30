<?php
session_start();
require_once 'includes/config.php';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->bind_result($user_id);
    
    $fetch_stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {

        $spcompname = $_POST['spcomname'];
        $spname = $_POST['spname'];
        $spemail = $_POST['spemail'];
        $spnumber = $_POST['spnumber'];
        $spgst = $_POST['spgst'];
        $spaddress = $_POST['spaddress'];
        $spcity = $_POST['spcity'];
        $spstate = $_POST['spstate'];
        $spcountry = $_POST['spcountry'];

        $insert_query = "INSERT INTO supplier (UID, SPCOMPNAME, SPNAME, SPEMAIL, SPNUMBER, SPGST, SPADD, SPCITY, SPSTATE, SPCOUNTRY) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("isssssssss", $user_id, $spcompname, $spname, $spemail, $spnumber, $spgst, $spaddress, $spcity, $spstate, $spcountry);

        if ($insert_stmt->execute()) {
            header("Location: supplier-list.php");
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
$page_title = "Add Supplier";
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
                                    <h4 class="card-title">Add Supplier</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Name *</label>
                                                <input type="text" name="spcomname" class="form-control" placeholder="Enter Name"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input type="text" name="spname" class="form-control" placeholder="Enter Name"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email *</label>
                                                <input type="text" name="spemail" class="form-control" placeholder="Enter Email"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number *</label>
                                                <input type="text" name="spnumber" class="form-control" placeholder="Enter Phone Number"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>GST Number *</label>
                                                <input type="text" name="spgst" class="form-control" placeholder="Enter GST Number"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="spaddress" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>City *</label>
                                                <input type="text" name="spcity" class="form-control" placeholder="Enter City"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>State *</label>
                                                <input type="text" name="spstate" class="form-control" placeholder="Enter State"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Country *</label>
                                                <input type="text" name="spcountry" class="form-control" placeholder="Enter Country"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary mr-2">Add Supplier</button>
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