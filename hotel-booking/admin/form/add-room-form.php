<?php
// Kiểm tra quyền của người dùng
?>

<div class="wrap">
    <h1>Add New Room</h1>
    <form method="post" action="">
        <label for="room_name">Room Name:</label>
        <input type="text" id="room_name" name="room_name" required><br><br>
        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity" required><br><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>
        <input type="submit" name="submit_add_room" value="Add Room" class="button button-primary">
    </form>
</div>
