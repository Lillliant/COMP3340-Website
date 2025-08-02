<?php
session_start();

$url = 'http://localhost/3340/';

// If the user is not logged in, redirect to the home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

// If the user is not an admin, redirect to the home page
if ($_SESSION['role'] !== 'admin') {
    header('Location: /3340/pages/user/home.php');
    exit;
}

function isUrlUp($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode >= 200 && $httpCode != 404) {
        return " is up and running. HTTP Status Code: $httpCode";
    } else {
        return " is down. HTTP Status Code: $httpCode";
    }
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

    <h2>Website Monitor</h2>
    <div>
        <p><?php echo 'Home Page' . isUrlUp($url); ?></p>
        <p>
            <?php
            $login_url = $url . 'pages/login/login.php';
            echo 'Login Page' . isUrlUp($login_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/login/register.php';
            echo 'Registration Page' . isUrlUp($booking_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/tour/tour.php';
            echo 'Tour Details Page' . isUrlUp($booking_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/user/home.php';
            echo 'User Home Page' . isUrlUp($booking_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/user/booking.php';
            echo 'Booking Management Page' . isUrlUp($booking_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/user/tour.php';
            echo 'Tour Management Page' . isUrlUp($booking_url);
            ?>
        </p>
        <p>
            <?php
            $booking_url = $url . 'pages/user/user.php';
            echo 'User Management Page' . isUrlUp($booking_url);
            ?>
        </p>
    </div>
</body>

</html>