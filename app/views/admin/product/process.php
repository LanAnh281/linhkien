<?php
 include_once "../../../../database/connect.php";
session_start();
echo "trang xử lý sản phẩm";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action == 'update') {
        echo "cập nhật sản phẩm thành công";
        // Xử lý Cập nhật
        // $name = $_POST['name'];
        // $price = $_POST['price'];

        // $sql = "UPDATE products SET name = ?, price = ? WHERE id = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute([$name, $price, $id]);

        // $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
        
    } elseif ($action == 'delete') {
        echo "xóa sản phẩm thành công";
        // Xử lý Xóa
        // $sql = "DELETE FROM products WHERE id = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute([$id]);

        // $_SESSION['success'] = "Đã xóa sản phẩm thành công!";
    }

    // Quay trở lại trang danh sách sản phẩm ban đầu
    // header("Location: index.php");
    // exit();
}
?>