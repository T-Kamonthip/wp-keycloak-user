<?php

// function redirect_to_keycloak_login()
// {
//     if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
//         wp_redirect('http://localhost:8081/realms/wordpress-realm/protocol/openid-connect/auth?client_id=wordpress&response_type=code&scope=openid&redirect_uri=http://localhost:8080/callback');
//         exit;
//     }
// }
// add_action('init', 'redirect_to_keycloak_login');

// add_action('init', function () {
//     if (strpos($_SERVER['REQUEST_URI'], '/callback') !== false) {
//         handle_callback();
//         exit;
//     }
// });

add_action('init', function () {
    if ($_SERVER['REQUEST_URI'] === '/callback') {
        echo '<script>console.log("Callback received");</script>';
        exit;
    }
});

function handle_callback()
{
    if (!isset($_GET['code'])) {
        echo "No code";
        exit;
    }

    $code = $_GET['code'];

    echo "Callback received code: " . $code;

    // 👉 ตรงนี้ค่อยเขียน logic แลก token
}

?>