<?php
session_start(); // Start the session to access session variables

// If the user is not logged in, redirect to the home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once('../../assets/php/db.php'); // Include database connection

// Obtain user bookings from the database
if ($_SESSION['role'] === 'admin') { // Admins can see all bookings
    $stmt = $conn->prepare("SELECT * FROM bookings");
} else { // Regular users can only see their own bookings
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['account_id']);
}
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
} else { // No bookings found, initialize an empty array
    $bookings = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Manage Bookings</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Booking Management dashboard for Trekker Tours. Manage your bookings and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, bookings, admin, manage tours">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Manage Bookings</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Go back to the user dashboard -->
    <a href="/3340/pages/user/home.php" class="back-button">Back to Dashboard</a>

    <!-- Container for bookings -->
    <div class="item-list">
        <!-- Display a card for each booking -->
        <?php if (count($bookings) > 0): ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="item-grid">
                    <!-- Display booking details for each booking dynamically -->
                    <div class="details-card no-bg">
                        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($booking['status'])); ?></p>
                        <p><strong>Tour ID:</strong> <?php echo htmlspecialchars($booking['tour_id']); ?></p>
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
                        <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($booking['departure_date']); ?></p>
                        <p><strong>Number of People:</strong> <?php echo htmlspecialchars($booking['person_count']); ?></p>
                        <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($booking['total_price']) ?></p>
                    </div>
                    <!-- Display the possible actions for each booking -->
                    <div class="actions-container item-right">
                        <form action="../edit/booking.php" method="get" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                            <input type="submit" value="Edit Booking">
                        </form>
                        <form action="../delete/booking.php" method="post" onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be reversed.');" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                            <input type="submit" value="Delete Booking">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <!-- If no bookings are found, display a message -->
            <p>There are no bookings.</p>
        <?php endif; ?>
    </div>
</body>

</html>