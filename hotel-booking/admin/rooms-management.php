<?php
// Đảm bảo rằng không ai có thể truy cập trực tiếp vào file này
defined('ABSPATH') or die('No script kiddies please!');

function hotel_booking_rooms_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    include_once( plugin_dir_path( __FILE__ ) . 'db-functions.php' );

    // Thực hiện xử lý thêm, sửa, xóa phòng nếu được yêu cầu
    if (isset($_POST['add_room'])) {
        // Xử lý thêm phòng ở đây
    } elseif (isset($_POST['edit_room'])) {
        // Xử lý sửa phòng ở đây
    } elseif (isset($_POST['delete_room'])) {
        // Xử lý xóa phòng ở đây
    }

    // Lấy danh sách các phòng từ cơ sở dữ liệu
    $rooms = get_all_rooms();

    require_once (plugin_dir_path(__FILE__) . 'process/manage-rooms.php');
}





// Đăng ký trang quản lý phòng vào menu của WordPress
function register_hotel_booking_rooms_page() {
    add_submenu_page(
        'hotel-booking-plugin',   // Slug của trang cha (trang cài đặt chung)
        'Manage Rooms',             // Tiêu đề của trang
        'Manage Rooms',             // Tiêu đề của mục menu
        'manage_options',           // Quyền truy cập cần thiết
        'hotel-booking-rooms',      // Slug của trang
        'hotel_booking_rooms_page'  // Hàm callback để hiển thị nội dung trang
    );
}

// Đăng ký trang vào menu của WordPress khi admin menu được tạo
add_action('admin_menu', 'register_hotel_booking_rooms_page');
