<?php

function kc_roles_list_page()
{

    $roles = kc_get_roles();

    echo "<div class='wrap'>";
    echo "<h1>Role Management</h1>";

    // echo "<a href='admin.php?page=kc-add-role' class='button button-primary'>Add Role</a>";

    echo "<table class='wp-list-table widefat'>";

    echo "<tr>
            <th>Roles</th>
            <th>Email</th>
            <th>Action</th>
          </tr>";

    foreach ($roles as $role) {

        echo "<tr>";

        echo "<td>$role->name</td>";

        // echo "<td>
        // <a href='admin.php?page=kc-edit-user&id=$user->id'>Edit</a>
        // </td>";

        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}

?>