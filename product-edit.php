<?php
session_start();
require_once 'includes/config.php';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_id = $_SESSION['login_user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];
        $cost = $_POST['cost'];

        $update_query = "UPDATE product SET PPRICE = ?, PCOST = ? WHERE PID = ? AND UID = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ddii", $price, $cost, $product_id, $user_id);

        if ($update_stmt->execute()) {
            header("Location: product-list.php");
            exit();
        } else {
            $error_message = "Error: " . $update_stmt->error;
        }
    }
    mysqli_close($conn);
}
?>