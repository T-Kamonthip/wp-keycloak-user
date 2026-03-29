<?php
function kc_get_token()
{

    $response = wp_remote_post(
        'http://keycloak:8080/realms/master/protocol/openid-connect/token',
        [
            // 'body' => [
            //     'client_id' => 'admin-cli',
            //     'username' => 'admin',
            //     'password' => 'Zara@123',
            //     'grant_type' => 'password'
            // ]
            'body' => [
                'client_id' => 'wordpress-api',
                'client_secret' => 'MS20s3dQyMhv0Hv51j8GsDcM6vkuUViq',
                'grant_type' => 'client_credentials'
            ]
        ]
    );

    // echo '<script>console.log(' . json_encode($response) . ');</script>';
    $body = json_decode(wp_remote_retrieve_body($response));

    echo '<script>console.log(' . json_encode($body) . ');</script>';

    echo '<script>console.log(' . json_encode(kc_decode_jwt($body->access_token)) . ');</script>';

    return $body->access_token;
}

function kc_get_users()
{

    $token = kc_get_token();

    // echo '<script>console.log(' . json_encode($token) . ');</script>';

    $response = wp_remote_get(
        'http://keycloak:8080/admin/realms/wordpress-realm/users',
        [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]
    );

    return json_decode(wp_remote_retrieve_body($response));
}

function kc_get_users_detail($id)
{

    $token = kc_get_token();

    $response = wp_remote_get(
        "http://keycloak:8080/admin/realms/wordpress-realm/users/$id",
        [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]
    );

    return json_decode(wp_remote_retrieve_body($response));
}

function kc_create_user($data)
{

    $token = kc_get_token();

    wp_remote_post(
        'http://keycloak:8080/admin/realms/wordpress-realm/users',
        [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]
    );
}

function kc_update_user($id, $data)
{

    $token = kc_get_token();

    wp_remote_request(
        "http://keycloak:8080/admin/realms/wordpress-realm/users/$id",
        [
            'method' => 'PUT',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]
    );
}

function kc_delete_user($id)
{

    $token = kc_get_token();

    wp_remote_request(
        "http://keycloak:8080/admin/realms/wordpress-realm/users/$id",
        [
            'method' => 'DELETE',
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]
    );
}

function kc_get_roles()
{

    $token = kc_get_token();

    // echo '<script>console.log(' . json_encode($token) . ');</script>';

    $response = wp_remote_get(
        'http://keycloak:8080/admin/realms/wordpress-realm/clients/abcc4e36-5fcc-4303-8861-e330630a0718/roles',
        [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]
    );

    echo '<script>console.log(' . json_encode($response) . ');</script>';

    return json_decode(wp_remote_retrieve_body($response));
}



// map role function
function kc_map_role_to_wp($roles, $user_id)
{
    $user = new WP_User($user_id);

    if (in_array('admin', $roles)) {
        $user->set_role('administrator');
    } elseif (in_array('editor', $roles)) {
        $user->set_role('editor');
    } else {
        $user->set_role('subscriber');
    }
}

// decode JWT (แบบง่าย)
function kc_decode_jwt($jwt)
{
    $parts = explode('.', $jwt);
    $payload = json_decode(base64_decode($parts[1]), true);
    return $payload;
}

// hook ตอน login
add_action('wp_login', 'kc_sync_role_after_login', 10, 2);

function kc_sync_role_after_login($user_login, $user)
{

    // 🔥 ตรงนี้คุณต้องดึง token มาเอง
    // เช่นจาก cookie / header / session
    $jwt = $_COOKIE['kc_token'] ?? null;

    if (!$jwt)
        return;

    $data = kc_decode_jwt($jwt);

    if (isset($data['realm_access']['roles'])) {
        $roles = $data['realm_access']['roles'];

        kc_map_role_to_wp($roles, $user->ID);
    }
}
?>