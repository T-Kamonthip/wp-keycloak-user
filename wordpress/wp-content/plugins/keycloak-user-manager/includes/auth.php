<?php

function kc_login_redirect()
{
    $url = "http://keycloak:8080/realms/wordpress-realm/protocol/openid-connect/auth?...";
    wp_redirect($url);
    exit;
}

?>