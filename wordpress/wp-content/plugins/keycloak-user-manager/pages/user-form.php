<?php

function kc_user_form_page()
{
    $uid = isset($_GET["id"]) ? ($_GET["id"]) :
        null;

    // echo $uid;

    $dataDetail = "";

    $roles = ['admin', 'editor', 'user'];
    $selected_role = '';

    if ($uid) {
        $dataDetail = kc_get_users_detail($uid);

        echo "<script>console.log(" . json_encode($dataDetail) . ");</script>";

        // echo $dataDetail->username;
        $selected_role = $dataDetail->roles ?? '';

    }


    if ($_POST) {

        $data = [
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "enabled" => true,
            "firstName" => $_POST['first_name'],
            "lastName" => $_POST['last_name'],
            "roles" => $_POST['role'] ?? ''
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
                    <td><input name="username"
                            value="<?php echo isset($dataDetail->username) ? $dataDetail->username : ''; ?>"></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><input name="email" value="<?php echo isset($dataDetail->email) ? $dataDetail->email : ''; ?>">
                    </td>
                </tr>

                <tr>
                    <th>First Name</th>
                    <td><input name="first_name"
                            value="<?php echo isset($dataDetail->firstName) ? $dataDetail->firstName : ''; ?>"></td>
                </tr>

                <tr>
                    <th>Last Name</th>
                    <td><input name="last_name"
                            value="<?php echo isset($dataDetail->lastName) ? $dataDetail->lastName : ''; ?>"></td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>
                        <?php foreach ($roles as $role): ?>
                            <label>
                                <input type="radio" name="role" value="<?php echo $role; ?>" <?php checked($selected_role, $role); ?>>
                                <?php echo ucfirst($role); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>

            </table>

            <button type="button" class="button button-secondary"
                onclick="location.href='<?php echo admin_url('admin.php?page=kc-users'); ?>'; return false;">Back</button>
            <button class="button button-primary">Save</button>

        </form>

    </div>

    <?php
}

?>