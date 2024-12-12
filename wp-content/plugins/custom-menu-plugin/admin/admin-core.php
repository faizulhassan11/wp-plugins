<?php
// admins spacific code


// ------------menu page-----------
function wp_plugin_content()
{
    $file_path = plugin_dir_path . "admin/plugin-dashboard.php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo 'File not found: ' . $file_path;

    }

}

add_action('admin_menu', 'wp_plugin_menu_button');

// ---------add menu and submenu----------
function wp_plugin_menu_button()
{
    add_menu_page(
        'My Plugin Title',
        'My Plugin',
        'manage_options',     // only show admin page
        'my_plugin',
        'wp_plugin_content',
        'dashicons-admin-generic',
        20
    );
    add_submenu_page(
        "my_plugin",
        "Dashboard",
        "Dashboard",
        "manage_options",
        "my_plugin",
        "wp_plugin_content"
    );

    add_submenu_page(
        "my_plugin",
        "Settings",
        "Settings",
        "manage_options",
        "submenu",
        "wp_plugin_setting_page_content"
    );

}

// function to Remove the menu button from admin dashboard sidebar

function wp_plugin_remove_menu()
{
    remove_menu_page(
        // "my_plugin"
        // "tools.php"
    );

}

// add_action('admin_menu','wp_plugin_remove_menu');




// --------submenu page------------
function wp_plugin_submenu()
{
    ?>
    <div class="wrap">
        <h1>My Submenu</h1>
        <p>This is the settings page for My Plugin.</p>
    </div>
    <?php
}





// custom setting page
// section content cb
function wp_plugin_my_plugin_settings()
{
    register_setting('submenu', 'wp_plugin_setting');

    // register a new section in the "submenu" page
    add_settings_section(
        'wp_plugin_settings_section',
        'My Plugin Settings Section',
        'wp_plugin_settings_section_callback',
        'submenu'
    );

    // register a new field in the "wp_plugin_settings_section" section, inside the "submenu" page
    add_settings_field(
        'wp_plugin_settings_field',
        'My Plugin Settings ',
        'wp_plugin_settings_field_callback',
        'submenu',
        'wp_plugin_settings_section'
    );
}

function wp_plugin_settings_section_callback()
{
    echo '<p>This is WP PLugin Setting Section </p>';
}

// field content cb
function wp_plugin_settings_field_callback()
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('wp_plugin_setting');
    // output the field
    ?>
    <input type="text" name="wp_plugin_setting" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
    <?php
}

add_action('admin_init', 'wp_plugin_my_plugin_settings');



// custom setting page

function wp_plugin_setting_page_content()
{   
    
  

   $file_path = plugin_dir_path . "admin/plugin-settings.php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo 'File not found: ' . $file_path;

    }

}



