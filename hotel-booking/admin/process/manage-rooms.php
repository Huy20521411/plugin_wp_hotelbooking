<?php
    $css_content = file_get_contents(dirname(plugin_dir_path(__FILE__)).'/css/style.css');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" >
    // JavaScript để hiển thị dialog khi nhấp vào nút "Add Room"
    function openAddRoomDialog() {
        // Hiển thị dialog (thay đổi style.display từ 'none' thành 'block')
        document.getElementById('add-room-dialog').style.display = 'block';
    }

    // JavaScript để ẩn dialog khi nhấp vào nút "Cancel" trong dialog
    function closeAddRoomDialog() {
        // Ẩn dialog (thay đổi style.display từ 'block' thành 'none')
        document.getElementById('add-room-dialog').style.display = 'none';
    }

    // JavaScript để xử lý khi nhấn nút "Submit"
    function submitAddRoomForm() {
        // Lấy giá trị từ các trường input
        var roomName = $('#room_name').val();
        var capacity = $('#capacity').val();
        var price = $('#price').val();

        var formData = {
        room_name: roomName,
        capacity: capacity,
        price: price
        };
        // Gửi dữ liệu bằng AJAX
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Thay 'url_xu_ly.php' bằng URL thực tế của bạn
            data:  {
                                action: "insert_room_action",
                                formData: formData
                            },
            dataType: 'json',
            success: function(response) {
                // Xử lý phản hồi từ server sau khi gửi thành công (nếu cần)
                console.log('Dữ liệu đã được gửi thành công:', response);
                // Sau khi gửi thành công, bạn có thể thực hiện các hành động khác, ví dụ: đóng dialog, làm mới trang, hiển thị thông báo, vv.
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                console.error('Đã xảy ra lỗi khi gửi dữ liệu:', status, error);
            }
        });
    }

    function deleteSelectedRooms() {
        var selectedRooms = [];
    
        // Lặp qua tất cả các ô checkbox trong bảng
        $('input[name="selected_rooms[]"]').each(function() {
            // Kiểm tra xem checkbox có được chọn không
            if ($(this).is(':checked')) {
                // Thu thập giá trị của các checkbox được chọn
                selectedRooms.push($(this).val());
            }
        });

        if (selectedRooms.length > 0) {
            // Thực hiện AJAX để gửi các phòng được chọn về máy chủ để xóa
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'delete_room_action', // Định nghĩa action cho việc xóa phòng
                    selected_rooms: selectedRooms // Gửi danh sách các phòng được chọn về máy chủ
                },
                success: function(response) {
                    // Xử lý phản hồi từ máy chủ sau khi xóa thành công (nếu cần)
                    console.log('Các phòng đã được xóa thành công:', response);
                    // Cập nhật giao diện người dùng nếu cần
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu có
                    console.error('Đã xảy ra lỗi khi xóa phòng:', status, error);
                }
            });
        } else {
            // Thông báo cho người dùng nếu không có phòng nào được chọn
            alert('Please select at least one room to delete.');
        }
}


</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your PHP Page</title>
    <!-- Chèn nội dung CSS vào trong thẻ <style> -->
    <style>
        <?php echo $css_content; ?>
    </style>
</head>
<body>
    <!-- Nội dung của trang PHP -->

        <div class="wrap">
            <h1>Manage Rooms</h1>

            <!-- Form để thêm, sửa, xóa phòng -->
            <form method="post" action="">
                <!-- Nút thêm phòng --> 
                <input type="button" name="add_room" value="Add Room" onclick="openAddRoomDialog()">
                <!-- Nút sửa phòng -->
                <input type="submit" name="edit_room" value="Edit Room" onclick="deleteSelectedRooms()">
                <!-- Nút xóa phòng -->
                <input type="submit" name="delete_room" value="Delete Room">
            </form>

            <!-- Danh sách các phòng -->
            <div class="room-list">
                <h2>Rooms</h2>
                <form method="post" action="">
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>ID (INT)</th>
                                <th>Name (VARCHAR)</th>
                                <th>Capacity (INT)</th>
                                <th>Price (DECIMAL)</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room) : ?>
                                <tr>
                                    <td><?php echo $room->room_id; ?></td>
                                    <td><?php echo $room->room_name; ?></td>
                                    <td><?php echo $room->capacity; ?></td>
                                    <td><?php echo $room->price; ?></td>
                                    <td><input type="checkbox" name="selected_rooms[]" value="<?php echo $room->room_id; ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

    <!-- Dialog để thêm phòng -->
    <div id="add-room-dialog" class="dialog overlay-active" style="display: none;">
        <div class="dialog-content">
            <span class="close" onclick="closeAddRoomDialog()">&times;</span>
            <h2>Add Room</h2>
            <form method="post" action="">
                <!-- Các trường để nhập thông tin phòng -->
                <label for="room_name">Room Name:</label>
                <input type="text" id="room_name" name="room_name"><br>

                <label for="capacity">Capacity:</label>
                <input type="text" id="capacity" name="capacity"><br>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price"><br>

                <!-- Nút để submit hoặc cancel -->
                <input type="submit" name="submit_add_room" value="Submit" onclick="submitAddRoomForm()">
                <button type="button" onclick="closeAddRoomDialog()">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
