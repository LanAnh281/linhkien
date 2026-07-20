<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng có bấm vào nút Đăng xuất không (qua tham số hành động trên URL)
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Xóa sạch session
    session_unset();
    session_destroy();
    
    // Tải lại chính trang này nhưng sạch URL (bỏ tham số ?action=logout)
    // Thay 'index.php' bằng tên file hiện tại của bạn nếu cần
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ </title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Nhúng Font Awesome để dùng icon giỏ hàng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>

</head>
<body>
 <header>
    <div class="container header-wrap">
        <div class="header-logo">
            <a href="#">
                <img src="../../../public/images/logo1.png" alt="Logo">
            </a>
        </div>
        <div class="header-search">
            <form action="../users/index.php" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Tìm kiếm sản phẩm..." required>
                <button type="submit" class="search-btn">Tìm</button>
            </form>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="./index.php">Trang chủ</a></li>
                <?php
                    $query = 'SELECT * FROM DANHMUC;';
                    $stt = 1;
                    try {
                        $sth = $conn->query($query);
                        echo '<li class="dropdown"> 
                                <a href="#" class="dropdown-toggle">Sản phẩm <span class="arrow">▼</span></a>
                                <ul class="dropdown-menu">';
                        while ($row = $sth->fetch()){
                            echo '
                                <li>
                                    <a class="dropdown-item" href="products.php?danhMucId='.$row['danhMucId'].'">'.$row['tenDanhMuc'].'</a>
                                </li>';
                        }   
                            echo ' </ul> </li>';
                    } catch (PDOException $e){
                        
                    }
                    ?>   
               <?php if (isset($_SESSION['username'])): ?>
                    <!-- Hiển thị khi người dùng ĐÃ ĐĂNG NHẬP -->
                    <li>
                        <a href="./cart.php" class="cart-link">
                            <!-- Icon cái giỏ hàng -->
                            <i class="fa-solid fa-cart-shopping"></i>
                            
                            <!-- Thông báo nhỏ (Badge) số lượng trên đầu giỏ hàng -->
                            <?php 
                            // Giả sử bạn lưu số lượng vào $_SESSION['cart_count']
                            $cart_count = isset($_SESSION['cart_count']) ? (int)$_SESSION['cart_count'] : 0; 
                            if ($cart_count > 0): 
                            ?>
                                <span class="cart-badge"><?php echo $cart_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="?action=logout">Đăng xuất</a></li>
                <?php else: ?>
                    <!-- Hiển thị khi người dùng CHƯA ĐĂNG NHẬP -->
                    <li><a href="./registration.php">Đăng ký</a></li>
                    <li><a href="./login.php">Đăng nhập</a></li>
                <?php endif; ?>
                <li><a href="./contact.php">Liên hệ</a></li>
            </ul>
        </nav>

    </div>
</header>
  
  
