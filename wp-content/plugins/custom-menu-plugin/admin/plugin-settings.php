<?php 



echo plugins_url();  //  http://localhost/wp-plugins/wp-content/plugins
echo "<br>";
echo plugins_url('script.js',__FILE__);  //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/script.js
echo "<br>";
echo plugins_url('',__FILE__);   //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/
echo "<br>";
echo plugin_dir_url(__FILE__);  // it add slash in last  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin
echo "<br>";
echo plugin_dir_path( __DIR__ );  // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/
echo "<br>";
echo plugin_dir_path( __FILE__ );  // //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/
echo "<br>";


echo plugin_dir_path;  // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/
echo "<br>";
echo plugin_dir_path.'uninstall.php'; // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/uninstall.php
echo "<br>";
echo plugin_url;  //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin


echo "<br>";
echo plugin_dir_url;  // http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/
?>
<div class="wrap">
    <h1>My Plugin Settings</h1>
    <p>This is the settings page for My Plugin.</p>
</div>


