<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS Login</title>
</head>
<body>
<?php if ($error = session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc($error) ?>
    </p>
<?php endif; ?>
<h1>POS Login</h1>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<form method="post" action="<?= site_url('login') ?>">
    <?= csrf_field() ?>

    <p>
        <label>Username</label><br>
        <input
            type="text"
            name="username"
            value="<?= esc(old('username')) ?>"
            required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <button type="submit">Login</button>
</form>

</body>
</html>