 if (isset($_SESSION['userName'])){ // Nếu đã có tài khoản
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
                            <h5 class="modal-title" id="exampleModalLabel"><h3 class="mb-3">'.$row['tenSanPham'].'</h3></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="chitiet.php" method="post">
                              <div class="modal-body">
                                  <input name="idloai" value='.$row['danhMucId'].' style="display:none">
                                  <p>Tên sản phẩm: '.$row['tenSanPham'].'</p>
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
        if(isset($_GET['danhMucId'])){
          $queryDanhMuc= '  SELECT  * FROM SANPHAM sp 
                JOIN THUONGHIEU th ON sp.thuongHieuId = th.thuongHieuId 
                JOIN DANHMUC dm ON sp.danhMucId = dm.danhMucId
                LEFT JOIN GIAMGIA gg ON  sp.giamGiaId = gg.giamGiaId
                LEFT JOIN HINHANHSANPHAM ha ON sp.sanPhamId = ha.sanPhamId 
                WHERE sp.danhMucId= ?;';
            $sthDanhMuc = $conn->prepare($queryDanhMuc);
            $sthDanhMuc->execute([$_GET['danhMucId']]);
            while ($row = $sthDanhMuc->fetch()){
              echo '
                  <div class="col-12 mb-3 col-md-4 col-lg-3">
                  <a href="product_items.php?sanPhamId='.$row['sanPhamId'].'&danhMucId='.$row['danhMucId'].'" style="text-decoration:none"> 
                  <div class="card">
                  <div class="card-body object text-center" >
                    <img src="'.$row['duongDan'].'" class="img-fluid zoom" style= "height:245px">
                  </div>
                  <div class="card-footer ">
                    '.$row['tenSanPham'].' <br>';
                      $sanPhamId= $row['sanPhamId'];
                  }
                }   
        ?>   
    </div>