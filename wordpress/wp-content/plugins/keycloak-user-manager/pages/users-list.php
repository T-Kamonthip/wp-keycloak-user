<?php

function kc_users_list_page()
{

    $users = kc_get_users();

    echo "<div class='wrap'>";
    echo "<h1>User Management</h1>";

    echo "<a href='admin.php?page=kc-add-user' class='button button-primary'>Add User</a>";

    echo "<table class='wp-list-table widefat'>";

    echo "<tr>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
          </tr>";

    foreach ($users as $user) {

        echo "<tr>";

        echo "<td>$user->username</td>";
        echo "<td>$user->email</td>";
        echo "<td>$user->firstName</td>";
        echo "<td>$user->lastName</td>";

        echo "<td>
        <a href='admin.php?page=kc-edit-user&id=$user->id'>Edit</a>
        </td>";

        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}

?>