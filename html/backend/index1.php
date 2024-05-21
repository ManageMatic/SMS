<?php
session_start();

$store_name = '';
$email = '';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT STNAME FROM store WHERE SEMAIL=?";
    $fetch_query1 = "SELECT SEMAIL FROM store WHERE STNAME=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($store_name);
        $fetch_stmt->fetch();
    }

    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    } else {
        echo "0 results";
    }

    // Sales query
    $sales_query = "SELECT SUM(SLTOTALPAY) FROM sale WHERE UID = ?";
    $sales_stmt = $conn->prepare($sales_query);
    $sales_stmt->bind_param("i", $user_id);
    $sales_stmt->execute();
    $sales_result = $sales_stmt->get_result();

    $cost_query = "SELECT SUM(PRPAYMENT) FROM purchase WHERE UID = ?";
    $cost_stmt = $conn->prepare($cost_query);
    $cost_stmt->bind_param("i", $user_id);
    $cost_stmt->execute();
    $cost_result = $cost_stmt->get_result();

    $product_query = "SELECT SUM(SLQUANTITY) FROM sale WHERE UID = ?";
    $product_stmt = $conn->prepare($product_query);
    $product_stmt->bind_param("i", $user_id);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();

    $top_product_query = "SELECT SLPRODUCT FROM sale WHERE UID = ?";
    $top_product_stmt = $conn->prepare($top_product_query);
    $top_product_stmt->bind_param("i", $user_id);
    $top_product_stmt->execute();
    $top_product_result = $top_product_stmt->get_result();

    mysqli_close($conn);
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php echo $store_name; ?> | ManageMatic | Store Management System
    </title>

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
                            <a href="../backend/index1.php" class="svg-icon">
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
                                    <a href="../app/user-profile.html">
                                        <i class="las la-minus"></i><span>User Profile</span>
                                    </a>
                                </li>
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
                        <a href="../backend/index.html" class="header-logo">
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
                                                        <a href="../app/user-profile.html"
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
                    <div class="col-lg-4">
                        <div class="card card-transparent card-block card-stretch card-height border-none">
                            <div class="card-body p-0 mt-lg-2 mt-0">
                                <h3 class="mb-3">
                                    <?php echo "Welcome, " . $store_name; ?>
                                </h3>
                                <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business
                                    process.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4 card-total-sale">
                                            <div class="icon iq-icon-box-2 bg-info-light">
                                                <img src="../assets/images/product/1.png" class="img-fluid" alt="image">
                                            </div>
                                            <div>
                                                <p class="mb-2">Total Sales</p>
                                                <?php
                                                if ($sales_result->num_rows > 0) {
                                                    while ($row = $sales_result->fetch_assoc()) {
                                                        $total_sales = $row["SUM(SLTOTALPAY)"];
                                                        echo '<h4>' . $total_sales . '/-</h4>';
                                                    }
                                                } else {
                                                    echo "No sales found";
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="iq-progress-bar mt-2">
                                            <span class="bg-info iq-progress progress-1" data-percent="85">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4 card-total-sale">
                                            <div class="icon iq-icon-box-2 bg-danger-light">
                                                <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                            </div>
                                            <div>
                                                <p class="mb-2">Total Cost</p>
                                                <?php
                                                if ($cost_result->num_rows > 0) {
                                                    while ($row = $cost_result->fetch_assoc()) {
                                                        $total_cost = $row["SUM(PRPAYMENT)"];
                                                        echo '<h4>' . $total_cost . '/-</h4>';
                                                    }
                                                } else {
                                                    echo "No sales found";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="iq-progress-bar mt-2">
                                            <span class="bg-danger iq-progress progress-1" data-percent="70">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4 card-total-sale">
                                            <div class="icon iq-icon-box-2 bg-success-light">
                                                <img src="../assets/images/product/3.png" class="img-fluid" alt="image">
                                            </div>
                                            <div>
                                                <p class="mb-2">Product Sold</p>
                                                <?php
                                                if ($product_result->num_rows > 0) {
                                                    while ($row = $product_result->fetch_assoc()) {
                                                        $product_sales = $row["SUM(SLQUANTITY)"];
                                                        echo '<h4>' . $product_sales . '/-</h4>';
                                                    }
                                                } else {
                                                    echo "No sales found";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="iq-progress-bar mt-2">
                                            <span class="bg-success iq-progress progress-1" data-percent="75">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Overview</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton001"
                                            data-toggle="dropdown">
                                            This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right shadow-none"
                                            aria-labelledby="dropdownMenuButton001">
                                            <a class="dropdown-item" href="#">Year</a>
                                            <a class="dropdown-item" href="#">Month</a>
                                            <a class="dropdown-item" href="#">Week</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="layout1-chart1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Revenue Vs Cost</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton002"
                                            data-toggle="dropdown">
                                            This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right shadow-none"
                                            aria-labelledby="dropdownMenuButton002">
                                            <a class="dropdown-item" href="#">Yearly</a>
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Weekly</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="layout1-chart-2" style="min-height: 360px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Top Products</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton006"
                                            data-toggle="dropdown">
                                            This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right shadow-none"
                                            aria-labelledby="dropdownMenuButton006">
                                            <a class="dropdown-item" href="#">Year</a>
                                            <a class="dropdown-item" href="#">Month</a>
                                            <a class="dropdown-item" href="#">Week</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled row top-product mb-0">
                                    <li class="col-lg-3">
                                        <div class="card card-block card-stretch card-height mb-0">
                                            <div class="card-body">
                                                <div class="bg-warning-light rounded">
                                                    <img src="../assets/images/product/01.png"
                                                        class="style-img img-fluid m-auto p-3" alt="image">
                                                </div>
                                                <div class="style-text text-left mt-3">
                                                    <h5 class="mb-1">Organic Cream</h5>
                                                    <p class="mb-0">789 Item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3">
                                        <div class="card card-block card-stretch card-height mb-0">
                                            <div class="card-body">
                                                <div class="bg-danger-light rounded">
                                                    <img src="../assets/images/product/02.png"
                                                        class="style-img img-fluid m-auto p-3" alt="image">
                                                </div>
                                                <div class="style-text text-left mt-3">
                                                    <h5 class="mb-1">Rain Umbrella</h5>
                                                    <p class="mb-0">657 Item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3">
                                        <div class="card card-block card-stretch card-height mb-0">
                                            <div class="card-body">
                                                <div class="bg-info-light rounded">
                                                    <img src="../assets/images/product/03.png"
                                                        class="style-img img-fluid m-auto p-3" alt="image">
                                                </div>
                                                <div class="style-text text-left mt-3">
                                                    <h5 class="mb-1">Serum Bottle</h5>
                                                    <p class="mb-0">489 Item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3">
                                        <div class="card card-block card-stretch card-height mb-0">
                                            <div class="card-body">
                                                <div class="bg-success-light rounded">
                                                    <img src="../assets/images/product/02.png"
                                                        class="style-img img-fluid m-auto p-3" alt="image">
                                                </div>
                                                <div class="style-text text-left mt-3">
                                                    <h5 class="mb-1">Organic Cream</h5>
                                                    <p class="mb-0">468 Item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-transparent card-block card-stretch mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between p-0">
                                <div class="header-title">
                                    <h4 class="card-title mb-0">Best Item All Time</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div><a href="#" class="btn btn-primary view-btn font-size-14">View All</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-block card-stretch card-height-helf">
                            <div class="card-body card-item-right">
                                <div class="d-flex align-items-top">
                                    <div class="bg-warning-light rounded">
                                        <img src="../assets/images/product/04.png" class="style-img img-fluid m-auto"
                                            alt="image">
                                    </div>
                                    <div class="style-text text-left">
                                        <h5 class="mb-2">Coffee Beans Packet</h5>
                                        <p class="mb-2">Total Sell : 45897</p>
                                        <p class="mb-0">Total Earned : $45,89 M</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-block card-stretch card-height-helf">
                            <div class="card-body card-item-right">
                                <div class="d-flex align-items-top">
                                    <div class="bg-danger-light rounded">
                                        <img src="../assets/images/product/05.png" class="style-img img-fluid m-auto"
                                            alt="image">
                                    </div>
                                    <div class="style-text text-left">
                                        <h5 class="mb-2">Bottle Cup Set</h5>
                                        <p class="mb-2">Total Sell : 44359</p>
                                        <p class="mb-0">Total Earned : $45,50 M</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-block card-stretch card-height-helf">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div class="">
                                        <p class="mb-0">Income</p>
                                        <h5>98.78K/-</h5>
                                    </div>
                                    <div class="card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton003"
                                                data-toggle="dropdown">
                                                This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right shadow-none"
                                                aria-labelledby="dropdownMenuButton003">
                                                <a class="dropdown-item" href="#">Year</a>
                                                <a class="dropdown-item" href="#">Month</a>
                                                <a class="dropdown-item" href="#">Week</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="layout1-chart-3" class="layout-chart-1"></div>
                            </div>
                        </div>
                        <div class="card card-block card-stretch card-height-helf">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div class="">
                                        <p class="mb-0">Expenses</p>
                                        <h5>45,89K/-</h5>
                                    </div>
                                    <div class="card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton004"
                                                data-toggle="dropdown">
                                                This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right shadow-none"
                                                aria-labelledby="dropdownMenuButton004">
                                                <a class="dropdown-item" href="#">Year</a>
                                                <a class="dropdown-item" href="#">Month</a>
                                                <a class="dropdown-item" href="#">Week</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="layout1-chart-4" class="layout-chart-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Order Summary</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton005"
                                            data-toggle="dropdown">
                                            This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right shadow-none"
                                            aria-labelledby="dropdownMenuButton005">
                                            <a class="dropdown-item" href="#">Year</a>
                                            <a class="dropdown-item" href="#">Month</a>
                                            <a class="dropdown-item" href="#">Week</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center mt-2">
                                    <div class="d-flex align-items-center progress-order-left">
                                        <div class="progress progress-round m-0 orange conversation-bar"
                                            data-percent="46">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value text-secondary">46%</div>
                                        </div>
                                        <div class="progress-value ml-3 pr-5 border-right">
                                            <h5>12.65k/-</h5>
                                            <p class="mb-0">Average Orders</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ml-5 progress-order-right">
                                        <div class="progress progress-round m-0 primary conversation-bar"
                                            data-percent="46">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value text-primary">46%</div>
                                        </div>
                                        <div class="progress-value ml-3">
                                            <h5>59.84k/-</h5>
                                            <p class="mb-0">Top Orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div id="layout1-chart-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page end  -->
            </div>
        </div>
    </div>
    <!-- Wrapper End-->
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="#">Privacy Policy</a>
                                </li>
                                <li class="list-inline-item"><a href="#">Terms of Use</a>
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
    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/backend-bundle.min.js"></script>

    <!-- Table Treeview JavaScript -->
    <script src="../assets/js/table-treeview.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="../assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="../assets/js/chart-custom.js"></script>

    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>
</body>

</html>