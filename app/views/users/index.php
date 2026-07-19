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
<?php
// Khởi tạo mảng chứa danh sách sản phẩm tìm được
$products = [];
$error = '';
$search = '';

// 2. Kiểm tra xem người dùng có nhấn nút tìm kiếm và nhập từ khóa hay không
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    
    // Câu lệnh truy vấn lọc theo từ khóa tìm kiếm
    $query = 'SELECT * FROM SANPHAM WHERE TenSanPham LIKE ?';
    $sth = $conn->prepare($query);
    $sth->execute(["%$search%"]);
    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
} else {
    // BỔ SUNG: Nếu KHÔNG tìm kiếm, lấy ra TOÀN BỘ sản phẩm trong bảng
    $query = 'SELECT * FROM SANPHAM ORDER BY IDSanPham DESC'; 
    $sth = $conn->prepare($query);
    $sth->execute();
    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
}
?>


<?php include '../partials/header.php'; ?>
   <!-- 3. MAIN BODY (Nội dung chính và Cột bên) -->
    <div class="container main-content">
        <!-- Khu vực hiển thị nội dung chính / Danh sách sản phẩm -->
        <main class="articles">
            <h3>Sản Phẩm Nổi Bật</h3>
          
                
           <?php if (!empty($search)): ?>
            <h2>Kết quả tìm kiếm cho từ khóa: "<span style="color: #007bff;"><?php echo htmlspecialchars($search); ?></span>"</h2>
            <?php else: ?>
                <h2>Tất cả sản phẩm</h2>
            <?php endif; ?>

            <?php if (!empty($products)): ?>
                <div class="grid-products" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-top: 20px;">
                    
                    <?php foreach ($products as $row): ?>
                        <div class="product-card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center;">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
                                <img src="/linhkien/public/images/<?php echo htmlspecialchars($row['HinhAnh'] ?? 'default.jpg'); ?>" style="max-width: 100%; height: 180px; object-fit: contain;">
                                <h3 style="font-size: 16px; margin: 10px 0;"><?php echo htmlspecialchars($row['TenSanPham']); ?></h3>
                                <p style="color: red; font-weight: bold;"><?php echo number_format($row['Gia'], 0, ',', '.'); ?> đ</p>
                            </a>
                        </div>
                    <?php endforeach; ?>

                </div> <?php else: ?>
                <p style="text-align: center; color: #666; margin-top: 50px;">Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
                    
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>

   

  