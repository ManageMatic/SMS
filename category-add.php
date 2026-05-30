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
        
        $product_name = $_POST['cpname'];
        $category = $_POST['cname'];
        $code = $_POST['ccode'];

        $insert_query = "INSERT INTO category (UID, CIMAGE, CPNAME, CNAME, CCODE) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("issss", $user_id, $image_path, $product_name, $category, $code);

        if ($insert_stmt->execute()) {
            header("Location: category-list.php");
            exit();
        } else {
            header("Location: pages-error.html");
            echo "Error: " . $insert_stmt->error;
        }
    }

    mysqli_close($conn);
}
?>

<?php
$page_title = "Add Category";
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
                                    <h4 class="card-title">Add category</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" class="form-control image-file" name="pic"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Product Name *</label>
                                                <input type="text" name="cpname" class="form-control" placeholder="Enter Product Name"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category *</label>
                                                <input type="text" name="cname" class="form-control" placeholder="Enter Category"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Code *</label>
                                                <input type="text" name="ccode" class="form-control" placeholder="Enter Code"
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="add" id="add">Add category</button>
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