<?php
include_once(plugin_dir_path(dirname(__FILE__)) . 'db-functions.php');

add_action('wp_ajax_insert_room_action', 'insert_room_action_callback');
add_action('wp_ajax_nopriv_insert_room_action', 'insert_room_action_callback');

add_action('wp_ajax_delete_room_action', 'delete_room_action_callback');
add_action('wp_ajax_nopriv_delete_room_action', 'delete_room_action_callback');

function insert_room_action_callback() {
    header("Content-Type: application/json", true);
    // Kiểm tra xem request có hợp lệ không
    if (isset($_POST['formData'])) {
        // Trích xuất dữ liệu từ formData
        $formData = $_POST['formData'];

        // Thực hiện các thao tác xử lý dữ liệu ở đây
        $roomName = $formData['room_name'];
        $capacity = $formData['capacity'];
        $price = $formData['price'];

        // Ví dụ: Lưu dữ liệu vào cơ sở dữ liệu hoặc thực hiện các thao tác khác ở đây
        insert_room($roomName,$capacity,$price);

        // Trả về phản hồi cho frontend
        wp_send_json_success('Data processed successfully.');
    } else {
        // Nếu request không hợp lệ, trả về lỗi
        wp_send_json_error('Invalid request.');
    }

    // Kết thúc AJAX callback
    wp_die();
}

function delete_room_action_callback()
{
    header("Content-Type: application/json", true);

    // Kiểm tra xem yêu cầu AJAX có hợp lệ không
    if (isset($_POST['selected_rooms']) && is_array($_POST['selected_rooms'])) {
        $selected_rooms = $_POST['selected_rooms'];

        // Thực hiện các thao tác xóa phòng trong cơ sở dữ liệu cho từng phòng được chọn
        foreach ($selected_rooms as $room_id) {
            delete_room($room_id);
        }

        // Trả về phản hồi cho phía frontend
        wp_send_json_success('Rooms deleted successfully.');
    } else {
        // Nếu yêu cầu không hợp lệ, trả về lỗi
        wp_send_json_error('Invalid request.');
    }
}


?>
