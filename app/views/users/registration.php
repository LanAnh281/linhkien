<?php 
  include_once "../../../database/connect.php";
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
   
    <div class="card mt-5">
        <div class="card-header">
            <h3 class="text-center">Đăng ký thành viên</h3>
        </div>
        <div class="card-body">
            <form id="signupForm" action="signin.php" method="post" class="form-horizontal" action="#">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="name">Họ và tên</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên của bạn" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="diachi">Địa chỉ</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="diachi" name="diachi"
                            placeholder="Địa chỉ của bạn" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="username">SĐT</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="sdt" name="sdt" placeholder="SĐT của bạn" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="email">Hộp thư điện tử</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Hộp thư điện tử" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="password">Mật khẩu</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Mật khẩu" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="confirm_password">Nhập lại mật khẩu</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            placeholder="Nhập lại mật khẩu" />
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-5 offset-sm-4">
                        <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Đăng ký</button>
                    </div>
                </div>

            </form>
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
    </script>
   
<?php include_once "../partials/footer.php"; ?>

</body>
</html>