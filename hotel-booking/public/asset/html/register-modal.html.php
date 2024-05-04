<?php
// HTML cho dialog modal
add_action('wp_footer', 'register_dialog_modal');
function register_dialog_modal() {
    ?>
    <div id="registerModal" style="display: none;">
        <div id="registerModal-content">
            <span class="close">&times;</span>
            <div id="registerForm">
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="custom_hotel_user_register">
                    <input type="text" name="username" placeholder="Username">
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                    <input type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>
    <?php
}

