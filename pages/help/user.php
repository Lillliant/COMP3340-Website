<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>How to Manage Users</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Admin guide for managing users on Trekker Tours. Learn how to view, change roles, and delete user accounts using the dashboard.">
    <meta name="keywords" content="manage users, admin guide, trekker tours, edit user, change user role, delete user, user dashboard, account management">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Admin Guide</h1>
    <h2>How to Manage Users</h2>
    <p class="lead">
        This guide will show you how to use the dynamic PHP and JavaScript functionalities to manage user accounts on the website. You can view users, change their roles between admin and user, or delete accounts as needed.
    </p>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>
    <div style="max-width: 800px; margin: 0 auto; ">
        <hr>
        <div style="display: flex; flex-direction: column; justify-content: center; gap: 1rem; text-align: justify;">
            <h3>Where to View Users</h3>
            <div>
                <ol style="text-align: justify;">
                    <li>
                        <a href="/3340/pages/login/login.php">Log in</a> to the admin dashboard. If you need help, visit the <a href="/3340/pages/help/login.php">Login Guide</a>.
                    </li>
                    <li>
                        Go to the <a href="/3340/pages/user/user.php">Manage Users</a> section from the dashboard menu.
                    </li>
                    <li>
                        Review all users, including their account details, roles, and status.
                    </li>
                </ol>
            </div>

            <h3>How to Edit User Roles</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/user.php">Manage Users</a> section, find the user whose role you want to change.
                </li>
                <li>
                    Click the "Edit Role" button (shown as Make User/Make Admin) next to the user's account.
                </li>
            </ol>

            <h3>How to Delete Users</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/user.php">Manage Users</a> section, find the user account you wish to delete.
                </li>
                <li>
                    Click the "Delete" button next to the user's account.
                </li>
                <li>
                    Confirm the deletion when prompted. This will permanently remove the user and all associated data from the system.
                </li>
            </ol>

            <h3>Database Schema for User</h3>
            <p>
                The users are stored in the <code>users</code> table with the following structure:
            </p>
            <embed src="/3340/assets/sql/user.txt" type="text/plain" style="width: 100%; height: 500px; border: none; padding: 20px 0;">
        </div>
    </div>
</body>

</html>