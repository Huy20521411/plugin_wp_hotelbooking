<?php
// Kiểm tra quyền của người dùng hoặc các điều kiện khác nếu cần
?>

<div id="addRoomDialog" class="dialog" style="display: block;">
    <style>
        /* CSS cho dialog */
        .dialog {
            display: block;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .dialog-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <div class="dialog-content">
        <span class="close" onclick="closeDialog()">&times;</span>
        <h1>Add New Room</h1>
        <form method="post" action="" id="addRoomForm">
            <label for="room_name">Room Name:</label>
            <input type="text" id="room_name" name="room_name" required><br><br>
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required><br><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required><br><br>
            <input type="submit" name="submit_add_room" value="Add Room" class="button button-primary">
        </form>
    </div>

    <script>
        // JavaScript cho dialog
        function openDialog() {
            document.getElementById("addRoomDialog").style.display = "block";
        }

        function closeDialog() {
            document.getElementById("addRoomDialog").style.display = "none";
        }
    </script>
</div>
