<?php

function kc_user_form_page()
{

    if ($_POST) {

        $data = [
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "enabled" => true
        ];

        if ($_GET['id']) {

            kc_update_user($_GET['id'], $data);

        } else {

            kc_create_user($data);
        }
    }

    ?>
    <div class="wrap">

        <h1>User Form</h1>

        <form method="post">

            <table class="form-table">

                <tr>
                    <th>Username</th>
                    <td><input name="username"></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><input name="email"></td>
                </tr>

            </table>

            <button type="button" class="button button-secondary" onclick="location.href='<?php echo admin_url( 'admin.php?page=kc-users' ); ?>'; return false;">Back</button>
            <button class="button button-primary">Save</button>

        </form>

    </div>

    <?php
}

?>