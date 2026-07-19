<?php 
include_once "../../../database/connect.php";

// Thay thế đoạn require vendor/autoload.php bằng đoạn này:
require $_SERVER['DOCUMENT_ROOT'] . '/linhkien/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


  

session_start();

  $error = '';
  $success = '';
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])){
    //làm sạch dữ liệu đầu vào
    $name     = trim($_POST['name']);
    $address  = trim($_POST['adress'] ?? ''); 
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
   
    //Dữ liệu mặc định
    $queryVaiTro = 'SELECT * FROM VAITRO WHERE tenVaiTro ="user" ;';
    $sthVaiTro = $conn ->prepare($queryVaiTro);
    $sthVaiTro->execute();
    $role =$sthVaiTro->fetchColumn();
    $status = '1';
    $query =    'INSERT INTO NGUOIDUNG (hoTen, email, matKhau, soDienThoai, trangThai, DiaChi,vaiTroId)
                VALUES (?,?,?,?,?,?,?)';
      try{
        $sth = $conn->prepare($query);
        $sth->execute([$name,$email,$password, $phone, $status, $address, $role]);
        $success = 'Đăng ký tài khoản thành công!';
      
        //Chuyển sang trang đăng nhập 
        header("refresh:2; url=login.php");

        // Khởi tạo đối tượng PHPMailer
        $mail = new PHPMailer(true);

        try {
            // --- CẤU HÌNH SERVER SMTP CỦA GMAIL ---
            $mail->isSMTP();                                            // Sử dụng SMTP để gửi mail
            $mail->Host       = 'smtp.gmail.com';                       // Server SMTP của Gmail
            $mail->SMTPAuth   = true;                                   // Bật xác thực SMTP
            $mail->Username   = 'anh626801@gmail.com';                  // Tài khoản Gmail của bạn
            $mail->Password   = 'qhjr klyj nqsc snjv';                  // Mật khẩu ứng dụng 16 ký tự vừa tạo ở Bước 1
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Mã hóa TLS (Khuyên dùng)
            $mail->Port       = 587;                                    // Cổng kết nối TLS (nếu dùng SSL thì cổng 465)
            $mail->CharSet    = 'UTF-8';                                // Cấu hình font chữ tiếng Việt không bị lỗi

            // --- CẤU HÌNH NGƯỜI GỬI & NGƯỜI NHẬN ---
            $mail->setFrom('anh626801@gmail.com', 'CTY TM');
            $mail->addAddress($email, $name); // Thêm người nhận
            // $mail->addReplyTo('info@example.com', 'Information');     // (Tùy chọn) Email nhận phản hồi

            // --- CẤU HÌNH NỘI DUNG EMAIL ---
            $mail->isHTML(true);                                        // Cho phép gửi định dạng HTML
            // --- CẤU HÌNH NGƯỜI NHẬN ---
            $mail->addAddress($email, $name); // Gửi tới email của người đăng ký

            // --- CẤU HÌNH NỘI DUNG EMAIL XÁC NHẬN ---
            $mail->isHTML(true); // Thiết lập gửi mail định dạng HTML

            // 1. Tiêu đề Email
            $mail->Subject = '🎉 Đăng ký tài khoản thành công tại [Tên Website của bạn]';

            // 2. Nội dung Email (Sử dụng HTML/CSS inline để hiển thị đẹp mắt trên mọi thiết bị)
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                <div style="background-color: #4CAF50; padding: 20px; text-align: center; color: white;">
                    <h2 style="margin: 0; font-size: 24px;">Chúc mừng đăng ký thành công!</h2>
                </div>
                
                <div style="padding: 30px; line-height: 1.6; color: #333333;">
                    <p>Xin chào <strong>' . htmlspecialchars($name) . '</strong>,</p>
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại hệ thống của chúng tôi. Tài khoản của bạn đã được khởi tạo thành công và sẵn sàng sử dụng.</p>
                    
                    <div style="background-color: #f9f9f9; border-left: 4px solid #4CAF50; padding: 15px; margin: 20px 0;">
                        <p style="margin: 0 0 8px 0;"><strong>Thông tin đăng nhập của bạn:</strong></p>
                        <p style="margin: 0 0 5px 0;">• <strong>Email đăng nhập:</strong> ' . htmlspecialchars($email) . '</p>
                    </div>
                    
                    <p>Hãy đăng nhập vào hệ thống và bắt đầu trải nghiệm ngay:</p>
                    
                    
                    
                    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                    <p style="font-size: 12px; color: #777;">Nếu nút trên không hoạt động, bạn có thể copy và dán đường dẫn này vào trình duyệt: <br>' . $login_url . '</p>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #777;">
                    <p style="margin: 0;">Đây là email tự động, vui lòng không phản hồi email này.</p>
                    <p style="margin: 5px 0 0 0;">© ' . date('Y') . ' [Tên Công Ty/Website của bạn]. All rights reserved.</p>
                </div>
            </div>
            ';

            // 3. Nội dung thuần (AltBody) dành cho các trình đọc mail cũ không hỗ trợ HTML
            $mail->AltBody = "Xin chào " . $username . ",\n\nChúc mừng bạn đã đăng ký tài khoản thành công!\nThông tin đăng nhập:\n- Tên đăng nhập: " . $username . "\n- Email: " .$email . "\n\nTruy cập vào link sau để đăng nhập: " . $login_url;

                        // Tiến hành gửi
                        $mail->send();
                        echo 'Email đã được gửi thành công!';
                        
                    } catch (Exception $e) {
                        echo "Không thể gửi được email. Chi tiết lỗi: {$mail->ErrorInfo}";
                    }
                }
                catch (PDOException $e){
                    $error = 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau!';
                }
            }
?>

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
                            <label class="col-sm-4 font-weight-bold text-secondary mb-sm-0" for="phone">SĐT <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="SĐT của bạn" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>" />
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
                phone: {
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
                phone: "Bạn nhập sai sdt",
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