<?php

?>
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
  
  
