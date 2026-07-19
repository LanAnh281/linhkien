<?php  include_once "../../../../database/connect.php"; 
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ </title>
    <link rel="stylesheet" href="../../../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="app-container">
        
        <!-- NHÚNG SIDEBAR CỐ ĐỊNH (3 phần) -->
        <?php include_once '../../partials/sidebar.php'; ?>

        <!-- KHU VỰC HIỂN THỊ CHÍNH (9 phần) -->
        <div class="main-wrapper">
            
            <!-- NHÚNG NAVBAR CỐ ĐỊNH (Thông tin tài khoản & Thông báo) -->
            <?php include_once '../../partials/navbar.php'; ?>

            <!-- Nội dung thực tế của trang index.php -->
            <div class="page-content">
                <h2 class="text-success">Trang thống kê</h2>
                <p>Nội dung trang chủ sẽ hiển thị ở đây. Cả Sidebar và Navbar đều được gọi từ file riêng biệt, giúp bạn quản lý code cực kỳ gọn gàng.</p>
            </div>

        </div>

    </div>
    <?php include '../../partials/footer.php'; ?>
</body>
</html>


   

  