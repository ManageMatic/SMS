<?php
session_start();
$path_prefix = "";
require_once $path_prefix . 'includes/config.php';

if (isset($_SESSION['admin_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $is_admin = isset($_SESSION['admin_user']);

    $email = $_SESSION['admin_user'];
    $fetch_query = "SELECT ANAME, AEMAIL FROM admin WHERE AEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->fetch();

    $sql = "SELECT * FROM store";
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
$page_title = "List User";
require_once $path_prefix . 'includes/header.php';
?>

        <?php require_once $path_prefix . 'includes/sidebar.php'; ?>
<?php require_once $path_prefix . 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">User List</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="row justify-content-between">
                                        <div class="col-sm-6 col-md-6">
                                            <div id="user_list_datatable_info" class="dataTables_filter">
                                                <form class="mr-3 position-relative">
                                                    <div class="form-group mb-0">
                                                        <input type="search" class="form-control"
                                                            id="exampleInputSearch" placeholder="Search"
                                                            aria-controls="user-list-table">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!--<div class="col-sm-6 col-md-6">
                                            <div class="user-list-files d-flex">
                                                <a class="bg-primary" href="javascript:void();">
                                                    Print
                                                </a>
                                                <a class="bg-primary" href="javascript:void();">
                                                    Excel
                                                </a>
                                                <a class="bg-primary" href="javascript:void();">
                                                    Pdf
                                                </a>
                                            </div>
                                        </div>-->
                                    </div>
                                    <table id="user-list-table" class="table table-striped dataTable mt-4" role="grid"
                                        aria-describedby="user-list-page-info">
                                        <thead>
                                            <tr class="ligth">
                                                <!--<th>Profile</th>-->
                                                <th>Name</th>
                                                <th>Store Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>B'Date</th>
                                                <th>Address</th>
                                                <th style="min-width: 100px">Action</th>
                                            </tr>
                                        </thead>
                                        <?php if (!empty($data)): ?>
                                            <tbody>
                                                <?php foreach ($data as $row): ?>
                                                    <tr>
                                                        <!--<td class="text-center"><img class="rounded img-fluid avatar-40"
                                                        src="assets/images/user/01.jpg" alt="profile"></td>-->
                                                        <?php echo '<td>' . $row['SNAME'] . '</td>';
                                                        echo '<td>' . $row['STNAME'] . '</td>';
                                                        echo '<td>' . $row['SPHONE'] . '</td>';
                                                        echo '<td>' . $row['SEMAIL'] . '</td>';
                                                        echo '<td>' . $row['SBDATE'] . '</td>';
                                                        echo '<td>' . $row['SADDRESS'] . '</td>'; ?>
                                                        <td>
                                                            <div class="flex align-items-center list-user-action">
                                                                <a class="btn btn-sm bg-primary" data-toggle="tooltip"
                                                                    data-placement="top" title="" data-original-title="Add"
                                                                    href="#"><i class="ri-user-add-line mr-0"></i></a>
                                                                <a class="btn btn-sm bg-primary" data-toggle="tooltip"
                                                                    data-placement="top" title="" data-original-title="Edit"
                                                                    href="#"><i class="ri-pencil-line mr-0"></i></a>
                                                                <a class="btn btn-sm bg-primary" data-toggle="tooltip"
                                                                    data-placement="top" title="" data-original-title="Delete"
                                                                    href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                </div>
                                <!--<div class="row justify-content-between mt-3">
                                    <div id="user-list-page-info" class="col-md-6">
                                        <span>Showing 1 to 5 of 5 entries</span>
                                    </div>
                                    <div class="col-md-6">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1"
                                                        aria-disabled="true">Previous</a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once $path_prefix . 'includes/footer.php'; ?>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>