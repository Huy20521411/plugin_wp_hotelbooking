<?php

add_action('init', 'my_custom_function');

function my_custom_function() {
    if (is_user_logged_in()) {
        // Thực hiện các hành động dành cho người dùng đã đăng nhập
        
        // Tạo một mảng chứa thông tin của trang mới
        $new_page = array(
            'post_title'    => 'Tiêu đề trang mới',
            'post_content'  => 'Nội dung của trang mới',
            'post_status'   => 'publish', // Trạng thái của trang: publish (công bố), draft (bản nháp), pending (chờ duyệt), ...
            'post_author'   => 1, // ID của tác giả (người viết bài), thay đổi thành ID của tài khoản tác giả mong muốn
            'post_type'     => 'page', // Loại bài viết: post (bài viết), page (trang), ...
        );

        // Thêm trang mới vào cơ sở dữ liệu
        $page_id = wp_insert_post($new_page);

        // Kiểm tra xem việc thêm trang mới thành công hay không
        if ($page_id) {
            echo "Trang mới đã được tạo thành công. ID của trang mới là: " . $page_id;
        } else {
            echo "Đã xảy ra lỗi khi thêm trang mới.";
        }

        
    } else {
        // Thực hiện các hành động dành cho người dùng chưa đăng nhập
    }
}


