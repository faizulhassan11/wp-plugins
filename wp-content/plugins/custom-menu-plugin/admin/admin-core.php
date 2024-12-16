<?php
// Admin-specific code

// ------------ Menu Page -----------
function wp_plugin_content() {
    $file_path = plugin_dir_path . "admin/plugin-dashboard.php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo esc_html('File not found: ' . $file_path);
    }
}

add_action('admin_menu', 'wp_plugin_menu_button');

// --------- Add Menu and Submenu ----------
function wp_plugin_menu_button() {
    add_menu_page(
        __('My Plugin Title', 'wp_plugin'),
        __('My Plugin', 'wp_plugin'),
        'manage_options',     // Only show admin page
        'my_plugin',
        'wp_plugin_content',
        'dashicons-admin-generic',
        20
    );
    add_submenu_page(
        "my_plugin",
        __('Dashboard', 'wp_plugin'),
        __('Dashboard', 'wp_plugin'),
        "manage_options",
        "my_plugin",
        "wp_plugin_content"
    );

    add_submenu_page(
        "my_plugin",
        __('Settings', 'wp_plugin'),
        __('Settings', 'wp_plugin'),
        "manage_options",
        "submenu",
        "wp_plugin_setting_page_content"
    );
}

// Function to Remove the Menu Button from Admin Dashboard Sidebar
function wp_plugin_remove_menu() {
    remove_menu_page(
        // "my_plugin"
        // "tools.php"
    );
}

// add_action('admin_menu','wp_plugin_remove_menu');

// -------- Submenu Page ------------
function wp_plugin_submenu() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('My Submenu', 'wp_plugin'); ?></h1>
        <p><?php esc_html_e('This is the settings page for My Plugin.', 'wp_plugin'); ?></p>
    </div>
    <?php
}

// Custom Setting Page
// Section Content Callback
function wp_plugin_my_plugin_settings() {
    register_setting('submenu', 'wp_plugin_setting');

    // Register a new section in the "submenu" page
    add_settings_section(
        'wp_plugin_settings_section',
        __('My Plugin Settings Section', 'wp_plugin'),
        'wp_plugin_settings_section_callback',
        'submenu'
    );

    // Register a new field in the "wp_plugin_settings_section" section, inside the "submenu" page
    add_settings_field(
        'wp_plugin_settings_field',
        __('My Plugin Settings', 'wp_plugin'),
        'wp_plugin_settings_field_callback',
        'submenu',
        'wp_plugin_settings_section'
    );
}

function wp_plugin_settings_section_callback() {
    echo '<p>' . __('This is WP Plugin Setting Section', 'wp_plugin') . '</p>';
}

// Field Content Callback
function wp_plugin_settings_field_callback() {
    // Get the value of the setting we've registered with register_setting()
    $setting = get_option('wp_plugin_setting');
    // Output the field
    ?>
    <input type="text" name="wp_plugin_setting" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
    <?php
}

add_action('admin_init', 'wp_plugin_my_plugin_settings');

// Custom Setting Page
function wp_plugin_setting_page_content() {
    $file_path = plugin_dir_path . "admin/plugin-settings.php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo esc_html('File not found: ' . $file_path);
    }
}


// enqueuing admin js file

add_action('admin_enqueue_scripts','wp_plugin_script_admin_files');

function wp_plugin_script_admin_files() {
    // Enqueue admin-specific JavaScript file
   wp_enqueue_script('admin-script',plugin_dir_url.'/admin/js/admin.js',array('jquery'),'1.0.0',true);

   wp_localize_script(
	'admin-script',
	'wp_plugin_ajax_obj',  // wp_plugin_ajax_obj.nonce  ,  wp_plugin_ajax_obj.ajax_url
	array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce('wp_plugin_ajax_example')
    )
);
    
}