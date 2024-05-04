<?php
// Include WordPress Database Access Abstraction Object
global $wpdb;

// Function to insert a room
function insert_room($room_name, $capacity, $price) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_rooms';

    $data = array(
        'room_name' => $room_name,
        'capacity' => $capacity,
        'price' => $price
    );

    $wpdb->insert($table_name, $data);
}

// Function to update a room
function update_room($room_id, $room_name, $capacity, $price) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_rooms';

    $data = array(
        'room_name' => $room_name,
        'capacity' => $capacity,
        'price' => $price
    );

    $where = array('room_id' => $room_id);

    $wpdb->update($table_name, $data, $where);
}

// Function to delete a room
function delete_room($room_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_rooms';

    $where = array('room_id' => $room_id);

    $wpdb->delete($table_name, $where);
}


// Function to insert a user
function insert_user($username, $email, $password) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_users';

    $data = array(
        'username' => $username,
        'email' => $email,
        'password' => $password
    );

    $wpdb->insert($table_name, $data);
}

// Function to update a user
function update_user($user_id, $username, $email, $password) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_users';

    $data = array(
        'username' => $username,
        'email' => $email,
        'password' => $password
    );

    $where = array('user_id' => $user_id);

    $wpdb->update($table_name, $data, $where);
}

// Function to delete a user
function delete_user($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_users';

    $where = array('user_id' => $user_id);

    $wpdb->delete($table_name, $where);
}

// Function to insert a booking
function insert_booking($room_id, $user_id, $check_in, $check_out, $total_price) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_bookings';

    $data = array(
        'room_id' => $room_id,
        'user_id' => $user_id,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'total_price' => $total_price
    );

    $wpdb->insert($table_name, $data);
    return true;
}

// Function to update a booking
function update_booking($booking_id, $room_id, $user_id, $check_in, $check_out, $total_price) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_bookings';

    $data = array(
        'room_id' => $room_id,
        'user_id' => $user_id,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'total_price' => $total_price
    );

    $where = array('booking_id' => $booking_id);

    $wpdb->update($table_name, $data, $where);
}

// Function to delete a booking
function delete_booking($booking_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_bookings';

    $where = array('booking_id' => $booking_id);

    $wpdb->delete($table_name, $where);
}

// Function to insert a payment
function insert_payment($booking_id, $payment_amount, $payment_status) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_payments';

    $data = array(
        'booking_id' => $booking_id,
        'payment_amount' => $payment_amount,
        'payment_status' => $payment_status
    );

    $wpdb->insert($table_name, $data);
}

// Function to update a payment
function update_payment($payment_id, $booking_id, $payment_amount, $payment_status) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_payments';

    $data = array(
        'booking_id' => $booking_id,
        'payment_amount' => $payment_amount,
        'payment_status' => $payment_status
    );

    $where = array('payment_id' => $payment_id);

    $wpdb->update($table_name, $data, $where);
}

// Function to delete a payment
function delete_payment($payment_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_payments';

    $where = array('payment_id' => $payment_id);

    $wpdb->delete($table_name, $where);
}

// Function to insert a room image
function insert_room_image($room_id, $image_url, $description) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_room_images';

    $data = array(
        'room_id' => $room_id,
        'image_url' => $image_url,
        'description' => $description
    );

    $wpdb->insert($table_name, $data);
}

// Function to update a room image
function update_room_image($image_id, $room_id, $image_url, $description) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_room_images';

    $data = array(
        'room_id' => $room_id,
        'image_url' => $image_url,
        'description' => $description
    );

    $where = array('image_id' => $image_id);

    $wpdb->update($table_name, $data, $where);
}

// Function to delete a room image
function delete_room_image($image_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_room_images';

    $where = array('image_id' => $image_id);

    $wpdb->delete($table_name, $where);
}

// Function to get all rooms
function get_all_rooms() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_rooms';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Function to get room by ID
function get_room_by_id($room_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_rooms';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE room_id = %d", $room_id));
}

// Function to get all users
function get_all_users() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_users';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Function to get user by ID
function get_user_by_id($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_users';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));
}

// Function to get all bookings
function get_all_bookings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_bookings';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Function to get booking by ID
function get_booking_by_id($booking_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_bookings';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE booking_id = %d", $booking_id));
}

// Function to get all payments
function get_all_payments() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_payments';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Function to get payment by ID
function get_payment_by_id($payment_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_payments';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE payment_id = %d", $payment_id));
}

// Function to get all room images
function get_all_room_images() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_room_images';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Function to get room image by ID
function get_room_image_by_id($image_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bookinghotel_room_images';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE image_id = %d", $image_id));
}
?>
