<?php
session_start(); // Start the session to manage user authentications

require_once('../../assets/php/db.php'); // Include database connection

// If the user is not logged in, redirect to the index page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Edit Password</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Edit your password for Trekker Tours. Secure your account by updating your password regularly.">
    <meta name="keywords" content="edit password, change password, trekker tours, account security, user profile">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Edit Password</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <p class="lead">
        Change your password here. Make sure to choose a strong password to keep your account secure.
    </p>
    <a href="/3340/pages/user/home.php" class="back-button">Go Back to Dashboard</a>
    <!-- Form to edit password -->
    <div class="center-form">
        <form action="password_validate.php" method="post">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" placeholder="password" required>
            <input type="submit" value="Edit">
        </form>
    </div>

    <!-- Footer -->
</body>

</html>