<?php

add_action('admin_menu', function () {

    add_menu_page(
        'User Management',
        'User Management',
        'manage_options',
        'kc-users',
        'kc_users_list_page'
    );

    add_submenu_page(
        null,
        'Add User',
        'Add User',
        'manage_options',
        'kc-add-user',
        'kc_user_form_page'
    );

    add_submenu_page(
        null,
        'Edit User',
        'Edit User',
        'manage_options',
        'kc-edit-user',
        'kc_user_form_page'
    );

    add_submenu_page(
        'kc-users',
        'Roles Management',
        'Roles Management',
        'manage_options',
        'kc-roles',
        'kc_roles_list_page'
    );
});

?>