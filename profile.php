<?php
session_start();
$path_prefix = "";
require_once $path_prefix . 'includes/config.php';

$name = '';
$store_name = '';
$email = '';
$phone = '';
$bdate = '';
$staddress = '';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_SESSION['login_user'];
    $fetch_query = "SELECT SNAME, STNAME, SEMAIL, SPHONE, SBDATE, SADDRESS FROM store WHERE SEMAIL=?";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("s", $email);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($name, $store_name, $email, $phone, $bdate, $staddress);
        $fetch_stmt->fetch();
    }

    mysqli_close($conn);
}
?>

<?php
$page_title = "User Profile";
require_once $path_prefix . 'includes/header.php';
?>

        <?php require_once $path_prefix . 'includes/sidebar.php'; ?>
<?php require_once $path_prefix . 'includes/navbar.php'; ?>
<div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card car-transparent">
                            <div class="card-body p-0">
                                <div class="profile-image position-relative">
                                    <a href="#" id="uploadTrigger">
                                        <img src="<?php echo $path_prefix; ?>assets/images/page-img/profile.png" class="img-fluid rounded w-100"
                                            alt="profile-image">
                                    </a>
                                    <input type="file" name="image" id="profileImage" accept="image/*"
                                        style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('uploadTrigger').onclick = function () {
                        document.getElementById('profileImage').click();
                    };
                </script>
                <div class="row m-sm-0 px-3">
                    <div class="col-lg-4 card-profile">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="profile-img position-relative">
                                        <div class="profile-img mb-3">
                                            <a href="#" id="upload">
                                                <img id="profile-image" src="<?php echo $path_prefix; ?>assets/images/user/1.png"
                                                    class="img-fluid rounded" alt="profile-image">
                                            </a>
                                        </div>
                                        <input type="file" name="profile" id="upload-photo" style="display: none;">
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('upload').addEventListener('click', function () {
                                        document.getElementById('upload-photo').click();
                                    });
                                </script>
                                <center>
                                    <div class="ml-3">
                                        <h4 class="mb-1">
                                            <?php echo $store_name; ?>
                                        </h4>
                                        <h5 class="mb-2">
                                            <?php echo $name; ?>
                                        </h5>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 card-profile">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <h4>Personal Information</h4>
                                <br>
                                <div class="profile-content tab-content">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="ml-3">
                                            </div>
                                            <ul class="list-inline p-0 m-0">
                                                <li class="mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <svg class="svg-icon mr-3" height="18" width="18"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <h5 class="mb-0">
                                                            <?php echo $staddress ?>
                                                        </h5>
                                                    </div>
                                                </li>
                                                </li>
                                                <li class="mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <svg class="svg-icon mr-3" height="18" width="18"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                                        </svg>
                                                        <h5 class="mb-0">
                                                            <?php echo $bdate ?>
                                                        </h5>
                                                    </div>
                                                </li>
                                                <li class="mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <svg class="svg-icon mr-3" height="18" width="18"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <h5 class="mb-0">
                                                            <?php echo $phone ?>
                                                        </h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <svg class="svg-icon mr-3" height="18" width="18"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <h5 class="mb-0">
                                                            <?php echo $email ?>
                                                        </h5>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="update-profile.php"><button class="btn btn-primary"
                                            id="updateProfileBtn">Update Profile</button></a>
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
