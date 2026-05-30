<?php
session_start();
$path_prefix = "../";
require_once $path_prefix . 'includes/config.php';

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

    $fetch_query1 = "SELECT * FROM supplier WHERE UID = ?";
    $fetch_stmt = $conn->prepare($fetch_query1);
    $fetch_stmt->bind_param("i", $user_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {

        $date = $_POST['pdate'];
        $purchase_product = $_POST['pproduct'];
        $supplier = $_POST['psupplier'];
        $receive = $_POST['preceive'];
        $tax = $_POST['ptax'];
        $quantity = $_POST['pquantity'];
        $paystatus = $_POST['ppaystatus'];
        $payment = $_POST['ppay'];

        $insert_query = "INSERT INTO purchase(UID, PRDATE, PRPRODUCT, PRSUPPLIER, PRRECEIVE, PRTAX, PRQUANTITY, PRPAYSTATUS, PRPAYMENT) VALUES ( ? , ? , ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param('issssssss', $user_id, $date, $purchase_product, $supplier, $receive, $tax, $quantity, $paystatus, $payment);

        if ($insert_stmt->execute()) {
            $update_query = "UPDATE product SET PQUANTITY = PQUANTITY + ? WHERE PNAME = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("is", $quantity, $purchase_product);

            if ($update_stmt->execute()) {
                echo "Product quantity updated.";
            } else {
                echo "Error: " . $update_stmt->error;
            }
            header("Location: list.php");
            exit();
        } else {
            echo "Error: " . $insert_stmt->error;
        }

    }
} else {
    header("Location: " . $path_prefix . "auth/sign-in.php");
    exit();
}
mysqli_close($conn);
?>

<?php
$page_title = "Add Purchase";
require_once $path_prefix . 'includes/header.php';
?>
        <?php require_once $path_prefix . 'includes/sidebar.php'; ?>
<?php require_once $path_prefix . 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid add-form-list">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Add Purchase</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pdate">Date *</label>
                                                <input type="date" class="form-control" id="pdate" name="pdate" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product *</label>
                                                <input type="text" name="pproduct" class="form-control"
                                                    placeholder="Product" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <select name="psupplier" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Select Supplier</option>
                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<option>" . $row["SPCOMPNAME"] . ", " . $row["SPNAME"] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option>No suppliers found</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Received</label>
                                                <select name="preceive" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Received</option>
                                                    <option>Not received yet</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Tax</label>
                                                <select name="ptax" class="selectpicker form-control" data-style="py-0">
                                                    <option>No Tax</option>
                                                    <option>GST @5%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="text" name="pquantity" class="form-control"
                                                    placeholder="Quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Status *</label>
                                                <select name="ppaystatus" class="selectpicker form-control"
                                                    data-style="py-0">
                                                    <option>Paid</option>
                                                    <option>Pending</option>
                                                    <option>Due</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment *</label>
                                                <input type="text" name="ppay" class="form-control"
                                                    placeholder="Payment" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Note *</label>
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
                                    <button type="submit" name="add" class="btn btn-primary mr-2">Add Purchase</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once $path_prefix . 'includes/footer.php'; ?>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>
