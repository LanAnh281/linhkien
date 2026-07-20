<?php 
  include_once "../../../database/connect.php";
    session_start();
    
    

?>

<?php include '../partials/header.php'; ?>
    
    <div class="container main-content">
        
        <!-- Khu vực hiển thị nội dung chính / Danh sách sản phẩm -->
        <main class="articles">
            <h3>Danh sách sản phẩm</h3>
             <div class="grid-products">
        <?php
        
        if(isset($_GET['danhMucId'])){
            $query = 'SELECT  sp.tenSanPham, sp.sanPhamId,sp.giaBanLe, sp.giaBanSi, sp.soLuongTon, th.tenThuongHieu, dm.tenDanhMuc, dm.danhMucId, gg.phanTram, gg.ngayBatDau, gg.ngayKetThuc FROM SANPHAM sp 
                    JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                    JOIN DANHMUC dm ON sp.danhMucId = dm.danhMucId
                    LEFT JOIN GIAMGIA gg ON  sp.giamGiaId = gg.giamGiaId
                    
                    WHERE sp.danhMucId=?;';
            $sth=$conn->prepare($query);
            $sth->execute([$_GET['danhMucId']]);
            while ($row = $sth->fetch()){
                    echo '
                        <div class="product-card">

                            <a href="product_items.php?sanPhamId='.$row['sanPhamId'].'&danhMucId='.$row['danhMucId'].'" style="text-decoration:none">
                                <img src="" class="img-fluid zoom" style= "height:245px">
                                <h4>'.$row['tenSanPham'].'</h4>
                                <p class="price">'.$row['tenThuongHieu'].''.$row['sanPhamId'].'</p>
                                <p class="price">'.$row['giaBanLe'].'</p>
                                <p class="price">'.$row['soLuongTon'].'</p>
                                <p class="price">'.$row['phanTram'].'</p>
                                
                            </a>
                        </div>
                  
                    ';
                }   
            };
        ?>   
        
</div>
        
    </div>
</div>
    <!--  -->
<?php include_once "../partials/footer.php"; ?>
</body>
</html>