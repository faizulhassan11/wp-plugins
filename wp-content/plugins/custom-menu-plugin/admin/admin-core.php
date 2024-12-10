<?php 
// admins spacific code


// ------------menu page-----------
function wp_plugin_content()
{
    $file_path = plugin_dir_path."admin/plugin-settings.php";
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
        "Sub Menu Title",
        "first submenu", 
       "manage_options",
       "submenu_one",
       "wp_plugin_submenu"
   );

}

// function to Remove the menu button from admin dashboard sidebar

function wp_plugin_remove_menu(){
    remove_menu_page(
        // "my_plugin"
        // "tools.php"
    );

}

// add_action('admin_menu','wp_plugin_remove_menu');


// function wp_plugin_sub_menu(){
//     add_submenu_page(
//          "my_plugin",
//          "Sub Menu Title",
//          "first submenu", 
//         "manage_options",
//         "submenu_one",
//         "wp_plugin_submenu"
//     );
// }


// add_action('admin_menu', 'wp_plugin_submenu');

// --------submenu page------------
function wp_plugin_submenu(){
    ?>
    <div class="wrap">
    <h1>My Submenu</h1>
    <p>This is the settings page for My Plugin.</p>
    </div>
    <?php
}



