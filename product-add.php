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

    $category_query = "SELECT CNAME FROM category WHERE UID=?";
    $category_stmt = $conn->prepare($category_query);
    $category_stmt->bind_param("i", $user_id);
    $category_stmt->execute();
    $category_result = $category_stmt->get_result();

    $categories = array();

    if ($category_result->num_rows > 0) {
        while ($row = $category_result->fetch_assoc()) {
            $categories[] = $row['CNAME'];
        }
        $categories = array_unique($categories);
    } else {
        echo "No categories found for this user.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $name = $_POST['pname'];
        $code = $_POST['pcode'];
        $category = $_POST['pcategory'];
        $cost = $_POST['pcost'];
        $price = $_POST['pprice'];
        $quantity = $_POST['pquantity'];
        $description = $_POST['pdesc'];

        $image_path = '';

        if (isset($_FILES['pimage']) && $_FILES['pimage']['error'] === 0) {
            $target_dir = "D:/xamp/htdocs/SMS/uploads/";
            $target_file = $target_dir . basename($_FILES["pimage"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["pimage"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["pimage"]["tmp_name"], $target_file);
                $image_path = $target_file;
            }
        }

        $insert_query = "INSERT INTO product (UID, PNAME, PCODE, PCATEGORY, PCOST, PPRICE, PQUANTITY, PDESC, PIMAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("issssssss", $user_id, $name, $code, $category, $cost, $price, $quantity, $description, $image_path);

        if ($insert_stmt->execute()) {
            header("Location: product-list.php");
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
$page_title = "Add Product";
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
                                    <h4 class="card-title">Add Product</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input type="text" name="pname" id="pname" class="form-control"
                                                    placeholder="Enter Name" data-errors="Please Enter Name." required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Code *</label>
                                                <input type="text" name="pcode" id="pcode" class="form-control"
                                                    placeholder="Enter Code" data-errors="Please Enter Code." required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Code *</label>
                                            <select name="pcategory" class="selectpicker form-control"
                                                data-style="py-0">
                                                <option>Select Category</option>
                                                <?php
                                                foreach ($categories as $category) {
                                                    echo '<option value="' . $category . '">' . $category . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cost *</label>
                                                <input type="text" name="pcost" id="pcost" class="form-control"
                                                    placeholder="Enter Cost" data-errors="Please Enter Cost." required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price *</label>
                                                <input type="text" name="pprice" id="pprice" class="form-control"
                                                    placeholder="Enter Price" data-errors="Please Enter Price."
                                                    required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Quantity *</label>
                                                <input type="text" name="pquantity" id="pquantity" class="form-control"
                                                    placeholder="Enter Quantity" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" name="pimage" id="pimage"
                                                    class="form-control image-file">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description / Product Details</label>
                                                <textarea class="form-control" name="pdesc" id="pdesc"
                                                    rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="add" id="add">Add
                                        Product</button>
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