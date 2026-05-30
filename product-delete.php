<?php
require_once 'includes/config.php';

if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_id = $_SESSION['login_user_id'];

    if (isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);

        $fetch_query = "SELECT * FROM product WHERE PID = ? AND UID = ?";
        $fetch_stmt = $conn->prepare($fetch_query);
        $fetch_stmt->bind_param("ii", $product_id, $user_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->get_result();

        if ($result->num_rows > 0) {
            $delete_query = "DELETE FROM product WHERE PID = ? AND UID = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("ii", $product_id, $user_id);
            if ($delete_stmt->execute()) {
                header("Location: product-list.php");
                exit();
            } else {
                echo "Error deleting product";
            }
        } else {
            echo "Product not found or unauthorized access.";
        }
    } else {
        echo "Product ID not provided";
    }
    mysqli_close($conn);
}
?>