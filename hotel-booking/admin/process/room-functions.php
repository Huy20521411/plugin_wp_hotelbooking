<?php
// Xử lý thêm phòng
function hotel_booking_add_room() {
     // Kiểm tra nếu action là add và là phương thức GET
     if (isset($_GET['action']) && $_GET['action'] === 'add' && $_SERVER["REQUEST_METHOD"] == "GET") {
        // Hiển thị form thêm phòng
        include_once(plugin_dir_path(dirname(__FILE__)) . 'dialog/add-room-dialog.php');
    }
}

// Xử lý xóa phòng
function hotel_booking_delete_room() {
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['room_id'])) {
        $room_id = $_GET['room_id'];
        // Xử lý logics xóa phòng ở đây
        // Ví dụ:
        // - Kiểm tra quyền truy cập và tính hợp lệ của room_id
        // - Xóa phòng từ cơ sở dữ liệu
        // - Redirect hoặc hiển thị thông báo sau khi xóa thành công
    }
}