<?php
session_start();
require_once('../../assets/php/db.php'); // Include the database connection file

// If the user is not logged in, or the booking ID is not set, redirect to the 404 page
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['error'] = 'You must be logged in to view this page.';
    header('Location: /3340/404.php');
    exit;
}

// Check if the booking ID is valid
if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    $_SESSION['error'] = 'Invalid booking ID.';
    header('Location: /3340/404.php');
    exit;
}

// Fetch booking details from the database
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $_GET['booking_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) { // If no booking is found, redirect to a 404 page since there has been an error
    $_SESSION['error'] = 'Booking not found.';
    header('Location: /3340/404.php');
    exit;
}
$booking = $result->fetch_assoc();

// If the user is not an admin, they can only view their own bookings
if ($_SESSION['role'] !== 'admin') {
    if ($booking['user_id'] !== $_SESSION['account_id']) {
        $_SESSION['error'] = 'You do not have permission to view this booking.';
        header('Location: /3340/404.php');
        exit;
    }
}

// Obtain the option details
$optionId = $booking['option_id'];
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $optionId);
$stmt->execute();
$optionResult = $stmt->get_result();
if ($optionResult->num_rows === 0) { // If no option is found, set to null
    $option = null;
} else { // If an option is found, fetch its details
    $option = $optionResult->fetch_assoc();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Booking Confirmation</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Explore details, itinerary, and options for your selected Trekker Tour. Book your adventure and discover destinations, activities, and pricing.">
    <meta name="keywords" content="trekker tours, tour details, itinerary, booking, travel, adventure, destinations, activity level, price, options">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Booking Confirmation</h1>
    <p>Thank you for booking with Trekker Tours! Here are the details of your booking.</p>
    <!-- Display success/error messages -->
    <?php include '../../assets/components/alert.php'; ?>

    <!-- Booking Details -->
    <div class="container-md border rounded p-3 border-2">
        <div>
            <h2>Trip Summary</h2>
            <hr>
            <p>Your booking ID is: <?php echo htmlspecialchars($_GET['booking_id']); ?></p>
        </div>
        <div>
            <!-- Display the booking details dynamically -->
            <h4>Tour Name</h4>
            <p id="tour-name"><?php echo htmlspecialchars($_SESSION['tour']['name']); ?></p>
            <h4>Status</h4>
            <p id="status"><?php echo htmlspecialchars(ucfirst($booking['status'])); ?></p>
            <h4>Departure Date</h4>
            <p id="departure-date"><?php echo htmlspecialchars($booking['departure_date']); ?></p>
            <h4>Arrival Date</h4>
            <p id="arrival-date"><?php
                                    $date = DateTime::createFromFormat('Y-m-d', $booking['departure_date']);
                                    $duration = date_interval_create_from_date_string($_SESSION['tour']['duration'] . ' days');
                                    echo htmlspecialchars(date_add($date, $duration)->format('Y-m-d'));
                                    ?></p>
            <h4>Number of People</h4>
            <p id="number-of-people"><?php echo $booking['person_count'] ?></p>
            <h4>Selected Option</h4>
            <p id="selected-option"><?php echo sprintf("%s - $%s", $option['name'], $option['price']) ?> x <?php echo $booking['person_count'] ?></p>
            <h4>Total Price</h4>
            <p id="total-price">$<?php echo htmlspecialchars($booking['total_price']); ?></p>
        </div>
    </div>
</body>

</html>