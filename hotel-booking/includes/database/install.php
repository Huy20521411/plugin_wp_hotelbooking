<?php
// Hàm được gọi khi plugin được kích hoạt
function my_plugin_install() {
    global $wpdb;

    // Tên bảng và tiền tố
    $table_rooms = $wpdb->prefix . 'bookinghotel_rooms';
    $table_bookings = $wpdb->prefix . 'bookinghotel_bookings';
    $table_users = $wpdb->prefix . 'bookinghotel_users';
    $table_payments = $wpdb->prefix . 'bookinghotel_payments';
    $table_room_images = $wpdb->prefix . 'bookinghotel_room_images';

    // Tạo bảng Rooms
    $sql_rooms = "CREATE TABLE IF NOT EXISTS $table_rooms (
        room_id INT NOT NULL AUTO_INCREMENT,
        room_name VARCHAR(100) NOT NULL,
        capacity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY (room_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql_rooms);

    // Tạo bảng Users
    $sql_users = "CREATE TABLE IF NOT EXISTS $table_users (
        user_id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        PRIMARY KEY (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql_users);

    // Tạo bảng Bookings
    $sql_bookings = "CREATE TABLE IF NOT EXISTS $table_bookings (
        booking_id INT NOT NULL AUTO_INCREMENT,
        room_id INT NOT NULL,
        user_id INT NOT NULL,
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY (booking_id),
        FOREIGN KEY (room_id) REFERENCES $table_rooms(room_id),
        FOREIGN KEY (user_id) REFERENCES $table_users(user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql_bookings);

        // Tạo bảng Payments
    $sql_payments = "CREATE TABLE IF NOT EXISTS $table_payments (
        payment_id INT NOT NULL AUTO_INCREMENT,
        booking_id INT NOT NULL,
        payment_amount DECIMAL(10, 2) NOT NULL,
        payment_status ENUM('paid', 'unpaid', 'cancelled') NOT NULL,
        PRIMARY KEY (payment_id),
        FOREIGN KEY (booking_id) REFERENCES $table_bookings(booking_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql_payments);
    

    // Tạo bảng Room_Images
    $sql_room_images = "CREATE TABLE IF NOT EXISTS $table_room_images (
        image_id INT NOT NULL AUTO_INCREMENT,
        room_id INT NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        description TEXT,
        PRIMARY KEY (image_id),
        FOREIGN KEY (room_id) REFERENCES $table_rooms(room_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql_room_images);
}

my_plugin_install();
