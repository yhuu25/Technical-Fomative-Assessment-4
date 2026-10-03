<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Accounts</title>
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

<h1>Customer Accounts</h1>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<p>
    <a href="<?= site_url('customers/new') ?>">Add New Customer</a>
</p>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['id']) ?></td>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone']) ?></td>
                <td><?= esc($customer['created_at']) ?></td>

                <td>
                    <a href="<?= site_url(
                        'customers/' . $customer['id'] . '/edit'
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