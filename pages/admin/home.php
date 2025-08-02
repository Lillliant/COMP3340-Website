<?php
// We need to use sessions, so you should always initialize sessions using the below function
session_start();
// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if ($_SESSION['role'] !== 'admin') {
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

    <h2>Admin Home Page</h2>
    <button onclick="window.location.href='booking.php'">View All Bookings</button>
    <button onclick="window.location.href='profile.php'">View All Users</button>
    <button onclick="window.location.href='../edit/password.php'">Edit My Password</button>
    <!-- Footer -->
</body>

</html>