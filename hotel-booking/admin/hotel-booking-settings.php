<?php
// Đảm bảo rằng không ai có thể truy cập trực tiếp vào file này
defined('ABSPATH') or die('No script kiddies please!');

function hotel_booking_plugin_menu() {
    add_menu_page('Hotel Booking Plugin', 'Hotel Booking', 'manage_options', 'hotel-booking-plugin', 'hotel_booking_plugin_page');
}

// Chức năng để hiển thị trang quản lý của plugin
function hotel_booking_plugin_page() {
    echo '<h1>Hotel Booking Plugin</h1>';
    echo '<p>Welcome to the Hotel Booking Plugin management page!</p>';
}

add_action('admin_menu', 'hotel_booking_plugin_menu');


// Thêm các trường cài đặt và xử lý các tùy chọn cài đặt ở đây
