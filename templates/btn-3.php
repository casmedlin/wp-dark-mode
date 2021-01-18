<?php

$is_floating = isset( $floating ) && 'yes' == $floating;
$position    = wp_dark_mode_get_settings( 'wp_dark_mode_switch', 'switcher_position', 'right_bottom' );

?>
<input type="checkbox" id="wp-dark-mode-switch" class="wp-dark-mode-switch">
<div class="wp-dark-mode-switcher wp-dark-mode-ignore  style-3 <?php echo $is_floating ? "floating $position" : ''; ?>">

    <img class="sun-light" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-3/sun-light.png'; ?>" alt="Light">
    <img class="sun-dark" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-3/sun-dark.png'; ?>" alt="Dark">
    <label for="wp-dark-mode-switch"><div class="toggle"></div></label>
    <img class="moon-dark" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-3/moon-dark.png'; ?>" alt="Dark">
    <img class="moon-light" src="<?php echo WP_DARK_MODE_ASSETS.'/images/btn-3/moon-light.png'; ?>" alt="Light">

</div>