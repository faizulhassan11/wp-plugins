<?php

 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

// check if the user have submitted the settings
// WordPress will add the "settings-updated" $_GET parameter to the url
if ( isset( $_GET['settings-updated'] ) ) {
    // add settings saved message with the class of "updated"
    add_settings_error( 'wp_plugin_messages', 'wp_plugin_message', __( 'Settings Saved', 'wp_plugin' ), 'updated' );
}

// show error/update messages
settings_errors( 'wp_plugin_messages' );

?>

<div class="wrap">
    <h1>My Plugin Settings Page</h1>
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "submenu"
        settings_fields('submenu');
        // output setting sections and their fields
        // (sections are registered for "submenu", each field is registered to a specific section)
        do_settings_sections('submenu');

        do_action('wp_plugin_after_setting_page_html');  // custom hook
        // output save settings button
        submit_button('Save Settings');
        ?>
    </form>
</div>


