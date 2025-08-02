<?php
session_start();

require_once('../../assets/php/db.php');

// If the user is already logged in, redirect to home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
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

    <h2>Edit Password</h2>
    <?php
    // Display error message if there is one
    if (isset($_SESSION['error'])) {
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']); // Clear the error message after displaying it
    } else if (isset($_SESSION['success'])) {
        echo '<p class="success">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']); // Clear the success message after displaying it
    }
    ?>
    <div class="center-form">
        <form action="password_validate.php" method="post">
            <input type="password" name="password" id="password" placeholder="password" required>
            <input type="submit" value="Edit">
        </form>
    </div>

    <!-- Footer -->
</body>

</html>