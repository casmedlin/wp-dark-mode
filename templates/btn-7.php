<?php

$is_floating = isset( $floating ) && 'yes' == $floating;
$position    = wp_dark_mode_get_settings( 'wp_dark_mode_display', 'switcher_position', 'right_bottom' );

?>
<input type="checkbox" id="wp-dark-mode-switch" class="wp-dark-mode-switch">
<div class="wp-dark-mode-switcher wp-dark-mode-ignore  style-7 <?php echo $is_floating ? "floating $position" : ''; ?>">

    <label for="wp-dark-mode-switch">
        <div class="toggle"></div>
        <div class="modes">
            <img class="light" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-7/sun.png'; ?>">
            <img class="dark" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-7/moon.png'; ?>">
        </div>
    </label>

</div>