<?php
session_start();
require_once('../../assets/php/db.php'); // Include the database connection file

// Obtain booking information from the session or URL
// If the booking ID is not set in the session or URL, redirect to a 404 page
if (!isset($_GET['booking_id']) && !isset($_SESSION['booking_id'])) {
    header('Location: /3340/404.php');
    exit;
}
$bookingId = isset($_GET['booking_id']) ? $_GET['booking_id'] : $_SESSION['booking_id'];

// Fetch booking details from the database
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $bookingId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) { // If no booking is found, redirect to a 404 page since there has been an error
    header('Location: /3340/404.php');
    exit;
}
$booking = $result->fetch_assoc();

// Obtain the option details
$optionId = $booking['option_id'];
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $optionId);
$stmt->execute();
$optionResult = $stmt->get_result();
if ($optionResult->num_rows === 0) {
    $option = 'No option selected';
} else {
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
    <div class="booking-body">
        <div class="booking-header">
            <h3>Trip Summary</h3>
            <p>Thank you for booking with Trekker Tours! Here are the details of your booking.</p>
            <p>Your booking ID is: <?php echo htmlspecialchars($bookingId); ?></p>
            <hr>
            <div>
                <!-- Display the booking details dynamically -->
                <h4>Departure Date</h4>
                <p id="departure-date"><?php echo htmlspecialchars($booking['departure_date']); ?></p>
                <h4>Arrival Date</h4>
                <p id="arrival-date"><?php
                                        $date = DateTime::createFromFormat('Y-m-d', $booking['departure_date']);
                                        $duration = date_interval_create_from_date_string($_SESSION['tour']['duration'] . ' days');
                                        echo htmlspecialchars(date_add($date, $duration)->format('Y-m-d'));
                                        ?></p>
            </div>
            <div>
                <h4>Number of People</h4>
                <p id="number-of-people"><?php echo $booking['person_count'] ?></p>
                <h4>Selected Option</h4>
                <p id="selected-option"><?php echo sprintf("%s - $%s", $option['name'], $option['price']) ?> x <?php echo $booking['person_count'] ?></p>
            </div>
            <div>
                <h4>Total Price</h4>
                <p id="total-price">$<?php echo htmlspecialchars($booking['total_price']); ?></p>
            </div>
        </div>
    </div>
</body>

</html>