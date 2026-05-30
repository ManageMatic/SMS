<?php
session_start();
require_once 'includes/config.php';

if (isset ($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die ("Connection failed:" . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->bind_result($user_id);
    $fetch_stmt->fetch();

    $sql = "SELECT * FROM sale WHERE UID = ?";
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

} elseif (isset ($_SESSION['admin_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die ("Connection failed: " . mysqli_connect_error());
    }

    $is_admin = isset ($_SESSION['admin_user']);

    $email = $_SESSION['admin_user'];
    $fetch_query = "SELECT ANAME, AEMAIL FROM admin WHERE AEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->fetch();

    $sql = "SELECT * FROM sale";
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
$page_title = "List Sale";
require_once 'includes/header.php';
?>

        <?php require_once 'includes/sidebar.php'; ?>
<?php require_once 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="mb-3">Sale List</h4>
                                <p class="mb-0">Sales enables you to effectively control sales KPIs and monitor them in
                                    one central<br>
                                    place while helping teams to reach sales goals. </p>
                            </div>
                            <a href="sale-add.php" class="btn btn-primary add-list"><i
                                    class="las la-plus mr-3"></i>Add Sale</a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive rounded mb-3">
                            <table class="data-table table mb-0 tbl-server-info">
                                <thead class="bg-white text-uppercase">
                                    <tr class="ligth ligth-data">
                                        <th>
                                            <div class="checkbox d-inline-block">
                                                <input type="checkbox" class="checkbox-input" id="checkbox1">
                                                <label for="checkbox1" class="mb-0"></label>
                                            </div>
                                        </th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Biller</th>
                                        <th>Tax</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty ($data)) {
                                    echo '<tbody class="ligth-body">';
                                    foreach ($data as $row) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<div class="checkbox d-inline-block">';
                                        echo '<input type="checkbox" class="checkbox-input" id="checkbox2">';
                                        echo '<label for="checkbox2" class="mb-0"></label>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '<td>' . $row['SLDATE'] . '</td>';
                                        echo '<td>' . $row['SLPRODUCT'] . '</td>';
                                        echo '<td>' . $row['SLCUSTOMER'] . '</td>';
                                        echo '<td>' . $row['SLTOTALPAY'] . '</td>';
                                        echo '<td>' . $row['SLTOTALPAY'] . '</td>';
                                        echo '<td>';
                                        echo '<div class="badge badge-success">' . $row['SLPAYSTATUS'] . '</div>';
                                        echo '</td>';
                                        echo '<td>' . $row['SLBILLER'] . '</td>';
                                        echo '<td>' . $row['SLTAX'] . '</td>';
                                        echo '<td>';
                                        echo '<div class="d-flex align-items-center list-action">';
                                        echo '<a class="badge badge-info mr-2" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="View" href="#"><i
                                            class="ri-eye-line mr-0"></i></a>';
                                        echo '<a class="badge bg-success mr-2" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Edit" href="#"><i
                                            class="ri-pencil-line mr-0"></i></a>';
                                        echo '<a class="badge bg-warning mr-2" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Delete"
                                        href="#"><i class="ri-delete-bin-line mr-0"></i></a>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                } else {
                                    echo 'No data found';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <?php require_once 'includes/scripts.php'; ?>