<?php

/**
 * Task: Posts shown on frontend - edit button - redirect to the post edit screen
 */

//  $username = $POST['username'];
//  $password = $POST['password'];
//  $website = $POST['website'];

// $username = 'Ali Raza';
// $password = '12345';
// $website = 'https://raza.com';
// $first_name = 'Ali';
// $last_name = 'Raza';

// $user_data = [
//     'user_login' => $username,
//     'user_pass' => $password,
//     'user_url' => $website,
//     'first_name' => $first_name,
//     'last_name' => $last_name
// ];

// $user_id = wp_insert_user($user_data);

// if (!is_wp_error($user_id)) {
//     echo "User created : " . $user_id;
// }

//  update user

//  $user_id = 2;
// $website = 'https://wordpress.org';

// $user_id = wp_update_user(
// 	array(
// 		'ID'       => $user_id,
// 		'user_url' => $website,
// 	)
// );

// if ( !is_wp_error( $user_id ) ) {
//     echo "User updated : ".$user_id;
// } else {
//     echo "Failed to update user";
// }


// delete user

// $user_id = 4;

// $user_id = wp_delete_user(
//     $user_id

// );

// if (!is_wp_error($user_id)) {
//     echo "User Deleted : " . $user_id;
// } else {
//     echo "Failed to Delete user";
// }

// ------------- HTTP API ----------------

// $response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
// $response = wp_remote_get( 'https://api.github.com/users/blobaugh' ,
//     array(
//         'method'=>'GET'
//     )
// );
// $body     = wp_remote_retrieve_body( $response );

// echo "<pre>";
// var_dump($response);



// echo "<pre>";
// var_dump($body);

// $response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
// $http_code = wp_remote_retrieve_response_code( $response );


// echo "<pre>";
// var_dump($http_code);


// $response      = wp_remote_get( 'https://api.github.com/users/blobaugh' );
// $last_modified = wp_remote_retrieve_header( $response, 'last-modified' );

// echo "<pre>";
// var_dump($last_modified);



$response      = wp_remote_get( 'https://api.github.com/users/blobaugh' );
$headers_data = wp_remote_retrieve_headers( $response );

echo "<pre>";
var_dump($headers_data);




?>

<div class="wrap">
    <h1><?php esc_html_e('Dashboard', 'wp_plugin'); ?></h1>
    <p><?php esc_html_e('This is a test plugin to learn WordPress plugin development', 'wp_plugin'); ?></p>
    <button id="get_total_projects">Get Total Books</button>
    <p id="project_response"></p>
</div>