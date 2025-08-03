<?php
session_start();

// If the user is already logged in, redirect to home page
if (isset($_SESSION['loggedin'])) {
    header('Location: /3340/pages/user/home.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Login to Trekker Tours to access your account and explore exclusive travel adventures and personalized recommendations.">
    <meta name="keywords" content="login, sign in, account, Trekker Tours, travel, adventure, user login">
    <!-- Import layout -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>
    <h2>Login Page</h2>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Login Form -->
    <div class="center-form">
        <form action="auth.php" method="post" name="login">
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Username" maxlength="50" autocomplete="off" required>
            <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" maxlength="255" autocomplete="off" required>
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>