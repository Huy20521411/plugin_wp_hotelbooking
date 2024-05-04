<?php
/*
Plugin Name: Booking Hotel Plugin
Description: A custom plugin for managing hotel bookings.
Version: 1.0
Author: 2HUY
*/
// Đảm bảo rằng không ai có thể truy cập trực tiếp vào file này
defined('ABSPATH') or die('No script kiddies please!');

require_once plugin_dir_path(__FILE__) . 'admin/hotel-booking-settings.php';
require_once plugin_dir_path(__FILE__) . 'admin/rooms-management.php'; 

//include_once( plugin_dir_path( __FILE__ ) . 'includes/database/db-functions.php');

// Đăng ký hook khi kích hoạt plugin
register_activation_hook( __FILE__, 'plugin_install_function' );

// Hàm thực thi khi kích hoạt plugin
function plugin_install_function() {
    // Thực hiện các thao tác khi kích hoạt plugin, ví dụ: chạy file install.php
    include_once( plugin_dir_path( __FILE__ ) . 'includes/database/install.php' );
}

require_once plugin_dir_path(__FILE__) . 'admin/process/processing-client.php'; 

// Đăng ký shortcode để hiển thị form đăng nhập
add_shortcode('custom_hotel_login_form', 'render_hotel_login_form');

function render_hotel_login_form() {
    // Thực hiện mã HTML để hiển thị form đăng nhập ở đây
    ob_start();
    ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="custom_hotel_user_login">
        <!-- Thêm các trường đăng nhập ở đây -->
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    </form>
    <?php
    return ob_get_clean();
}


// Xử lý hành động đăng nhập người dùng
add_action('admin_post_custom_hotel_user_login', 'handle_hotel_user_login');

function handle_hotel_user_login() {
    // Kiểm tra xem dữ liệu đã được gửi từ form đăng nhập chưa
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Lấy dữ liệu từ form đăng nhập
        $username = sanitize_text_field( $_POST['username'] );
        $password = $_POST['password']; // Lưu ý: Bạn cần phải xử lý mật khẩu một cách an toàn hơn

        // Thực hiện xác thực người dùng với hệ thống WordPress
        $user = wp_authenticate( $username, $password );

        // Kiểm tra xem xác thực có thành công không
        if ( is_wp_error( $user ) ) {
            echo "<script>alert('Thông tin không chính xác');</script>";
        } else {
            // Xác thực thành công, đặt người dùng hiện tại và cookie xác thực
            wp_set_current_user( $user->ID );
            wp_set_auth_cookie( $user->ID );
            echo "<script>alert('Thông tin chính xác');</script>";
            //wp_redirect( home_url() ); // Chuyển hướng người dùng đến trang chủ
            exit;
        }
    } else {
        // Nếu dữ liệu không được gửi từ form đăng nhập, chuyển hướng người dùng đến trang khác hoặc thực hiện các hành động khác
        wp_redirect( home_url() );
        exit;
    }
}

function load_custom_scripts_and_styles() {
    // Đăng ký CSS
    wp_enqueue_style('custom-register-style', plugin_dir_url(__FILE__) . 'public/asset/css/custom-register.css');

    // Đăng ký JavaScript và phụ thuộc vào thư viện jQuery
    wp_enqueue_script('custom-register-script', plugin_dir_url(__FILE__) . 'public/asset/js/custom-register.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'load_custom_scripts_and_styles');


function load_custom_html() {
    // Đọc nội dung của tập tin HTML
    $html_content = file_get_contents(plugin_dir_path(__FILE__) . 'public/asset/html/custom-html.html');
    
    // Trả về nội dung của tập tin HTML
    echo $html_content;
}

// Đăng ký shortcode 'custom_register_button'
add_shortcode('custom_register_button', 'custom_register_button_shortcode');

// Hàm xử lý shortcode 'custom_register_button'
function custom_register_button_shortcode() {
    // Trả về mã HTML của nút đăng ký
    ob_start(); ?>
    <button id="registerButton">Đăng ký</button>
    <?php
    return ob_get_clean();
}

require_once plugin_dir_path(__FILE__) . 'public/asset/html/register-modal.html.php';

// Xử lý hành động đăng ký người dùng
add_action('admin_post_custom_hotel_user_register', 'handle_hotel_user_register');

function handle_hotel_user_register() {
    // Kiểm tra dữ liệu được gửi từ form đăng ký
    if ( isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']) ) {
        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Kiểm tra mật khẩu và xác nhận mật khẩu có trùng khớp
        if ($password === $confirm_password) {
            // Thực hiện lưu thông tin người dùng vào cơ sở dữ liệu hoặc bất kỳ hành động nào khác
            // Sau đó chuyển hướng người dùng đến trang khác

            insert_user($username,$email,$password);
            wp_redirect(home_url());
            exit;
        } else {
            echo "<script>alert('Password does not match.');</script>";
        }
    } else {
        wp_redirect(home_url());
        exit;
    }
}

// Đăng ký shortcode để hiển thị biểu mẫu tìm kiếm với ngày nhận và ngày trả phòng
add_shortcode('room_search_form', 'render_room_search_form');

function render_room_search_form() {
    ob_start();
    ?>
    <form method="get" action="<?php echo esc_url(home_url('/room-search')); ?>">
        <label for="check_in_date">Ngày nhận phòng:</label>
        <input type="date" id="check_in_date" name="check_in_date" required>

        <label for="check_out_date">Ngày trả phòng:</label>
        <input type="date" id="check_out_date" name="check_out_date" required>

        <!-- Bạn có thể thêm các trường khác như số lượng người,... -->

        <input type="submit" value="Tìm kiếm">
    </form>
    <?php
    return ob_get_clean();
}

// booking page
register_activation_hook(__FILE__, 'create_booking_page');

// tạo trang đặt phòng
function create_booking_page() {
    // Kiểm tra xem trang đã tồn tại chưa trước khi tạo
    $page_title = 'Booking Page';
    $page_slug = 'booking-page';

    $page_exists = get_page_by_title($page_title, 'OBJECT', 'page');

    if ($page_exists == null) {
        // Nếu trang chưa tồn tại, tạo mới
        $page = array(
            'post_title' => $page_title,
            'post_content' => '[booking_hotel_shortcode]', // Thay 'booking_hotel_shortcode' bằng shortcode bạn muốn sử dụng để hiển thị trang booking
            'post_status' => 'publish',
            'post_author' => 1, // ID của tác giả, thay đổi nếu cần
            'post_type' => 'page',
            'post_name' => $page_slug
        );

        // Tạo trang mới và lưu ID của trang
        $page_id = wp_insert_post($page);

        // Lưu trữ ID của trang vào tùy chọn để có thể truy cập sau này
        if ($page_id) {
            update_option('booking_page_id', $page_id);
        }
    }
}

//
register_activation_hook(__FILE__, 'result_search');

// Hàm tạo trang kết quả tìm kiếm
function result_search() {
    // Kiểm tra xem trang đã tồn tại chưa trước khi tạo
    $page_title = 'Result Search';
    $page_slug = 'room-search';

    $page_exists = get_page_by_title($page_title, 'OBJECT', 'page');

    if ($page_exists == null) {
        // Nếu trang chưa tồn tại, tạo mới
        $page = array(
            'post_title' => $page_title,
            'post_content' => '[result_search]', // Thay 'booking_hotel_shortcode' bằng shortcode bạn muốn sử dụng để hiển thị trang booking
            'post_status' => 'publish',
            'post_author' => 1, // ID của tác giả, thay đổi nếu cần
            'post_type' => 'page',
            'post_name' => $page_slug
        );

        // Tạo trang mới và lưu ID của trang
        $page_id = wp_insert_post($page);
    }
}

register_activation_hook(__FILE__, 'booking_confirmation');

// Hàm callback để tạo trang khi kích hoạt plugin
function booking_confirmation() {
    // Kiểm tra xem trang đã tồn tại chưa trước khi tạo
    $page_title = 'Booking Confirmation';
    $page_slug = 'booking-confirmation';

    $page_exists = get_page_by_title($page_title, 'OBJECT', 'page');

    if ($page_exists == null) {
        // Nếu trang chưa tồn tại, tạo mới
        $page = array(
            'post_title' => $page_title,
            'post_content' => '[booking_confirmation_details]', // Thay 'booking_hotel_shortcode' bằng shortcode bạn muốn sử dụng để hiển thị trang booking
            'post_status' => 'publish',
            'post_author' => 1, // ID của tác giả, thay đổi nếu cần
            'post_type' => 'page',
            'post_name' => $page_slug
        );

        // Tạo trang mới và lưu ID của trang
        $page_id = wp_insert_post($page);
    }
}



// Đăng ký shortcode [result_search]
add_shortcode('result_search', 'render_result_search');

// Hàm callback để hiển thị nội dung của shortcode [result_search]
function render_result_search() {
    ob_start();
    // Lấy giá trị của ngày nhận và ngày trả phòng từ URL query string
    $check_in_date = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : '';
    $check_out_date = isset($_GET['check_out_date']) ? $_GET['check_out_date'] : '';
    ?>
    <p>Ngày nhận phòng: <?php echo $check_in_date; ?></p>
    <p>Ngày trả phòng: <?php echo $check_out_date; ?></p>

    <?php
    // Kiểm tra xem có ngày nhận và ngày trả hợp lệ không
    if ($check_in_date && $check_out_date) {
        // Lấy danh sách các phòng trống trong khoảng thời gian này
        $available_rooms = get_available_rooms($check_in_date, $check_out_date);

        // Hiển thị danh sách các phòng trống
        if ($available_rooms) {
            echo '<h2>Các phòng trống:</h2>';
            foreach ($available_rooms as $room) {
                // Lấy thông tin chi tiết của phòng từ cơ sở dữ liệu
                $room_info = get_room_by_id($room->room_id);
                if ($room_info) {
                    render_room_tab($room_info, $check_in_date, $check_out_date);
                }
            }
        } else {
            echo '<p>Không có phòng trống trong khoảng thời gian đã chọn.</p>';
        }
        
    } else {
        echo '<p>Vui lòng chọn ngày nhận và ngày trả phòng.</p>';
    }

    return ob_get_clean();
}


// Hàm để lấy danh sách các phòng trống trong khoảng thời gian được yêu cầu
function get_available_rooms($checkin_date, $checkout_date) {
    global $wpdb;
    $table_bookings = $wpdb->prefix . 'bookinghotel_bookings';
    $table_rooms = $wpdb->prefix . 'bookinghotel_rooms';

    // Truy vấn cơ sở dữ liệu để lấy danh sách các phòng trống
    $query = $wpdb->prepare("
        SELECT room_id 
        FROM $table_rooms 
        WHERE room_id NOT IN (
            SELECT room_id FROM $table_bookings 
            WHERE check_in <= %s AND check_out >= %s
        )
    ", $checkout_date, $checkin_date);

    $available_rooms = $wpdb->get_results($query);

    return $available_rooms;
}

function render_room_tab($room_info, $check_in_date, $check_out_date) {

    ?>
    <div class="room-tab">
        <input type="radio" id="tab-<?php echo $room_info->room_id; ?>" name="tabs">
        <label for="tab-<?php echo $room_info->room_id; ?>">
            <div class="room-image">
                <!-- Đây là nơi để hiển thị hình ảnh phòng -->
            </div>
            <div class="room-info">
                <h3><?php echo $room_info->room_name; ?></h3>
                <p>Sức chứa: <?php echo $room_info->capacity; ?></p>
                <p>Giá: <?php echo $room_info->price; ?></p>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(add_query_arg(array('room_id' => $room_info->room_id, 'check_in_date' => $check_in_date, 'check_out_date' => $check_out_date), home_url('/booking-confirmation'))); ?>" class="book-now-button">Đặt chỗ</a>


                <?php else : ?>
                    <a href="<?php echo esc_url(wp_login_url(add_query_arg('room_id', $room_info->room_id, home_url('/booking-confirmation')))); ?>" class="book-now-button">Đăng nhập để đặt chỗ</a>
                <?php endif; ?>
            </div>
        </label>

        <div class="tab-content">
            <div id="tab-<?php echo $room_info->room_id; ?>-content">
                <!-- Đây là nơi để hiển thị thông tin chi tiết về phòng, nếu cần -->
            </div>
        </div>
    </div>
    <style>
        .room-tab {
            border: 1px solid #ccc; /* Thêm viền 1px và màu sắc xám nhạt */
            border-radius: 4px; /* Bo tròn góc */
            margin-bottom: 10px; /* Khoảng cách dưới cùng giữa các tab */
            padding: 10px; /* Khoảng cách bên trong của tab */
        }

        .book-now-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }
        .book-now-button:hover {
            background-color: #0056b3;
        }
    </style>
    <?php
}

//detail booking_confirmation
add_shortcode('booking_confirmation_details', 'render_booking_confirmation_details');

function render_booking_confirmation_details() {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (is_user_logged_in()) {
        // Lấy thông tin người dùng hiện tại
        $current_user = wp_get_current_user();
        // Hiển thị thông tin người dùng
        echo '<h2>Thông tin người đặt chỗ:</h2>';
        echo '<p>Tên người đặt chỗ: ' . $current_user->display_name . '</p>';
        echo '<p>Email: ' . $current_user->user_email . '</p>';

        // Lấy room_id từ URL
        $room_id = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);
        $room_id = ($room_id !== false && $room_id !== null) ? $room_id : 0;

        //lấy ngày
        $check_in_date = filter_input(INPUT_GET, 'check_in_date', FILTER_SANITIZE_STRING);
        $check_out_date = filter_input(INPUT_GET, 'check_out_date', FILTER_SANITIZE_STRING);


        // Kiểm tra xem room_id có hợp lệ không
        if ($room_id > 0) {
            // Truy xuất thông tin chi tiết về phòng từ cơ sở dữ liệu hoặc từ các biến khác
            $room_info = get_room_by_id($room_id); // Ví dụ: Hàm get_room_info_by_id lấy thông tin từ cơ sở dữ liệu

            // Hiển thị thông tin phòng
            if ($room_info) {
                echo '<h2>Thông tin phòng:</h2>';
                echo '<p>Tên phòng: ' . $room_info->room_name . '</p>';
                echo '<p>Sức chứa: ' . $room_info->capacity . '</p>';
                echo '<p>Giá: ' . $room_info->price . '</p>';
                echo '<p>Ngày ở: ' . $check_in_date . '</p>';
                echo '<p>Ngày trả phòng: ' . $check_out_date . '</p>';
            } else {
                echo '<p>Không tìm thấy thông tin phòng.</p>';
            }
        } else {
            echo '<p>Room ID không hợp lệ.</p>';
        }

        // Nút "Xác nhận đặt chỗ"
        echo '<form method="post" action="">'; // Trả về cùng trang hiện tại
        echo '<input type="hidden" name="room_id" value="' . esc_attr($room_id) . '">';
        echo '<input type="submit" name="confirm_booking" value="Xác nhận đặt chỗ">';
        echo '</form>';
    } else {
        // Nếu người dùng chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
        echo '<p>Vui lòng đăng nhập để xem thông tin đặt chỗ.</p>';
        echo '<a href="' . esc_url(wp_login_url()) . '">Đăng nhập</a>';
    }

    // Kiểm tra nếu có yêu cầu xác nhận đặt phòng được gửi đi
    if (isset($_POST['confirm_booking'])) {
        // Xác thực dữ liệu ở đây nếu cần thiết

         // Lấy room_id từ URL
         $room_id = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);
         $room_id = ($room_id !== false && $room_id !== null) ? $room_id : 0;
 
         //lấy ngày
         $check_in_date = filter_input(INPUT_GET, 'check_in_date', FILTER_SANITIZE_STRING);
         $check_out_date = filter_input(INPUT_GET, 'check_out_date', FILTER_SANITIZE_STRING);
        // Lấy thông tin người dùng hiện tại
        $current_user = wp_get_current_user();

        // Kiểm tra xem room_id và người dùng có tồn tại không
        if ($room_id > 0 && $current_user->ID) {

            $room_info = get_room_by_id($room_id);
            $user_id = $current_user->ID;


            // Gọi hàm lưu thông tin đặt phòng vào cơ sở dữ liệu
            $success = insert_booking($room_id,$user_id, $check_in_date, $check_out_date,$room_info->price); // Ví dụ: Hàm save_booking_data lưu dữ liệu vào cơ sở dữ liệu

            if ($success) {
                echo '<p>Đặt chỗ thành công!</p>';
            } else {
                echo '<p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>';
            }
        } else {
            echo '<p>Dữ liệu không hợp lệ.</p>';
        }
    }
    
}





























