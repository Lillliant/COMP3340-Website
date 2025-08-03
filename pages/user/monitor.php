<?php
session_start();

$url = 'http://localhost/3340/';

function isUrlUp($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode >= 200 && $httpCode < 400) { // Ignore redirects due to lack of session variables & POST/GET requests
        return " is up and running. HTTP Status Code: $httpCode";
    } else {
        return " is down. HTTP Status Code: $httpCode";
    }
}

// Check if the database is connected
function checkDatabaseConnection($servername, $username, $password, $dbname)
{
    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            return false; // Connection failed
        }
        mysqli_close($conn); // Close the connection
        return true; // Connection successful
    } catch (Exception $e) {
        return false; // Exception occurred
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
    <a href="/3340/pages/user/home.php" class="back-button">Back to Dashboard</a>
    <div class="additional-details-container">
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
            $booking_url = $url . 'pages/tour/booking.php';
            echo 'Tour Booking Page' . isUrlUp($booking_url);
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
        <p>
            <?php
            $db = checkDatabaseConnection('localhost', 'root', '', 'Newdb') ? 'Database is connected.' : 'Database connection failed.';
            echo $db;
            ?>
        </p>
    </div>
</body>

</html>