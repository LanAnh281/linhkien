<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <style>
        .main-content {
            display: grid;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* --- 4. ARTICLE / PRODUCT LIST --- */
        .articles h3 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #1a252f;
            font-size: 36px;
        }
        .grid-products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .product-card h4 { margin: 10px 0; font-size: 16px; }
        .price { color: #e74c3c; font-weight: bold; }

      
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>
     <!-- Main body -->
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
   

  