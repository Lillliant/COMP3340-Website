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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>

    <h2>Login Page</h2>

    <?php
    // Display error message if there is one
    if (isset($_SESSION['error']) && !isset($_SESSION['loggedin'])) {
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']); // Clear the error message after displaying it
    }
    ?>

    <div class="center-form">
        <form action="auth.php" method="post" name="login">
            <input type="text" name="username" required="required" id="username" placeholder="Username">
            <br>
            <input type="password" name="password" required="required" id="password" placeholder="Password">
            <br>
            <input type="submit" value="Login" />
        </form>
    </div>

    <!-- Footer -->
</body>

</html>