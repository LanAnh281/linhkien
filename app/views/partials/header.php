<?php include_once "../../../database/connect.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <style>
        header {
            background-color: #1a252f; 
            padding: 20px 0;           
            box-shadow: 0 2px 10px rgba(0,0,0,0.4);
        }
        .header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Căn tất cả thẳng hàng theo chiều dọc */
            gap: 30px;           /* Khoảng cách an toàn giữa các khối */
        }

        /* KHỐI 1: LOGO (Chiếm tỉ lệ vừa vặn, không méo) */
        .header-logo {
            flex: 0 0 20%;       /* Cố định khối logo chiếm 15% độ rộng */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-logo img {
            max-width: auto;
            height: 70px;       
            object-fit: contain; /* Chống méo ảnh tuyệt đối */
            transform: scale(1.2); /* Mẹo kích phóng to thêm 20% nếu ảnh gốc có viền trắng */
            transform-origin: left center;
        }

        /* KHỐI 2: SEARCH (Nổi bật, nằm ngay trung tâm) */
        .header-search {
            flex: 0 0 40%;       /* Khối search chiếm rộng rãi 50% độ rộng ở giữa */
            display: flex;
            justify-content: center;
        }

        .search-form {
            display: flex;
            width: 100%;  
            max-width: 550px;      
        }

        .search-input {
            flex: 1;             /* Ô input tự động giãn chiếm tối đa diện tích */
            padding: 12px 20px;  /* Làm ô tìm kiếm to, dễ bấm hơn */
            border: none;
            border-radius: 6px 0 0 6px; /* Bo góc mềm mại bên trái */
            outline: none;
            font-size: 15px;
            background-color: #ffffff;
        }

        .search-btn {
            padding: 0 25px;
            background-color: #3498db; /* Màu xanh dương giống ảnh mẫu của bạn */
            color: #ffffff;
            border: none;
            border-radius: 0 6px 6px 0; /* Bo góc bên phải */
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .search-btn:hover {
            background-color: #2980b9;
        }

        /* KHỐI 3: NAVIGATION (Nằm gọn gàng, rõ ràng bên phải) */
        .header-nav {
            flex: 0 0 40%;       /* Chiếm 35% không gian còn lại */
            display: flex;
            justify-content: center; /* Đẩy sát các chữ về bên phải */
            margin: 0 20px;
        }

        .header-nav ul {
            display: flex;
            list-style: none;
            gap: 25px;           /* Tạo khoảng cách thông thoáng giữa các chữ */
            padding: 0;
            margin: 0;
        }

        .header-nav ul li a {
            color: #3498db;      /* Đổi chữ sang màu xanh sáng để nổi bật trên nền tối giống ảnh mẫu */
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
            white-space: nowrap; /* Giữ chữ trên một hàng, không cho xuống dòng bậy */
        }

        .header-nav ul li a:hover {
            color: #ffffff;      /* Khi rê chuột vào chữ sẽ sáng trắng lên */
        }

        /* Responsive cho điện thoại */
        @media (max-width: 768px) {
            .header-wrap {
                flex-direction: column;
                gap: 15px;
            }
            .header-logo, .header-search, .header-nav {
                flex: 0 0 100%;
                width: 100%;
                justify-content: center;
            }
        }
       /* --- CẤU HÌNH MENU DROPDOWN --- */

/* Đặt vị trí tương đối cho mục cha để menu con căn mốc theo nó */
.header-nav ul li.dropdown {
    position: relative;
    padding-bottom: 10px; /* Tạo vùng đệm để khi di chuột xuống menu con không bị mất hover */
    margin-bottom: -10px;
}

/* Định dạng mũi tên nhỏ cạnh chữ Sản phẩm */
.arrow {
    font-size: 10px;
    margin-left: 4px;
    vertical-align: middle;
    transition: transform 0.3s ease;
}

/* Khung chứa menu con thả xuống */
.header-nav .dropdown-menu {
    position: absolute;
    top: 100%;          /* Xuất hiện ngay sát mép dưới của mục cha */
    left: 50%;
    transform: translateX(-50%) translateY(10px); /* Căn giữa menu con theo mục cha và đẩy xuống 10px */
    background-color: #1a252f; /* Trùng màu nền header cho đồng bộ */
    min-width: 180px;   /* Độ rộng tối thiểu của bảng menu con */
    flex-direction: column; /* Xếp các mục con theo hàng dọc chứ không nằm ngang */
    gap: 0 !important;  /* Xóa khoảng cách mặc định của flexboard cha */
    border-radius: 6px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border: 1px solid #2c3e50;
    
    /* Trạng thái ẩn mặc định */
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease; /* Tạo hiệu ứng mượt mà khi hiện lên */
}

/* Định dạng từng mục link con bên trong */
.header-nav .dropdown-menu li {
    margin: 0 !important; /* Xóa margin-left của menu cha */
    width: 100%;
}

.header-nav .dropdown-menu li a {
    display: block;
    padding: 12px 20px;
    color: #ffffff !important; /* Chữ menu con màu trắng */
    font-size: 14px;
    font-weight: 500;
    text-align: left;
    border-bottom: 1px solid #2c3e50;
    transition: background 0.2s ease, color 0.2s ease;
}

/* Xóa đường gạch chân cho mục con cuối cùng */
.header-nav .dropdown-menu li:last-child a {
    border-bottom: none;
    border-radius: 0 0 6px 6px;
}
.header-nav .dropdown-menu li:first-child a {
    border-radius: 6px 6px 0 0;
}

/* --- HIỆU ỨNG HOVER: KHI RÊ CHUỘT VÀO MỤC SẢN PHẨM --- */
.header-nav ul li.dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0); /* Menu trượt nhẹ lên vị trí chuẩn */
}

/* Đổi màu chữ mục cha khi hover */
.header-nav ul li.dropdown:hover .dropdown-toggle {
    color: #ffffff;
}

/* Xoay nhẹ mũi tên khi menu mở ra */
.header-nav ul li.dropdown:hover .arrow {
    transform: rotate(180deg);
    color: #ffffff;
}

/* Hiệu ứng hover riêng cho từng mục con */
.header-nav .dropdown-menu li a:hover {
    background-color: #3498db; /* Nền xanh khi di chuột vào mục con */
    color: #ffffff !important;
}
    </style>
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
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-input" placeholder="Tìm kiếm sản phẩm..." required>
                <button type="submit" class="search-btn">Tìm</button>
            </form>
        </div>
        
        <nav class="header-nav">
            <ul>
                <li><a href="./index.php">Trang chủ</a></li>

                <?php
                    $query = 'select * from LOAISANPHAM';
                    $stt = 1;
                    try {
                        $sth = $conn->query($query);
                        echo ' <li class="dropdown"> 
                                <a href="#" class="dropdown-toggle">
                                Sản phẩm <span class="arrow">▼</span></a>
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
               
                 
                <li><a href="./contact.php">Liên hệ</a></li>
            </ul>
        </nav>

    </div>
</header>
  
