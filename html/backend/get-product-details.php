<?php
if (isset($_SESSION['login_user'])) {
    $conn = mysqli_connect("localhost", "root", "", "storemanagement");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['productId'])) {
        $productId = $_POST['productId'];

        $stmt = $conn->prepare("SELECT PPRICE, PCOST FROM product WHERE PID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $productDetails = $result->fetch_assoc();

            echo json_encode($productDetails);
        } else {
            echo json_encode((object) []);
        }
    } else {
        echo "Error: Product ID is not provided.";
    }
    mysqli_close($conn);
}
?>