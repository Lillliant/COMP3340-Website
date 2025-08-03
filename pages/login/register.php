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
    <title>Register</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Register for Trekker Tours and start your journey. Create your account to access exclusive travel adventures and personalized recommendations.">
    <meta name="keywords" content="register, sign up, account, Trekker Tours, travel, adventure, user registration">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>
    <h2>Registration Page</h2>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Registration Form -->
    <div class="center-form">
        <form action="signup.php" method="post">
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Username" maxlength="50" autocomplete="off" required>
            <br>
            <label for="email">Email:</label>
            <br>
            <input type="email" name="email" id="email" placeholder="Email" maxlength="100" autocomplete="off" required>
            <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" maxlength="255" autocomplete="off" required>
            <br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>

</html>