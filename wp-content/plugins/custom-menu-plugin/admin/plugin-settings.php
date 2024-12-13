<?php

// Check user capabilities
if (!current_user_can('manage_options')) {
    return;
}

// Check if the user has submitted the settings
// WordPress will add the "settings-updated" $_GET parameter to the URL
if (isset($_GET['settings-updated'])) {
    // Add settings saved message with the class of "updated"
    add_settings_error('wp_plugin_messages', 'wp_plugin_message', __('Settings Saved', 'wp_plugin'), 'updated');
}

// Show error/update messages
settings_errors('wp_plugin_messages');

?>

<div class="wrap">
    <h1><?php esc_html_e('My Plugin Settings Page', 'wp_plugin'); ?></h1>
    <form action="options.php" method="post">
        <?php
        // Output security fields for the registered setting "submenu"
        settings_fields('submenu');
        // Output setting sections and their fields
        // (sections are registered for "submenu", each field is registered to a specific section)
        do_settings_sections('submenu');

        do_action('wp_plugin_after_setting_page_html');  // Custom hook
        // Output save settings button
        submit_button(__('Save Settings', 'wp_plugin'));
        ?>
    </form>
</div>
