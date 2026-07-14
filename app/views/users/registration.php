<?php 
  include_once "../../../database/connect.php";
    require 'vendor/autoload.php'; 
  session_start();

  $error = '';
  $success = '';
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])){
    //làm sạch dữ liệu đầu vào
    $name     = trim($_POST['name']);
    $address  = trim($_POST['adress'] ?? ''); 
    $email    = trim($_POST['email']);
    $sdt      = trim($_POST['sdt']);
    $password = trim($_POST['password']);
   
    //Dữ liệu mặc định
    $vaiTro = 'user';
    $hanDung = '1';
     $query = ' INSERT INTO TAIKHOAN (HoTen, DiaChi, email, SDT, MatKhau, vaiTro,HanDung)
      VALUES (?,?,?,?,?,?,?)';
      try{
        $sth = $conn->prepare($query);
        $sth->execute([
          $name,
                $address,
                $email,
                $sdt,
                md5($password), 
                $vaiTro,
                $hanDung
        ]);
        $success = 'Đăng ký tài khoản thành công!';
      

// Khai báo sử dụng các lớp của PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

        //Chuyển sang trang đăng nhập 
        header("refresh:2; url=login.php");
    }
    catch (PDOException $e){
        $error = 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau!';
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
                    
                    <h2 class="text-center font-weight-bold text-dark mb-5">Đăng ký thành viên</h2>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center mb-4"><?= $error ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success text-center mb-4"><?= $success ?></div>
                    <?php endif; ?>

                    <form id="signupForm" action="" method="post">

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="name">Họ và tên <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên của bạn" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" />
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="adress">Địa chỉ</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="adress" name="adress" rows="3" placeholder="Địa chỉ của bạn"><?= isset($address) ? htmlspecialchars($address) : '' ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="sdt">SĐT <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="sdt" name="sdt" placeholder="SĐT của bạn" value="<?= isset($sdt) ? htmlspecialchars($sdt) : '' ?>" />
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="email">Hộp thư điện tử <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Hộp thư điện tử" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
                            </div>
                        </div>

                       <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="password">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" />
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white border-left-0 toggle-password" style="cursor: pointer;" data-target="#password">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="confirm_password">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" />
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white border-left-0 toggle-password" style="cursor: pointer;" data-target="#confirm_password">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mt-5 mb-0">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold" name="registration" value="Registration">Đăng ký</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../../public/js/jquery.validate.js"></script>

    <script type="text/javascript">

    </script>
    <script type="text/javascript">
    $.validator.setDefaults({
        submitHanler: function() {
            alert('submitted');
        }
    });
    $(document).ready(function() {
        $("#signupForm").validate({
            rules: {
                name: "required",
                diachi: {
                    required: true,
                    minlength: 10
                },
                sdt: {
                    required: true,
                    number: true,
                    rangelength: [10, 10]
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: '#password'
                }
            },

            messages: {
                name: "Bạn cần điền họ và tên",
                diachi: "Bạn không được để trống địa chỉ",
                sdt: "Bạn nhập sai sdt",
                email: "Bạn nhập sai email",
                password: "Bạn phải điền mật khẩu",
                confirm_password: "Mật khẩu không khớp với mật khẩu đã nhập"
            },


            highlight: function(element, errorClass, valiClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, valiClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });

    });
    $(document).ready(function() {
    // Logic xử lý ẩn/hiện mật khẩu khi bấm vào con mắt
    $('.toggle-password').click(function() {
        // Lấy ID của ô input cần đổi qua thuộc tính data-target
        var targetInput = $(this).attr('data-target');
        var inputField = $(targetInput);
        var icon = $(this).find('i');

        // Kiểm tra loại của input để chuyển đổi
        if (inputField.attr('type') === 'password') {
            inputField.attr('type', 'text'); // Hiện mật khẩu
            icon.removeClass('fa-eye').addClass('fa-eye-slash'); // Đổi icon thành mắt gạch chéo
        } else {
            inputField.attr('type', 'password'); // Ẩn mật khẩu
            icon.removeClass('fa-eye-slash').addClass('fa-eye'); // Đổi icon lại thành mắt thường
        }
    });
});
    </script>
   
<?php include_once "../partials/footer.php"; ?>

</body>
</html>