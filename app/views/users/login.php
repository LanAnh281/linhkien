<?php

include_once "../../../database/connect.php";
session_start();
$error = ''; 

if (isset($_POST['email']) && isset($_POST['matkhau'])) {
    $username = trim($_POST['email']); // Dùng trim() để bỏ dấu cách thừa ở 2 đầu
    $password = trim($_POST['matkhau']);
    
    if (empty($username) || empty($password)) {
        $error = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu!';
    } else {
      // Tìm kiếm tài khoản
        $query = 'SELECT * FROM TAIKHOAN WHERE Email = ? AND Matkhau = ?;';
        
        $sth = $conn->prepare($query);
        $sth->execute([$username, md5($password)]);
        
        // Dùng fetch(PDO::FETCH_ASSOC) để lấy mảng key-value
        if ($row = $sth->fetch(PDO::FETCH_ASSOC)) { 
         
            // Tạo SESSION 
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id']; 
            $_SESSION['logged_in_time'] = time();
            $_SESSION['success_message'] = 'Đăng nhập thành công!';
            
            // Chuyển hướng sang trang chủ
            header('Location: index.php');
            exit(); // Bắt buộc phải có exit() sau header Location
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
        }
    }
}
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
   
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm border">
                    <h2 class="text-center font-weight-bold text-dark mb-5">Đăng nhập</h2>
            <!-- Thông báo lỗi (nếu có) -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mx-3 text-center" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
    <form id="loginForm" action="" method="post">

        <div class="form-group row text-center align-items-center">
            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="name">Họ và tên <span class="text-danger">*</span></label>
            <div class="col-sm-8">           
                <input type="text" class="form-control " 
                id="eamil" placeholder="Nhập địa chỉ email" name="email">
            </div>
        </div>

      <div class="form-group row text-center align-items-center">
            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="matkhau">Mật khẩu <span class="text-danger">*</span></label>
            <div class="col-sm-8">          
                <div class="input-group mx-auto">
                    <input type="password" class="form-control" 
                   id="matkhau" placeholder="Nhập mật khẩu" name="matkhau">
                    <div class="input-group-append">
                    <span class="input-group-text bg-white border-left-0" id="togglePassword" style="cursor: pointer;">
                    <i class="fas fa-eye text-secondary"></i>
                    </span>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="form-group row mt-5 mb-0">
            <div class="col-sm-8 offset-sm-4">
                <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold" name="login" value="login">Đăng nhập</button>
            </div>
        </div>
    </form>
  </div>
</div>
</div>
</div>
       
    <?php include_once "../partials/footer.php"; ?>

</body>
</html>
 <script>
            $(document).ready(function() {
    $('#togglePassword').click(function() {
        var passwordField = $('#matkhau');
        var icon = $(this).find('i');
        
        // Kiểm tra thuộc tính type để chuyển đổi qua lại
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text'); // Hiện mật khẩu
            icon.removeClass('fa-eye').addClass('fa-eye-slash'); // Đổi thành mắt gạch chéo
        } else {
            passwordField.attr('type', 'password'); // Ẩn mật khẩu
            icon.removeClass('fa-eye-slash').addClass('fa-eye'); // Đổi lại thành mắt thường
        }
    });
});

 </script>