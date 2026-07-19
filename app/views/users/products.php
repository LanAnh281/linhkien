<?php 
  include_once "../../../database/connect.php";
    session_start();
    $query = '  select  sp.TenSanPham, sp.Gia, sp.Hinh1, sp.TenSanPham, sl.SoLuong,s.Ten
    from sanpham sp join soluong sl on sp.IDSanPham = sp.IDSanPham
                  join size s on s.IDSize = sl.IDSize;';
    

?>

<?php include '../partials/header.php'; ?>
    
    <div class="container main-content">
        
        <!-- Khu vực hiển thị nội dung chính / Danh sách sản phẩm -->
        <main class="articles">
            <h3>Danh sách sản phẩm</h3>
             <div class="grid-products">
        <?php
        if(isset($_GET['idloai'])){
            // echo $_GET['idloai'];
            $query = $conn->prepare('SELECT  * FROM sanpham sp  WHERE sp.IDLoai=?');
            $query->execute([$_GET['idloai']]);
                while ($row = $query->fetch()){
                    if($row['TonTai']==='1'){
                    echo '
                        <div class="product-card">
                            <a href="product_items.php?idsp='.$row['IDSanPham'].'&idloai='.$row['IDLoai'].'" style="text-decoration:none">
                                <img src="../../../public/images/logo1.png" class="img-fluid zoom" style= "height:245px">
                                <h4>'.$row['TenSanPham'].'</h4>
                                <p class="price">'.$row['Gia'].'</p>
                            </a>
                        </div>
                  
                    ';}
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