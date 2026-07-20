<?php 
  include_once "../../../database/connect.php";
    session_start();
    // Lệnh truy vấn dữ liệu - Tìm kiếm danh sách sản phẩm
    $query = '  SELECT  * FROM SANPHAM sp 
                JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                JOIN DANHMUC dm ON sp.danhMucId = dm.danhMucId
                LEFT JOIN GIAMGIA gg ON  sp.giamGiaId = gg.giamGiaId
                LEFT JOIN HINHANHSANPHAM ha ON sp.sanPhamId = ha.sanPhamId 
                WHERE sanPhamId= ?;';
?>

<body>
<?php include '../partials/header.php'; ?>
    
  <h2 class="text-center mt-3">THÔNG TIN CHI TIẾT SẢN PHẨM</h2>
  <?php
    try {  
        $query = 'SELECT  * FROM SANPHAM sp 
                  JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                  JOIN DANHMUC dm ON sp.danhMucId = dm.danhMucId
                  LEFT JOIN GIAMGIA gg ON  sp.giamGiaId = gg.giamGiaId
                  WHERE sp.sanPhamId=?;';
        $sth=$conn->prepare($query);
        $sth->execute([$_GET['sanPhamId']]);
        
        $queryHinhAnh ='SELECT * FROM SANPHAM sp JOIN HINHANHSANPHAM ha ON sp.sanPhamId = ha.sanPhamId WHERE sp.sanPhamID= ?;';
        $sthHinhAnh =$conn->prepare($queryHinhAnh);
        $sthHinhAnh->execute([$_GET['sanPhamId']]);

        echo '
              <div class="row mt-3">
                <div class="col-12 col-md-4">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="height:340px"> ';
                    $isFirst = true; // Biến đánh dấu ảnh đầu tiên  
                    while ($row = $sthHinhAnh->fetch(PDO::FETCH_ASSOC)) { // Thêm kiểu fetch // vòng lặp
                      $activeClass = $isFirst ? 'active' : '';   
                      echo '<div class="carousel-item ' . $activeClass . '">
                              <img style="object-fit:cover; width:100%; height:100%" src="../../../public/' . $row['duongDan'] . '" alt="Slide sản phẩm">
                            </div>';
                            
                      $isFirst = false; // Sau tấm đầu tiên, chuyển biến này thành false để các tấm sau không bị active
                  }
                   echo '         
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>;
                <div class="col-12 mt-2  col-md-8">';
                 while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                  echo '
                  <h3 class="mb-3">Tên sản phẩm:'.$row['tenSanPham'].'</h3>
                  <p>Giá bán lẻ: '.$row['giaBanLe'].'</p>";
                 ';}
                                              
                  //  temp
       }catch (PDOException $e){
        
    }
       ?>
     </div>
        
    </div>
</div>
    <!--  -->
<?php include_once "../partials/footer.php"; ?>
</body>
</body>
</html>