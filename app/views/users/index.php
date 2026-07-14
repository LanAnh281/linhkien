<?php  include_once "../../../database/connect.php"; 
    session_start();
    if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show mx-5 mt-3" role="alert">
        <i class="fas fa-check-circle mr-2"></i> 
        <?php 
            echo $_SESSION['success_message']; 
            unset($_SESSION['success_message']); // Xóa thông báo ngay để khi F5 trang không bị hiện lại
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ </title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>

<body>
<?php include '../partials/header.php'; ?>
   <!-- 3. MAIN BODY (Nội dung chính và Cột bên) -->
    <div class="container main-content">
        <!-- Khu vực hiển thị nội dung chính / Danh sách sản phẩm -->
        <main class="articles">
            <h3>Sản Phẩm Nổi Bật</h3>
            <div class="grid-products">
                
                <!-- Sản phẩm 1 -->
                <div class="product-card">
                    <a href="./contact.php">
                         <img src="https://picsum.photos/200/150?random=1" alt="Sản phẩm">
                        <h4>Bàn Phím Cơ Không Dây</h4>
                        <p class="price">1,250,000 đ</p>
                    </a>
                    
                    
                </div>

                <!-- Sản phẩm 2 -->
                <div class="product-card">
                    <a href="#">
                         <img src="https://picsum.photos/200/150?random=2" alt="Sản phẩm">
                        <h4>Chuột Gaming Công Trình Học</h4>
                        <p class="price">850,000 đ</p>
                    </a>
                   
                </div>

                <!-- Sản phẩm 3 -->
                <div class="product-card">
                    <a href="#">
                        <img src="https://picsum.photos/200/150?random=3" alt="Sản phẩm">
                        <h4>Tai Nghe Chống Ồn ANC</h4>
                        <p class="price">2,400,000 đ</p>
                    </a>
                    
                </div>

                <!-- Sản phẩm 4 -->
                <div class="product-card">
                    <a href="#">
                        <img src="https://picsum.photos/200/150?random=4" alt="Sản phẩm">
                        <h4>Lót Chuột Cỡ Lớn (Deskmat)</h4>
                        <p class="price">350,000 đ</p>
                    </a>
                    
                </div>

                <!-- sản phẩm 5 -->
                   <div class="product-card">
                    <a href="#">
                         <img src="https://picsum.photos/200/150?random=4" alt="Sản phẩm">
                        <h4>Lót Chuột Cỡ Lớn (Deskmat)</h4>
                        <p class="price">350,000 đ</p>
                    </a>
                   
                </div>
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>

   

  