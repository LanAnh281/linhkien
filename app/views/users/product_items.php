<?php 
  include_once "../../../database/connect.php";
  session_start();
?>

<body>
<?php include '../partials/header.php'; ?>

<div class="container mt-4">
  <h2 class="text-center mt-3">THÔNG TIN CHI TIẾT SẢN PHẨM</h2>

  <?php
  try {  
      // 1. Lấy thông tin chi tiết của 1 sản phẩm
      $query = 'SELECT sp.*, th.tenThuongHieu, dm.tenDanhMuc 
                FROM SANPHAM sp 
                JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                JOIN DANHMUC dm ON sp.danhMucId = dm.danhMucId
                LEFT JOIN GIAMGIA gg ON sp.giamGiaId = gg.giamGiaId
                WHERE sp.sanPhamId = ?;';
      
      $sth = $conn->prepare($query);
      $sth->execute([$_GET['sanPhamId']]);
      $product = $sth->fetch(PDO::FETCH_ASSOC); // Lấy duy nhất 1 bản ghi

      if ($product) {
          // 2. Lấy danh sách hình ảnh của sản phẩm này
          $queryHinhAnh = 'SELECT * FROM HINHANHSANPHAM WHERE sanPhamId = ?;';
          $sthHinhAnh = $conn->prepare($queryHinhAnh);
          $sthHinhAnh->execute([$_GET['sanPhamId']]);
          $images = $sthHinhAnh->fetchAll(PDO::FETCH_ASSOC);
  ?>

      <div class="row mt-4">
        <!-- Cột hiển thị hình ảnh (Carousel) -->
        <div class="col-12 col-md-5">
          <div id="productCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" style="height:340px">
              <?php 
              if (!empty($images)) {
                  $isFirst = true;
                  foreach ($images as $img) {
                      $activeClass = $isFirst ? 'active' : '';
                      echo '<div class="carousel-item ' . $activeClass . '">
                              <img style="object-fit:cover; width:100%; height:340px" src="../../../public/' . $img['duongDan'] . '" class="d-block w-100" alt="Ảnh sản phẩm">
                            </div>';
                      $isFirst = false;
                  }
              } else {
                  echo '<div class="carousel-item active">
                          <img style="object-fit:cover; width:100%; height:340px" src="../../../public/uploads/default.jpg" class="d-block w-100" alt="No Image">
                        </div>';
              }
              ?>
            </div>
            
            <?php if (count($images) > 1): ?>
              <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Cột hiển thị thông tin sản phẩm -->
        <div class="col-12 col-md-7 mt-3 mt-md-0">
          <h3 class="mb-3">Tên sản phẩm: <?= htmlspecialchars($product['tenSanPham']) ?></h3>
          <p><strong>Thương hiệu:</strong> <?= htmlspecialchars($product['tenThuongHieu']) ?></p>
          <p><strong>Giá bán lẻ:</strong> <?= number_format($product['giaBanLe']) ?> VNĐ</p>
          <p><strong>Giá bán sỉ:</strong> <?= number_format($product['giaBanSi']) ?> VNĐ</p>

          <div class="mt-4">
            <?php if (isset($_SESSION['userName'])): ?>
              <!-- Nút Thêm vào giỏ hàng (Mở Modal) -->
              <button type="button" class="btn btn-outline-dark mr-2" data-toggle="modal" data-target="#addToCartModal">
                <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng
              </button>

              <!-- Nút Mua ngay -->
              <a href="pay.php?sanPhamId=<?= $product['sanPhamId'] ?>" class="btn btn-warning">
                <i class="fa-solid fa-bolt"></i> Mua ngay
              </a>

              <!-- Modal Giỏ hàng -->
              <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalLabel">Thêm vào giỏ hàng</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="cart.php" method="post">
                      <div class="modal-body">
                        <input type="hidden" name="danhMucId" value="<?= $product['danhMucId'] ?>">
                        <input type="hidden" name="ttsp" value="<?= $product['sanPhamId'] ?>">
                        <p>Bạn có muốn thêm <strong><?= htmlspecialchars($product['tenSanPham']) ?></strong> vào giỏ hàng không?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận thêm</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php else: ?>
              <!-- Chưa đăng nhập -->
              <a href="registration.php" class="btn btn-outline-dark mr-2">
                <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng
              </a>
              <a href="registration.php" class="btn btn-warning">
                <i class="fa-solid fa-bolt"></i> Mua ngay
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

  <?php 
      } else {
          echo '<div class="alert alert-danger text-center">Không tìm thấy sản phẩm!</div>';
      }
  } catch (PDOException $e) {
      echo '<div class="alert alert-danger">Lỗi truy vấn: ' . $e->getMessage() . '</div>';
  }
  ?>

  <!-- Sản phẩm liên quan -->
  <hr class="mt-5">
  <h3 class="mb-4">Sản phẩm liên quan</h3>
  <div class="row">
    <?php
    $danhMucId = $_GET['danhMucId'] ?? ($product['danhMucId'] ?? null);

    if ($danhMucId) {
        // Truy vấn lấy danh sách sản phẩm cùng danh mục + 1 hình ảnh đại diện (ảnh nhỏ nhất)
        $queryDanhMuc = 'SELECT sp.*, ha.duongDan, th.tenThuongHieu
                         FROM SANPHAM sp 
                         JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                         LEFT JOIN HINHANHSANPHAM ha ON ha.hinhAnhId = (
                             SELECT MIN(hinhAnhId) 
                             FROM HINHANHSANPHAM 
                             WHERE sanPhamId = sp.sanPhamId
                         )
                         WHERE sp.danhMucId = ? AND sp.sanPhamId != ?
                         ORDER BY sp.sanPhamId DESC LIMIT 4;';
            
        $sthDanhMuc = $conn->prepare($queryDanhMuc);
        $sthDanhMuc->execute([$danhMucId, $_GET['sanPhamId']]);

        while ($related = $sthDanhMuc->fetch(PDO::FETCH_ASSOC)) {
            $imgSrc = !empty($related['duongDan']) ? $related['duongDan'] : 'uploads/default.jpg';
    ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <a href="product_items.php?sanPhamId=<?= $related['sanPhamId'] ?>&danhMucId=<?= $related['danhMucId'] ?>" class="text-decoration-none text-dark"> 
              <div class="card h-100 shadow-sm">
                <div class="card-body text-center p-2">
                  <img src="../../../public/<?= $imgSrc ?>" class="img-fluid zoom" style="height:200px; object-fit:contain;">
                </div>
                <div class="card-footer bg-white">
                  <h6 class="card-title font-weight-bold text-truncate"><?= htmlspecialchars($related['tenSanPham']) ?></h6>
                  <p class="card-text text-danger font-weight-bold mb-0"><?= number_format($related['giaBanLe']) ?> VNĐ</p>
                </div>
              </div>
            </a>
          </div>
    <?php 
        }
    } 
    ?>   
  </div>
</div>

<?php include_once "../partials/footer.php"; ?>
</body>
</html>