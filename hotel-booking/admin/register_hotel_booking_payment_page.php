<?php
/*
Plugin Name: Booking Hotel Plugin
Description: A custom plugin for managing hotel bookings.
Version: 1.0
Author: Your Name
*/

// Đảm bảo rằng plugin không thể truy cập trực tiếp
defined('ABSPATH') or die('No script kiddies please!');
// Hàm callback để hiển thị trang thanh toán của plugin
function hotel_booking_payment_page() {
    echo '<h1>Payment</h1>';
    // Hiển thị biểu mẫu thanh toán và xử lý thanh toán ở đây
}

// Hàm để thêm mục con vào mục menu cài đặt chung
function register_hotel_booking_payment_page() {
    add_submenu_page(
        'hotel-booking-settings',       // Slug của trang cài đặt chung
        'Payment',                      // Tiêu đề của trang
        'Payment',                      // Tiêu đề của mục menu
        'manage_options',               // Quyền truy cập cần thiết
        'hotel-booking-payment',        // Slug của trang
        'hotel_booking_payment_page'    // Hàm callback để hiển thị nội dung trang
    );
}

add_action('admin_menu', 'register_hotel_booking_payment_page');
