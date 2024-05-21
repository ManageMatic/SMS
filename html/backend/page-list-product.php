<?php
session_start();

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $redirect_url = "../backend/dashboard.php";

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SID FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();
    $fetch_stmt->bind_result($user_id);
    $fetch_stmt->fetch();

    /*$fetch_query1 = "SELECT STNAME FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query1);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($store_name);
        $fetch_stmt->fetch();
    }*/

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
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $is_admin = isset($_SESSION['admin_user']);
    $redirect_url = "../backend/admin-dashboard.php";

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
$conn = mysqli_connect("localhost", "root", "", "storemanagement");
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
        header("Location:page-list-product.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!-- Delete Code from the database -->
<?php
$conn = mysqli_connect("localhost", "root", "", "storemanagement");
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
        header("Location:page-list-product.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product List | ManageMatic | Store Management System</title>

    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="  ">
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <div class="wrapper">

        <div class="iq-sidebar  sidebar-default ">
            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                <a href="../backend/index.html" class="header-logo">
                    <img src="../assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                    <h5 class="logo-title light-logo ml-3">ManageMatic</h5>
                </a>
                <div class="iq-menu-bt-sidebar ml-0">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="active">
                            <a href="<?php echo $redirect_url; ?>" class="svg-icon">
                                <svg class="svg-icon" id="p-dash1" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span class="ml-4">Dashboards</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#product" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash2" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <span class="ml-4">Products</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="product" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-product.php">
                                        <i class="las la-minus"></i><span>List Product</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-product.php">
                                        <i class="las la-minus"></i><span>Add Product</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#category" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash3" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                <span class="ml-4">Categories</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="category" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-category.php">
                                        <i class="las la-minus"></i><span>List Category</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-category.php">
                                        <i class="las la-minus"></i><span>Add Category</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#sale" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash4" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                <span class="ml-4">Sale</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="sale" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-sale.php">
                                        <i class="las la-minus"></i><span>List Sale</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-sale.php">
                                        <i class="las la-minus"></i><span>Add Sale</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#purchase" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash5" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <span class="ml-4">Purchases</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="purchase" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-purchase.php">
                                        <i class="las la-minus"></i><span>List Purchases</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-purchase.php">
                                        <i class="las la-minus"></i><span>Add purchase</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#return" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash6" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="4 14 10 14 10 20"></polyline>
                                    <polyline points="20 10 14 10 14 4"></polyline>
                                    <line x1="14" y1="10" x2="21" y2="3"></line>
                                    <line x1="3" y1="21" x2="10" y2="14"></line>
                                </svg>
                                <span class="ml-4">Returns</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="return" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-returns.php">
                                        <i class="las la-minus"></i><span>List Returns</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-return.php">
                                        <i class="las la-minus"></i><span>Add Return</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="#people" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash8" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span class="ml-4">People</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="people" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="">
                                    <a href="../backend/page-list-customers.php">
                                        <i class="las la-minus"></i><span>Customers</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-customers.php">
                                        <i class="las la-minus"></i><span>Add Customers</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-list-suppliers.php">
                                        <i class="las la-minus"></i><span>Suppliers</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="../backend/page-add-supplier.php">
                                        <i class="las la-minus"></i><span>Add Suppliers</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class=" ">
                            <a href="#user" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash10" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <polyline points="17 11 19 13 23 9"></polyline>
                                </svg>
                                <span class="ml-4">User Details</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="user" class="iq-submenu collapse" data-parent="#otherpage">
                                <li class="">
                                    <a href="../app/user-profile.php">
                                        <i class="las la-minus"></i><span>User Profile</span>
                                    </a>
                                </li>
                                <?php if ($is_admin): ?>
                                    <li class="">
                                        <a href="../app/user-add.php">
                                            <i class="las la-minus"></i><span>User Add</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="../app/user-list.php">
                                            <i class="las la-minus"></i><span>User List</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="">
                            <a href="../backend/page-report.html" class="">
                                <svg class="svg-icon" id="p-dash7" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span class="ml-4">Reports</span>
                            </a>
                            <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            </ul>
                        </li>
                        <ul id="otherpage" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        </ul>
                        </li>
                    </ul>
                </nav>
                <div class="p-3"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="../backend/index1.php" class="header-logo">
                            <img src="../assets/images/logo.png" class="img-fluid rounded-normal" alt="logo">
                            <h5 class="logo-title ml-3">ManageMatic</h5>
                        </a>
                    </div>
                    <div class="iq-search-bar device-search">
                        <form action="#" class="searchbox">
                            <a class="search-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </a>
                            <input type="text" class="text search-input" placeholder="Search here...">
                        </form>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="../assets/images/user/1.png" class="img-fluid rounded" alt="user">
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 text-center">
                                                <div class="media-body profile-detail text-center">
                                                    <img src="../assets/images/page-img/profile-bg.jpg" alt="profile-bg"
                                                        class="rounded-top img-fluid mb-4">
                                                    <img src="../assets/images/user/1.png" alt="profile-img"
                                                        class="rounded profile-img img-fluid avatar-70">
                                                </div>
                                                <div class="p-3">
                                                    <h5 class="mb-1">
                                                        <?php echo $email; ?>
                                                    </h5>
                                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                                        <a href="../app/user-profile.php"
                                                            class="btn border mr-2">Profile</a>
                                                        <a href="auth-sign-out.php" class="btn border">Sign Out</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
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
                            <a href="page-add-product.php" class="btn btn-primary add-list"><i
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
                                                            <form method="post" action="edit-product.php">
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
                                                    <!--<div class="d-flex align-items-center">
                                        <img src="' . $row['PIMAGE'] . '" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                        <div>-->
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
                                        href="delete-product.php?product_id=<?php echo $product_id; ?>"><i
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

    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="#">Privacy
                                        Policy</a>
                                </li>
                                <li class="list-inline-item"><a href="#">Terms of
                                        Use</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <span class="mr-1">
                                <script>document.write(new Date().getFullYear())</script>©
                            </span> <a href="#" class="">ManageMatic</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="../assets/js/backend-bundle.min.js"></script>

    <script src="../assets/js/table-treeview.js"></script>

    <script src="../assets/js/customizer.js"></script>

    <script async src="../assets/js/chart-custom.js"></script>

    <script src="../assets/js/app.js"></script>

</body>

</html>