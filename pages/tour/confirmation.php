<?php
session_start();
require_once('../../assets/php/db.php'); // Include the database connection file

// Return to the registration page if the form was not submitted or if the required fields are not set
if (
    !($_SERVER['REQUEST_METHOD'] === 'POST') ||
    !isset($_POST['departure_date'], $_POST['people'])
) {
    header('Location: /3340/404.php');
    exit;
}

// Check if the required fields are empty
if (empty($_POST['departure_date']) || empty($_POST['people'])) {
    header('Location: /3340/404.php');
    exit;
}

// Add a new booking to the database
if ($stmt = mysqli_prepare($conn, 'INSERT INTO bookings (tour_id, user_id, departure_date, person_count, total_price) VALUES (?, ?, ?, ?, ?)')) {
    $date = DateTime::createFromFormat('m/d/Y', $_POST['departure_date']);
    $newDate = $date->format('Y-m-d'); // Convert date to 'Y-m-d' format
    $totalPrice = $_SESSION['tour']['base_price'] * $_POST['people']; // Calculate total price
    // Bind POST data to the prepared statement
    mysqli_stmt_bind_param(
        $stmt,
        'iissd',
        $_SESSION['tour']['id'], // Tour ID
        $_SESSION['account_id'], // User ID from session
        $newDate, // Departure date
        $_POST['people'], // Number of people
        $_SESSION['tour']['base_price'] // Base price
    );
    mysqli_stmt_execute($stmt); // Execute the query
    mysqli_stmt_close($stmt); // Close the statement
    $bookingId = mysqli_insert_id($conn); // Get the last inserted booking ID
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
                <hr>
                <div>
                    <!-- Departure Date and Arrival Date -->
                    <h4>Departure Date</h4>
                    <p id="departure-date">YYYY/MM/DD</p>
                    <h4>Arrival Date</h4>
                    <p id="arrival-date">YYYY/MM/DD</p>
                </div>
                <div>
                    <h4>Number of People</h4>
                    <p id="number-of-people">1</p>
                    <h4>Pricing Breakdown</h4>
                    <p id="base-price"><b>Base Price:</b> $<?php echo htmlspecialchars($_SESSION['tour']['base_price']); ?> x 1</p>
                    <p id="addon-price"><b>Add-on Price:</b> $0.00 x 1</p>
                </div>
                <div>
                    <!-- Total Price -->
                    <h4>Total Price</h4>
                    <p id="total-price">$<?php echo htmlspecialchars($_SESSION['tour']['base_price']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
</body>

</html>