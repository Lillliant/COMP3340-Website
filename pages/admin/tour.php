<?php
// We need to use sessions, so you should always initialize sessions using the below function
session_start();
// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once('../../assets/php/db.php');
// Obtain user bookings from the database
$stmt = $conn->prepare("SELECT * FROM tours");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $bookings = [];
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

    <h2>All Bookings</h2>
    <div class="booking-list">
        <div>
            
                </div>
                <?php if (count($bookings) > 0): ?>
                    <ul>
                        <?php foreach ($bookings as $booking): ?>
                            <li>
                                <string>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?> |
                                    <strong>Tour ID:</strong> <?php echo htmlspecialchars($booking['name']); ?> |
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>There are no bookings.</p>
                <?php endif; ?>
        </div>
        <!-- Footer -->
</body>

</html>