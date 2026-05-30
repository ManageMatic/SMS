<?php
session_start();
require_once 'includes/config.php';

$store_name = '';
$email = '';

if (isset ($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die ("Connection failed: " . mysqli_connect_error());
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

    $top_product_query = "SELECT SLPRODUCT, SUM(SLQUANTITY) AS TotalQuantity FROM sale WHERE UID = ? GROUP BY SLPRODUCT ORDER BY TotalQuantity DESC LIMIT 1";
    $top_product_stmt = $conn->prepare($top_product_query);
    $top_product_stmt->bind_param("i", $user_id);
    $top_product_stmt->execute();
    $top_product_result = $top_product_stmt->get_result();

    $most_sold_product = '';
    $total_quantity_sold = 0;
    if ($top_product_result->num_rows > 0) {
        $top_product_row = $top_product_result->fetch_assoc();
        $most_sold_product = $top_product_row['SLPRODUCT'];
        $total_quantity_sold = $top_product_row['TotalQuantity'];
    }

    mysqli_close($conn);
}
?>


<?php
require_once 'includes/header.php';
?>
        <?php require_once 'includes/sidebar.php'; ?>
<?php require_once 'includes/navbar.php'; ?>
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
                                                <img src="assets/images/product/1.png" class="img-fluid" alt="image">
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
                                                <img src="assets/images/product/2.png" class="img-fluid" alt="image">
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
                                                <img src="assets/images/product/3.png" class="img-fluid" alt="image">
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
                    <div class="col-lg-8">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="d-flex align-items-top justify-content-between">
                                    <img id="storeImage" src="../path-to-default-image.jpg" class="img-fluid"
                                        alt="Store Image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        var imagePaths = [
                            "https://img.freepik.com/free-vector/hand-drawn-international-trade-illustration_52683-76253.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais",
                            "https://img.freepik.com/premium-vector/inventory-control-system-concept-professional-manager-checking-goods-stock-supply-inventory-management-with-goods-demand_185038-803.jpg",
                            "https://img.freepik.com/free-vector/warehouse-staff-wearing-uniform-loading-parcel-box-checking-product-from-warehouse-delivery-logistic-storage-truck-transportation-industry-delivery-logistic-business-delivery_1150-60909.jpg",
                        ];

                        var currentIndex = 0;

                        function changeImage() {
                            var imgElement = document.getElementById('storeImage');

                            imgElement.src = imagePaths[currentIndex];

                            currentIndex = (currentIndex + 1) % imagePaths.length;
                        }

                        changeImage();

                        setInterval(changeImage, 5000);
                    </script>
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
                                                    <img src="assets/images/product/01.png"
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
                                                    <img src="assets/images/product/02.png"
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
                                                    <img src="assets/images/product/03.png"
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
                                                    <img src="assets/images/product/02.png"
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
                                    <div><a href="#" class="btn btn-primary view-btn font-size-14">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-block card-stretch card-height-helf">
                            <div class="card-body card-item-right">
                                <div class="d-flex align-items-top">
                                    <div class="bg-warning-light rounded">
                                        <img src="assets/images/product/04.png" class="style-img img-fluid m-auto"
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
                                        <img src="assets/images/product/05.png" class="style-img img-fluid m-auto"
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
                    <div class="col-lg-8">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="d-flex align-items-top justify-content-between"
                                    style="width: 100%; height: 100%;">
                                    <img id="storeImage1" src="" class="img-fluid" alt="Store Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        var imagePaths1 = [
                            "https://st.depositphotos.com/9999814/52407/i/450/depositphotos_524071248-stock-photo-smart-warehouse-management-system-with.jpg",
                            "https://media.istockphoto.com/id/1484852942/photo/smart-warehouse-inventory-management-system-concept.jpg?s=612x612&w=0&k=20&c=q5hzpG2i4A7iVLT7sseXdKIsVxClkLJrUlLsZJNIGMs=",
                            "https://st2.depositphotos.com/9999814/50628/i/450/depositphotos_506286024-stock-photo-smart-warehouse-management-system-with.jpg",
                        ];

                        var currentIndex1 = 0;

                        function changeImage1() {
                            var imgElement1 = document.getElementById('storeImage1');

                            imgElement1.src = imagePaths1[currentIndex1];

                            currentIndex1 = (currentIndex1 + 1) % imagePaths1.length;
                        }

                        changeImage1();

                        setInterval(changeImage1, 5000);
                    </script>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>
        <?php require_once 'includes/scripts.php'; ?>