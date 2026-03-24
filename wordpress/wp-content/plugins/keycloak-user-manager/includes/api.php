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
                'client_secret' => 'pixuR7InkKMaNHl78mU7aOBSmyCvrz5L',
                'grant_type' => 'client_credentials'
            ]
        ]
    );

    // echo '<script>console.log(' . json_encode($response) . ');</script>';
    $body = json_decode(wp_remote_retrieve_body($response));

    echo '<script>console.log(' . json_encode($body) . ');</script>';
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
?>