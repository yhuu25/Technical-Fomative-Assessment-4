<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
</head>
<body>

<h1><?= esc($title) ?></h1>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<?php if ($errors): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php $editing = ! empty($user); ?>

<form
    method="post"
    enctype="multipart/form-data"
    action="<?= $editing
        ? site_url('users/' . $user['id'])
        : site_url('users') ?>">

    <?= csrf_field() ?>

    <p>
        <label for="username">Username</label><br>

        <input
            id="username"
            type="text"
            name="username"
            maxlength="50"
            value="<?= esc(old(
                'username',
                $user['username'] ?? ''
            )) ?>"
            required>
    </p>

    <p>
        <label for="full_name">Full Name</label><br>

        <input
            id="full_name"
            type="text"
            name="full_name"
            maxlength="100"
            value="<?= esc(old(
                'full_name',
                $user['full_name'] ?? ''
            )) ?>"
            required>
    </p>

    <p>
        <label for="password">
            Password
            <?= $editing
                ? '(leave blank to keep current password)'
                : '' ?>
        </label><br>

        <input
            id="password"
            type="password"
            name="password"
            minlength="8"
            maxlength="255"
            autocomplete="new-password"
            <?= $editing ? '' : 'required' ?>>
    </p>

    <?php if ($editing): ?>
        <p>
            <label for="avatar">Profile Picture</label><br>

            <input
                id="avatar"
                type="file"
                name="avatar"
                accept=".jpg,.jpeg,.png,image/jpeg,image/png">
        </p>

        <small>
            JPG or PNG only. Maximum size: 2MB.
        </small>
    <?php endif; ?>

    <p>
        <button type="submit">
            <?= $editing ? 'Update User' : 'Add User' ?>
        </button>

        <a href="<?= site_url('users') ?>">Cancel</a>
    </p>
</form>

</body>
</html>