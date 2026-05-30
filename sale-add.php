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

    $product_query = "SELECT PNAME FROM product WHERE UID = ?";
    $product_stmt = $conn->prepare($product_query);
    $product_stmt->bind_param("i", $user_id);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {

        $date = $_POST['sdate'];
        $biller = $_POST['sbiller'];
        $product_name = $_POST['sproduct'];
        $customer = $_POST['scustname'];
        $tax = $_POST['stax'];
        $quantity = $_POST['squantity'];
        $status = $_POST['sstatus'];
        $totalpay = $_POST['stotalpay'];
        $paystatus = $_POST['spaystatus'];

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

        $insert_query = "INSERT INTO sale (UID, SLDATE, SLBILLER, SLPRODUCT, SLCUSTOMER, SLTAX, SLQUANTITY, SLSTATUS, SLTOTALPAY, SLPAYSTATUS, SLIMAGE) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("issssssssss", $user_id, $date, $biller, $product_name, $customer, $tax, $quantity, $status, $totalpay, $paystatus, $image_path);

        if ($insert_stmt->execute()) {
            $update_query = "UPDATE product SET PQUANTITY = PQUANTITY - ? WHERE PNAME = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("is", $quantity, $product_name);

            if ($update_stmt->execute()) {
                echo "Product quantity updated.";
            } else {
                header("Location: pages-error.html");
                echo "Error: " . $update_stmt->error;
            }
            header("Location: sale-list.php");
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
$page_title = "Add Sale";
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
                                    <h4 class="card-title">Add Sale</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sdate">Date *</label>
                                                <input type="date" class="form-control" id="sdate" name="sdate" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Biller *</label>
                                                <input type="text" name="sbiller" class="form-control"
                                                    placeholder="Enter Biller Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product *</label>
                                                <?php
                                                if ($product_result) {
                                                    echo '<select name="sproduct" class="selectpicker form-control" data-style="py-0">';
                                                    while ($product_row = mysqli_fetch_assoc($product_result)) {
                                                        echo '<option>' . $product_row['PNAME'] . '</option>';
                                                    }
                                                    echo '</select>';
                                                } else {
                                                    echo "Error fetching products: " . mysqli_error($conn);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer *</label>
                                                <input type="text" name="scustname" class="form-control"
                                                    placeholder="Enter Customer Name" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Tax *</label>
                                                <select name="stax" class="selectpicker form-control" data-style="py-0">
                                                    <option>No Tax</option>
                                                    <option>GST @5%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Quantity</label>
                                                <input type="text" name="squantity" class="form-control"
                                                    placeholder="Quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Attach Document</label>
                                                <input type="file" class="form-control image-file" name="pic"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sale Status *</label>
                                                <select name="sstatus" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Completed</option>
                                                    <option>Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total Payment *</label>
                                                <input type="text" name="stotalpay" class="form-control"
                                                    placeholder="Amount" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Payment Status *</label>
                                                <select name="spaystatus" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Pending</option>
                                                    <option>Due</option>
                                                    <option>Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Sale Note *</label>
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
                                    <button type="submit" name="add" class="btn btn-primary mr-2">Add Sale</button>
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