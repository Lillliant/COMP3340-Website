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
$stmt = $conn->prepare("SELECT * FROM bookings");
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
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/messages.php'; ?>

    <h2>My Bookings</h2>
    <div class="booking-list">
        <?php if (count($bookings) > 0): ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-grid">
                    <div class="booking-card">
                        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
                        <p><strong>Tour ID:</strong> <?php echo htmlspecialchars($booking['tour_id']); ?></p>
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
                        <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($booking['departure_date']); ?></p>
                        <p><strong>Number of People:</strong> <?php echo htmlspecialchars($booking['person_count']); ?></p>
                        <p><strong>Total Price:</strong> $<?php echo $booking['total_price'] ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($booking['status'])); ?></p>
                    </div>
                    <div class="edit-container">
                        <form action="../edit/booking.php" method="get">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                            <input type="submit" value="Edit Booking">
                        </form>
                        <form action="../delete/booking.php" method="post">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                            <input type="submit" value="Delete Booking">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>There are no bookings.</p>
        <?php endif; ?>
    </div>
    <!-- Footer -->
</body>

</html>