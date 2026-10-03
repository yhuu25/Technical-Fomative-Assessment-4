<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts</title>
</head>
<body>

<nav>
    <a href="<?= site_url('/') ?>">Home</a> |
    <a href="<?= site_url('about') ?>">About</a> |
    <a href="<?= site_url('customers') ?>">Customers</a> |
    <a href="<?= site_url('users') ?>">Users</a>
    <form
    method="post"
    action="<?= site_url('logout') ?>"
    style="display: inline;">

    <?= csrf_field() ?>

    <button type="submit">Logout</button>
</form>
</nav>

<h1>User Accounts</h1>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<p>
    <a href="<?= site_url('users/new') ?>">Add New User</a>
</p>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Avatar</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <?php
            if (! empty($user['avatar'])) {
                $avatarUrl = base_url(
                    'uploads/avatars/' . rawurlencode($user['avatar'])
                );
            } else {
                $avatarUrl = base_url(
                    'images/avatar-placeholder.png'
                );
            }
            ?>

            <tr>
                <td>
                    <img
                        src="<?= esc($avatarUrl) ?>"
                        alt="Avatar of <?= esc($user['full_name']) ?>"
                        width="60"
                        height="60"
                        style="object-fit: cover; border-radius: 50%;">
                </td>

                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>

                <td>
                    <a href="<?= site_url(
                        'users/' . $user['id'] . '/edit'
                    ) ?>">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>