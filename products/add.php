<?php
session_start();
$path_prefix = "../";
require_once $path_prefix . 'includes/config.php';

if (!isset($_SESSION['login_user']) && !isset($_SESSION['admin_user'])) {
    header("Location: " . $path_prefix . "auth/sign-in.php");
    exit();
}

// Add product form will be implemented here
$page_title = "Add Product";
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
                            <h4 class="card-title">Add Product</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Product add form — coming soon.</p>
                        <a href="list.php" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <?php require_once $path_prefix . 'includes/footer.php'; ?>
    <?php require_once $path_prefix . 'includes/scripts.php'; ?>
