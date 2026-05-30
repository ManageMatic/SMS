<?php
session_start();
$path_prefix = "../";
require_once $path_prefix . 'includes/config.php';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $redirect_url = $path_prefix . "dashboard.php";

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->bind_result($user_id);
    $fetch_stmt->fetch();

    $sql = "SELECT * FROM product WHERE UID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    mysqli_close($conn);

} elseif (isset($_SESSION['admin_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $is_admin = isset($_SESSION['admin_user']);
    $redirect_url = $path_prefix . "admin-dashboard.php";

    $email = $_SESSION['admin_user'];
    $fetch_query = "SELECT ANAME, AEMAIL FROM admin WHERE AEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->fetch();

    $sql = "SELECT * FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    mysqli_close($conn);
}
?>
<?php
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["save"])) {
    // Get values from the form submission
    $id = $_POST["id"];
    $newPrice = $_POST["price"];
    $newCost = $_POST["cost"];

    // Update the database
    $sql = "UPDATE product SET PPRICE = '$newPrice', PCOST = '$newCost' WHERE PID = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!-- Delete Code from the database -->
<?php
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["delete"])) {
    // Get values from the form submission
    $id = $_POST["id"];

    // Update the database
    $sql = "DELETE FROM `product` WHERE `product`.`PID` = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>


<?php
$page_title = "Product List";
require_once $path_prefix . 'includes/header.php';
?>

        <?php require_once $path_prefix . 'includes/sidebar.php'; ?>
<?php require_once $path_prefix . 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="mb-3">Product List</h4>
                                <p class="mb-0">The product list effectively dictates product presentation and provides
                                    space<br> to list your products and offering in the most appealing way.</p>
                            </div>
                            <a href="add.php" class="btn btn-primary add-list"><i
                                    class="las la-plus mr-3"></i>Add Product</a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive rounded mb-3">
                            <table class="data-tables table mb-0 tbl-server-info">
                                <thead class="bg-white text-uppercase">
                                    <tr class="ligth ligth-data">
                                        <th>
                                            <div class="checkbox d-inline-block">
                                                <input type="checkbox" class="checkbox-input" id="checkbox1">
                                                <label for="checkbox1" class="mb-0"></label>
                                            </div>
                                        </th>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Cost</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <div id="confirmBox <?php $counter; ?> ">
                                    <form method="post">
                                        <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="popup text-left">
                                                            <h4 class="mb-3" id="editProductModalLabel">Edit Product
                                                                Price
                                                                and
                                                                Cost!</h4>
                                                            <form method="post" action="edit.php">
                                                                <div class="content create-workform bg-body">
                                                                    <div class="pb-3">
                                                                        <label class="mb-2">Price *</label>
                                                                        <input type="text" name="price"
                                                                            class="form-control"
                                                                            placeholder="Enter Price"
                                                                            value="<?php $row['PPRICE']; ?>" required>
                                                                    </div>
                                                                    <div class="pb-3">
                                                                        <label class="mb-2">Cost *</label>
                                                                        <input type="text" name="cost"
                                                                            class="form-control"
                                                                            placeholder="Enter Cost"
                                                                            value="<?php $row['PCOST']; ?>" required>
                                                                    </div>
                                                                    <input type="hidden" name="id"
                                                                        value=" <?php $row['PID']; ?>">
                                                                    <div class="col-lg-12 mt-4 text-center">
                                                                        <button type="button"
                                                                            class="btn btn-primary mr-4"
                                                                            data-dismiss="modal"
                                                                            onclick="closeConfirmBox(<?php $counter; ?>)">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-outline-primary"
                                                                            name="save">Save</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <?php if (!empty($data)): ?>
                                    <tbody class="ligth-body">
                                        <?php foreach ($data as $row): ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox d-inline-block">
                                                        <input type="checkbox" class="checkbox-input" id="checkbox2">
                                                        <label for="checkbox2" class="mb-0"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $row['PNAME']; ?>
                                </div>
                            </div>
                            </td>
                            <?php echo '<td>' . $row['PCODE'] . '</td>';
                            echo '<td>' . $row['PCATEGORY'] . '</td>';
                            echo '<td>' . $row['PPRICE'] . '</td>';
                            echo '<td>' . $row['PCOST'] . '</td>';
                            echo '<td>' . $row['PQUANTITY'] . '</td>'; ?>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="View" href=""><i class="ri-eye-line mr-0"></i></a>
                                    <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="Edit"
                                        href="#" onclick="editpopup(<?php $counter; ?>)"><i class="ri-pencil-line mr-0"></i></a>
                                    </a>
                                    <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Delete"
                                        href="delete.php?product_id=<?php echo $row['PID']; ?>"><i
                                            class="ri-delete-bin-line mr-0"></i></a>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                        </table>
                    <?php endif; ?>
                    <script>
                        function editpopup(counter) {
                            var popupId = "confirmBox" + counter;
                            document.getElementById(popupId).style.display = "block";
                        }

                        function closeConfirmBox(counter) {
                            var popupId = "confirmBox" + counter;
                            var confirmationBox = document.getElementById(popupId);
                            confirmationBox.style.display = "none";
                        }

                        function view(counter) {
                            var popupId = "Viewbox" + counter;
                            document.getElementById(popupId).style.display = "block";
                        }

                        function cancelBox(counter) {
                            var popupId = "Viewbox" + counter;
                            var confirmationBox = document.getElementById(popupId);
                            confirmationBox.style.display = "none";
                        }
                    </script>
                    </tbody>
                    </table>
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
