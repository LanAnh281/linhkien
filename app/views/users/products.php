<?php 
  include_once "./database.php";
    session_start();
    $query = '  select  sp.TenSanPham, sp.Gia, sp.Hinh1, sp.TenSanPham, sl.SoLuong,s.Ten
    from sanpham sp join soluong sl on sp.IDSanPham = sp.IDSanPham
                  join size s on s.IDSize = sl.IDSize;';
    

?>
<?php include_once "../partials/header.php"; ?>
    
    <div class="row mt-5">
        <?php
        if(isset($_GET['idloai'])){
            // echo $_GET['idloai'];
            $query = $conn->prepare('  select  *
                        from sanpham sp 
                            where sp.IDLoai=?           ');
           
            
                 $query->execute([$_GET['idloai']]);
                while ($row = $query->fetch()){
                    if($row['TonTai']==='1'){
                    echo '
                        <div class="col-12 mb-3 col-md-4 col-lg-3">
                            <a href="chitiet.php?idsp='.$row['IDSanPham'].'&idloai='.$row['IDLoai'].'" style="text-decoration:none"> 
                            <div class="card">
                                <div class="card-body object text-center" >
                                    <img src="'.$row['Hinh1'].'" class="img-fluid zoom" style= "height:245px">
                                </div>
                                <div class="card-footer ">
                                '.$row['TenSanPham'].' <br>';
                    $idsp= $row['IDSanPham'];
                                $query_size=$conn->prepare('select * from SANPHAM sp 
                                                join SOLUONG sl on sp.IDSanPham=sl.IDSanPham
                                                join SIZE s on s.IDSize=sl.IDSize
                                                where sp.IDSanPham=?;');
                                
                                $query_size->execute([$idsp]);

                                echo '<span class="my-2">Size:</span>';
                                while ($row_size=$query_size->fetch()){
                                    echo '
                                     <span>'.$row_size['Ten'].' &ensp; </span>
                    
                                    ';
                                }
                                    
                                   echo '
                                    
                                    <p style="color: red;">Giá: '.$row['Gia'].' &ensp;</p>
                                </div>
                            </div>
                            </a>
                        </div>
                    ';}
                }   
            };
        ?>   
        
        
        
    </div>
    <!--  -->
<?php include_once "../partials/footer.php"; ?>
</body>
</html>