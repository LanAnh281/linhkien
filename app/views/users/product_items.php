<?php 
  include_once "../../../database/connect.php";
    session_start();
    // Lệnh truy vấn dữ liệu - Tìm kiếm danh sách sản phẩm
    $query = '  SELECT sp.TenSanPham, sp.Gia, sp.Hinh1, sp.TenSanPham, sl.SoLuong,s.Ten
                FROM sanpham sp JOIN soluong sl 
                ON sp.IDSanPham = sp.IDSanPham
                JOIN size s ON s.IDSize = sl.IDSize;';
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

<body>
<?php include '../partials/header.php'; ?>
    
  <h2 class="text-center mt-3">THÔNG TIN CHI TIẾT SẢN PHẨM</h2>
    <?php
        $query = "SELECT * FROM sanpham  WHERE idsanpham = '".$_GET['idsp']."'";// Tìm kiếm thông tin sản phẩm
    try {
        $sth = $conn->query($query); //thực thi câu lệnh
        while ($row = $sth->fetch()){ // vòng lặp
            echo '
              <div class="row mt-3">
                <div class="col-12 col-md-4">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="height:340px">
                      <div class="carousel-item active">
                        <img  style="object-fit:cover; width:100%; height:100%"  src="'.$row['Hinh1'].'" alt="First slide">
                      </div>
                      <div class="carousel-item">
                        <img  style="object-fit:cover; height:100%"  src="'.$row['Hinh2'].'" alt="Second slide">
                      </div>
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
                </div>
                
                <div class="col-12 mt-2  col-md-8">
                  <h3 class="mb-3">'.$row['TenSanPham'].'</h3>
                  <p>Độ mới: '.$row['DoMoi'].'</p>';
                  $idsp= $row['IDSanPham'];
                  $query_size=$conn->prepare('SELECT * FROM SANPHAM sp 
                                  JOIN SOLUONG sl ON sp.IDSanPham=sl.IDSanPham
                                  JOIN SIZE s ON s.IDSize=sl.IDSize
                                  WHERE sp.IDSanPham=?;');
                  $query_size->execute([$idsp]);
                    while ($row_size=$query_size->fetch()){
                        echo '<p>Size: '.$row_size['Ten'].' &ensp; Số lượng: '.$row_size['SoLuong'].' &ensp; </p>';
                        }
                    echo '  <p>Chất liệu: '.$row['ChatLieu'].'</p>
                            <p>Xuất sứ: '.$row['XuatSu'].'</p>
                            <p>Giá: '.$row['Gia'].' </p>';                            
                    if (isset($_SESSION['IDTK'])){ // Nếu đã có tài khoản
                    echo '
                    <!-- Button trigger modal -->
                    <button button type="button" class="btn btn-outline-dark my-3" data-toggle="modal" data-target="#exampleModal">
                      <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><h3 class="mb-3">'.$row['TenSanPham'].'</h3></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="chitiet.php" method="post">
                              <div class="modal-body">
                                  <input name="idloai" value='.$row['IDLoai'].' style="display:none">
                                  <p>Độ mới: '.$row['DoMoi'].'</p>
                                  <div class="form-group" style="display:flex; justify-items: center;">
                                    <label for="exampleFormControlSelect1">Size</label>
                                    <select class="form-control" name="size" id="exampleFormControlSelect1">
                            ';
                                  $idsp= $row['IDSanPham'];
                                  $query_size=$conn->prepare('select * from SANPHAM sp 
                                                  join SOLUONG sl on sp.IDSanPham=sl.IDSanPham
                                                  join SIZE s on s.IDSize=sl.IDSize
                                                  where sp.IDSanPham=?;');
                                  $query_size->execute([$idsp]);
                                  while ($row_size=$query_size->fetch()){
                                      echo '
                                          <option value="'.$row_size['Ten'].'"  >'.$row_size['Ten'].'</option>';}

                                      echo '
                                       </select>
                                      </div>
                                      
                                      <div>
                                      Số lượng:'.$row_size['SoLuong'].'
                                        <input min="1" max="'.$row_size['SoLuong'].'" type="number"  name="soluong">
                                      </div>  
                                      ';
                                  
                                  
                                echo '
                                <p>Chất liệu: '.$row['ChatLieu'].'</p>
                                <p>Xuất sứ: '.$row['XuatSu'].'</p>
                                <p>Giá: '.$row['Gia'].' </p>
                                <hr>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
                                <input type="text" name="ttsp" value="'.$row['IDSanPham'].'" hidden>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>';
                
              }
            else { // Nếu không có tài khoản
              echo '
              <a href= "registration.php" style="text-decoration:none">
              <i class="fa-solid fa-cart-shopping"></i>
            Thêm vào giỏ hàng</a>';
              
          } 
          // ------
            echo '
            </button>
            <button type="button" class="btn btn-warning my-3">';
                
               if (isset($_SESSION['IDTK'])){
                echo '
              <a style="text-decoration: none" href="muangay.php?masp='.$idsp.'">
                <i class="fa-solid fa-cart-shopping"></i>
              Mua ngay
              </a>';

               }
               else {
                echo '
                <a href="dangky.php" style="text-decoration: none" >
                  <i class="fa-solid fa-cart-shopping"></i>
                Mua ngay
                </a>';
               }
            echo '
            </button>
                </div>
              </div>';
            
        }   
    } catch (PDOException $e){
        
    }

  ?>
    <hr class="mt-5">
    <h3>Sản phẩm liên quan</h3>
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

    <?php include_once "../partials/footer.php"; ?>
</body>
</html>