<?php
// Start the session to manage user authentications
session_start();
// If the user is not logged in, redirect to the index page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="User dashboard for Trekker Tours. Manage your bookings, profile, and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, bookings, profile, admin, manage tours, manage users, website monitor">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Home Dashboard</h1>

    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <p class="lead">
        Welcome to your dashboard, <?php echo htmlspecialchars($_SESSION['account_name']); ?>! Here you can manage your bookings, view your profile, and access admin features if you have the necessary permissions.
    </p>
    <!-- Dashboard buttons for user actions -->
    <div class="dashboard-buttons">
        <button onclick="window.location.href='booking.php'">Manage Bookings</button>
        <?php
        // Check if the user is an admin
        if ($_SESSION['role'] === 'admin') {
            echo '<button onclick="window.location.href=\'../user/tour.php\'">Manage Tours</button>';
            echo '<button onclick="window.location.href=\'../user/user.php\'">Manage Users</button>';
            echo '<button onclick="window.location.href=\'monitor.php\'">Website Monitor</button>';
        }
        ?>
        <button onclick="window.location.href='profile.php'">View My Profile</button>
        <button onclick="window.location.href='../edit/password.php'">Edit My Password</button>
    </div>
</body>

</html>