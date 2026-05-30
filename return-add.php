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

        $rdate = $_POST['rdate'];
        $rbiller = $_POST['rbiller'];
        $rcustomer = $_POST['rcustomer'];
        $rproduct = $_POST['rproduct'];
        $rtotal = $_POST['rtotal'];
        $rtax = $_POST['rgst'];

        $image_path = '';

        if (isset($_FILES['pic']) && $_FILES['pic']['error'] === 0) {
            $target_dir = "D:/xamp/htdocs/SMS/uploads/";
            $target_file = $target_dir . basename($_FILES["pic"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["pic"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
                $image_path = $target_file;
            }
        }

        $insert_query = "INSERT INTO returns (UID, RDATE, RBILLER, RCUSTOMER, RPRODUCT, RTOTAL, RGST, RIMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("isssssss", $user_id, $rdate, $rbiller, $rcustomer, $rproduct, $rtotal, $rtax, $image_path);

        if ($insert_stmt->execute()) {
            header("Location: return-list.php");
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
$page_title = "Add Return";
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
                                    <h4 class="card-title">Add Return</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pdate">Date *</label>
                                                <input type="date" class="form-control" id="pdate" name="rdate" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Biller *</label>
                                                <select name="rbiller" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Test Biller</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer *</label>
                                                <input type="text" name="rcustomer" class="form-control"
                                                    placeholder="Enter Customer Name" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product *</label>
                                                <input type="text" name="rproduct" class="form-control"
                                                    placeholder="Enter Product Name" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total *</label>
                                                <input type="text" name="rtotal" class="form-control"
                                                    placeholder="Enter Total" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Tax *</label>
                                                <select name="rgst" class="selectpicker form-control" data-style="py-0">
                                                    <option>No Tax</option>
                                                    <option>GST @5%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Attach Document</label>
                                                <input type="file" class="form-control image-file" name="pic"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Return Note *</label>
                                                <div id="quill-tool">
                                                    <button class="ql-bold" data-toggle="tooltip"
                                                        data-placement="bottom" title="Bold"></button>
                                                    <button class="ql-underline" data-toggle="tooltip"
                                                        data-placement="bottom" title="Underline"></button>
                                                    <button class="ql-italic" data-toggle="tooltip"
                                                        data-placement="bottom"
                                                        title="Add italic text <cmd+i>"></button>
                                                    <button class="ql-image" data-toggle="tooltip"
                                                        data-placement="bottom" title="Upload image"></button>
                                                    <button class="ql-code-block" data-toggle="tooltip"
                                                        data-placement="bottom" title="Show code"></button>
                                                </div>
                                                <div id="quill-toolbar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary mr-2">Add Returns</button>
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