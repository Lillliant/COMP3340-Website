<?php
session_start();
require_once('../../assets/php/db.php'); // Include the database connection file

// Obtain booking information from the session or URL
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
if ($result->num_rows === 0) {
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Tours</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>

    <div class="booking-body">
        <div class="booking-header">
            <!-- Responsive design: Back to Tour Details icon button only in small space -->
            <div>
                <h3>Trip Summary</h3>
                <?php echo $_SESSION['account_id'] ? "<p>Welcome, User ID: " . htmlspecialchars($_SESSION['account_id']) . "</p>" : "<p>Please log in to book a tour.</p>"; ?>
                <?php if (isset($_GET['booking_id'])) : ?>
                    <p>Your booking ID is: <?php echo htmlspecialchars($_GET['booking_id']); ?></p>
                <?php else : ?>
                    <p>There was an error processing your booking. Please try again.</p>
                <?php endif; ?>
                <hr>
                <div>
                    <!-- Departure Date and Arrival Date -->
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
                    <!-- Total Price -->
                    <h4>Total Price</h4>
                    <p id="total-price">$<?php echo htmlspecialchars($booking['total_price']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
</body>

</html>