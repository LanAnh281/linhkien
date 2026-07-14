<?php include_once "../../../database/connect.php"; ?>

 <header>
    <div class="container header-wrap">
        <div class="header-logo">
            <a href="#">
                <img src="../../../public/images/logo1.png" alt="Logo">
            </a>
        </div>
        <div class="header-search">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-input" placeholder="Tìm kiếm sản phẩm..." required>
                <button type="submit" class="search-btn">Tìm</button>
            </form>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="./index.php">Trang chủ</a></li>
                <?php
                    $query = 'SELECT * FROM LOAISANPHAM;';
                    $stt = 1;
                    try {
                        $sth = $conn->query($query);
                        echo '<li class="dropdown"> 
                                <a href="#" class="dropdown-toggle">Sản phẩm <span class="arrow">▼</span></a>
                                <ul class="dropdown-menu">';
                        while ($row = $sth->fetch()){
                            echo '
                                <li>
                                    <a class="dropdown-item" href="products.php?idloai='.$row['IDLoai'].'">'.$row['TenLoai'].'</a>
                                </li>';
                        }   
                            echo ' </ul> </li>';
                    } catch (PDOException $e){
                        
                    }
                    ?>   
                <li><a href="./registration.php">Đăng ký</a></li>
                <li><a href="./login.php">Đăng nhập</a></li>
                <li><a href="./contact.php">Liên hệ</a></li>
            </ul>
        </nav>

    </div>
</header>
  
  
