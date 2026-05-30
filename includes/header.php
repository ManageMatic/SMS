<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title_prefix = isset($page_title) ? $page_title . " | " : "";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title_prefix; ?>ManageMatic | Store Management System</title>
    <link rel="shortcut icon" href="<?php echo $path_prefix; ?>assets/images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/vendor/remixicon/fonts/remixicon.css">
</head>
<body class="  ">
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <div class="wrapper">
