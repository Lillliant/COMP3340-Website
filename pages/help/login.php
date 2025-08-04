<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>How to Login</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Login guide for Trekker Tours. Learn how to access your account, troubleshoot login issues, and navigate the login page.">
    <meta name="keywords" content="login, trekker tours, account access, login help, user login, login guide, troubleshooting login">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>User Guide</h1>
    <h2>How to Register and Login</h2>
    <p class="lead">
        This guide will show you how to use the dynamic PHP and JavaScript functionalities to register and log in to your account on the website. You can access your dashboard, troubleshoot login issues, and securely manage your account.
    </p>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>
    <div style="max-width: 800px; margin: 0 auto; ">
        <hr>
        <div style="display: flex; flex-direction: column; justify-content: center; gap: 1rem; text-align: justify;">
            <h3>Where to Login or Register</h3>
            <div>
                <ol style="text-align: justify;">
                    <li>
                        To <strong>register</strong> a new account, go to the <a href="/3340/pages/login/register.php">Registration</a> page and fill out the required information.
                    </li>
                    <li>
                        To <strong>login</strong> to your account, visit the <a href="/3340/pages/login/login.php">Login</a> page and enter your credentials.
                    </li>
                    <li>
                        After logging in, you will be redirected to your dashboard where you can access user features and manage your account.
                    </li>
                </ol>
            </div>

            <h3>Where to View Your Profile</h3>
            <ol style="text-align: justify;">
                <li>
                    After logging in, go to the <a href="/3340/pages/user/profile.php">Profile</a> page to view your account details.
                </li>
                <li>
                    On the profile page, you can see your personal information and update your account settings.
                </li>
            </ol>

            <h3>How to Edit Your Profile</h3>
            <ol style="text-align: justify;">
                <li>
                    Go to the <a href="/3340/pages/user/profile.php">Profile</a> page after logging in.
                </li>
                <li>
                    Click the "Edit Profile" button to update your personal information.
                </li>
                <li>
                    Make the desired changes and save. Your profile will be updated immediately.
                </li>
            </ol>

            <h3>How to Edit Your Password</h3>
            <ol style="text-align: justify;">
                <li>
                    Go to the <a href="/3340/pages/user/home.php">Dashboard</a> page after logging in.
                </li>
                <li>
                    Click the "Change Password" button or link.
                </li>
                <li>
                    Enter your new password.
                </li>
                <li>
                    Save the changes. Your password will be updated immediately.
                </li>
            </ol>
        </div>
    </div>
</body>

</html>