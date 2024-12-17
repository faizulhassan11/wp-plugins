```php
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

//learning how to add / save custom information into user's metadata

function wp_plugin_usermeta_form_field_birthday( $user ) {
    ?>
    <h3>It's Your Birthday</h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="birthday">Birthday</label>
            </th>
            <td>
                <input type="date"
                       class="regular-text ltr"
                       id="birthday"
                       name="birthday"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'birthday', true ) ) ?>"
                       title="Please use YYYY-MM-DD as the date format."
                       pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])"
                       required>
                <p class="description">
                    Please enter your birthday date.
                </p>
            </td>
        </tr>
    </table>
    <?php
}

function wp_plugin_usermeta_form_field_birthday_update( $user_id ) {
    // check that the current user have the capability to edit the $user_id
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
 
    // create/update user meta for the $user_id
    return update_user_meta(
        $user_id,
        'birthday',
        $_POST['birthday']
    );
}

// Add the field to user's own profile editing screen.
add_action(
    'show_user_profile',
    'wp_plugin_usermeta_form_field_birthday'
);
 
// Add the field to user profile editing screen.
add_action(
    'edit_user_profile',
    'wp_plugin_usermeta_form_field_birthday'
);
 
// Add the save action to user's own profile editing screen update.
add_action(
    'personal_options_update',
    'wp_plugin_usermeta_form_field_birthday_update'
);
 
// Add the save action to user profile editing screen update.
add_action(
    'edit_user_profile_update',
    'wp_plugin_usermeta_form_field_birthday_update'
);

// leaning Roles and Capabilities

function wp_plugin_simple_role() {
	add_role(
		'proof_reader',
		'Proof Reader',
		array(
			'read'         => true,
			'edit_posts'   => true,
			'upload_files' => true,
		),
	);
}

// Add the simple_role.
add_action( 'init', 'wp_plugin_simple_role' );

// function wp_plugin_simple_role_remove() {
// 	remove_role( 'proof_reader' );
// }

// // Remove the simple_role.
// add_action( 'init', 'wp_plugin_simple_role_remove' );


function wp_plugin_simple_role_caps() {
	// Gets the simple_role role object.
	$role = get_role( 'proof_reader' );

	// Add a new capability.
	$role->add_cap( 'edit_others_posts', true );
}

// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'wp_plugin_simple_role_caps', 11 );