<?php  include_once "../../../../database/connect.php"; 
    session_start();
    // Khởi tạo mảng chứa danh sách sản phẩm tìm được
    $products = [];
    $error = '';
    $search = '';
    try {
        $query =   'SELECT  sp.TenSanPham, sp.Gia, sp.Hinh1, sp.TenSanPham, sl.SoLuong,s.Ten
                    FROM sanpham sp join soluong sl ON sp.IDSanPham = sp.IDSanPham
                    JOIN size s on s.IDSize = sl.IDSize;';
        $sth = $conn->prepare($query);
        $sth->execute();
        $products = $sth->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Throwable $th) {
        //throw $th;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ </title>
    <link rel="stylesheet" href="../../../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>
<style>
    /* Style cho bảng sản phẩm */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 15px;
}

.product-table th, 
.product-table td {
    padding: 14px 18px;
    border-bottom: 1px solid #eeeeee;
}

.product-table th {
    background-color: #f4f6f9;
    color: #333;
    font-weight: 600;
}

.product-table tbody tr:hover {
    background-color: #f9fbfd;
}

/* Định dạng cột số lượng & canh giữa các cột ngắn */
.text-center { text-align: center; }

/* Các nút hành động (Icon) */
.action-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.btn-icon {
    text-decoration: none;
    font-size: 16px;
    transition: transform 0.2s;
    display: inline-block;
}

.btn-icon:hover {
    transform: scale(1.2);
}

/* Màu sắc gợi ý cho từng hành động */
.btn-view { color: #2ecc71; }   /* Xanh lá - Xem chi tiết */
.btn-edit { color: #f1c40f; }   /* Vàng - Sửa */
.btn-delete { color: #e74c3c; } /* Đỏ - Xóa */
    /* Nền mờ bao phủ toàn màn hình */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Nền đen mờ 50% */
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 9999; /* Luôn nằm trên cùng */
}

/* Kích hoạt hiển thị modal */
.modal-overlay.show {
    opacity: 1;
    pointer-events: auto;
}

/* Hộp thoại chính */
.modal-box {
    background: #fff;
    width: 500px;
    max-width: 90%;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Header, Body, Footer của Modal */
.modal-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.close-btn { font-size: 24px; cursor: pointer; color: #aaa; }
.close-btn:hover { color: #333; }

.modal-body { padding: 20px; }

/* CSS cho Form bên trong */
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #444; }
.form-input {
    width: 100%; padding: 10px;
    border: 1px solid #ccc; border-radius: 4px;
    font-size: 14px;
}
.form-input:disabled { background-color: #f5f5f5; color: #777; }

.modal-footer {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn { padding: 9px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
.btn-secondary { background: #e0e0e0; color: #333; }
.btn-primary { background: #2980b9; color: white; }
</style>
</head>
<body>
<div class="app-container">
        
        <!-- NHÚNG SIDEBAR CỐ ĐỊNH (3 phần) -->
        <?php include_once '../../partials/sidebar.php'; ?>

        <!-- KHU VỰC HIỂN THỊ CHÍNH (9 phần) -->
        <div class="main-wrapper">
            
            <!-- NHÚNG NAVBAR CỐ ĐỊNH (Thông tin tài khoản & Thông báo) -->
            <?php include_once '../../partials/navbar.php'; ?>
            <!-- Nội dung thực tế của trang index.php -->
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Quản lý sản phẩm</h2>
                    <a href="add.php" class="btn btn-success"><i class="fas fa-plus mr-2"></i>Thêm sản phẩm</a>
                </div>            
                <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">STT</th>
                            <th width="15%">Mã sản phẩm</th>
                            <th width="40%">Tên sản phẩm</th>
                            <th width="15%" class="text-center">Số lượng</th>
                            <th width="25%" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sản phẩm 1 -->
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $row): ?>
                        <tr>
                            <!-- Ví dụ sửa lại thẻ <td> chứa icon của Sản phẩm 1 -->
                                <td class="text-center">1</td>
                                <td><strong><?php echo htmlspecialchars($row['TenSanPham']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['TenSanPham']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($row['TenSanPham']); ?></td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <!-- Xem chi tiết: Truyền chế độ 'view' -->
                                        <a href="javascript:void(0)" class="btn-icon btn-view" title="Xem chi tiết" 
                                        onclick="openModal('view', {id: 1, code: 'SP-001', name: 'Cà phê Arabica Cầu Đất', quantity: 120})">👁️</a>
                                        
                                        <!-- Sửa: Truyền chế độ 'edit' -->
                                        <a href="javascript:void(0)" class="btn-icon btn-edit" title="Sửa sản phẩm" 
                                        onclick="openModal('edit', {id: 1, code: 'SP-001', name: 'Cà phê Arabica Cầu Đất', quantity: 120})">✏️</a>
                                        
                                        <a href="#" class="btn-icon btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" title="Xóa">🗑️</a>
                                    </div>
                                </td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            <!-- Cấu trúc Modal (Hộp thoại ẩn) -->
                <!-- MODAL XEM CHI TIẾT -->
                <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Thông tin sản phẩm</h5></div>
                            <div class="modal-body">
                                <p><strong>Tên:</strong> <span id="view-name"></span></p>
                                <p><strong>Giá:</strong> <span id="view-price"></span> đ</p>
                                <p><strong>Mô tả:</strong> <span id="view-desc"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL SỬA SẢN PHẨM -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="process.php" method="POST" class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Chỉnh sửa sản phẩm</h5></div>
                            <div class="modal-body">
                                <!-- Input ẩn để lưu ID sản phẩm cần sửa -->
                                <input type="hidden" name="product_id" id="edit-id">
                                
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" name="name" id="edit-name" class="form-group form-control">
                                </div>
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" name="price" id="edit-price" class="form-group form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="action" value="update" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- MODAL XÁC NHẬN XÓA -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="process.php" method="POST" class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Xác nhận xóa</h5></div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" id="delete-id">
                                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="delete-name"></strong> không?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Đồng ý xóa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
        </div>

 <?php include '../../partials/footer.php'; ?>
   
</body>

</html>
<script>
$(document).ready(function() {
    const modal = document.getElementById('productModal');
    const formInputs = document.querySelectorAll('.form-input');
    const btnSubmit = document.getElementById('btnSubmitForm');
    const modalTitle = document.getElementById('modalTitle');

    // Hàm mở Modal
    function openModal(mode, data) {
        // 1. Điền dữ liệu sản phẩm vào các ô input
        document.getElementById('prodId').value = data.id;
        document.getElementById('prodCode').value = data.code;
        document.getElementById('prodName').value = data.name;
        document.getElementById('prodQuantity').value = data.quantity;

        // 2. Tùy biến giao diện theo chế độ Xem hay Sửa
        if (mode === 'view') {
            modalTitle.innerText = "Chi tiết sản phẩm";
            btnSubmit.style.display = "none"; // Xem chi tiết thì ẩn nút Lưu đi
            formInputs.forEach(input => input.disabled = true); // Khóa không cho gõ
        } else if (mode === 'edit') {
            modalTitle.innerText = "Cập nhật sản phẩm";
            btnSubmit.style.display = "block"; // Hiện nút Lưu để sửa
            formInputs.forEach(input => input.disabled = false); // Mở khóa cho gõ
        }

        // 3. Hiển thị modal bằng cách thêm class 'show'
        modal.classList.add('show');
    }

    // Hàm đóng Modal
    function closeModal() {
        modal.classList.remove('show');
        document.getElementById('productForm').reset(); // Xóa sạch dữ liệu cũ trong form khi đóng
    }

    // Đóng modal khi click ra vùng ngoài hộp thoại đen mờ
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }  
    // Xử lý khi nhấn nút Xem
    $('.btn-view').click(function() {
        $('#view-name').text($(this).data('name'));
        $('#view-price').text($(this).data('price'));
        $('#view-desc').text($(this).data('desc'));
        $('#viewModal').modal('show'); // Mở bùng modal lên
    });

    // Xử lý khi nhấn nút Sửa
        $('.btn-edit').click(function() {
        $('#edit-id').val($(this).data('id'));
        $('#edit-name').val($(this).data('name'));
        $('#edit-price').val($(this).data('price'));
        $('#editModal').modal('show');
    });

    // Xử lý khi nhấn nút Xóa
    $('.btn-delete').click(function() {
        $('#delete-id').val($(this).data('id'));
        $('#delete-name').text($(this).data('name'));
        $('#deleteModal').modal('show');
    });
});
</script>
    


   

  