<?php
session_start();

// Require the user to be logged in to access the booking page
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['tourid'] = $_GET['tourid'];
    header('Location: /3340/pages/login/login.php');
    exit;
}

if (!isset($_SESSION['tour'])) {
    // Fetch tour details from the database
    require_once '../../assets/php/db.php';
    $stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['tourid']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['tour'] = $result->fetch_assoc();
    } else {
        header("Location: ../../404.php");
        exit;
    }
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
        <div class="booking-header d-flex justify-content-between align-items-center">
            <h2>Trip Overview</h2>
            <!-- Responsive design: Back to Tour Details icon button only in small space -->
            <span class="tour-booking">
                <button onclick="window.location.href='tour.php?tourid=<?php echo htmlspecialchars($_GET['tourid']); ?>'">Back to Tour Details</a>
            </span>
        </div>
        <div class="booking-grid">
            <div class="booking-form">
                <div>
                    <!-- TODO: Display trip details here -->
                </div>
                <div>
                    <form action="confirmation.php" method="post" name="booking">
                        <h3>Departure Date</h3>
                        <input type="text" id="datepicker" placeholder="Select a date" name="departure_date" required>
                        <input type="number" name="people" id="people" value="1" min="1" max="30" required>
                        <input type="submit" value="Book Now">
                    </form>
                </div>
            </div>
            <div class="booking-summary">
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
    </div>

    <!-- Footer -->

    <!-- Embedded JavaScript for datepicker functionality -->
    <script>
        // Ensure the datepicker only allows booking on the specified start day of the tour
        $(function() {
            var beforeShowDay = function(date) {
                var day = date.getDay();
                return [day == <?php echo $_SESSION['tour']['start_day']; ?>];
            };

            $("#datepicker").datepicker({
                beforeShowDay: beforeShowDay,
                onSelect: function(date) {
                    var departureDate = new Date(date);
                    $('#departure-date').text(departureDate.toDateString());
                    var arrivalDate = new Date(departureDate);
                    arrivalDate.setDate(arrivalDate.getDate() + <?php echo $_SESSION['tour']['duration'] ?>);
                    $('#arrival-date').text(arrivalDate.toDateString());
                }
            });
        });

        // Update the number of people and calculate total price
        $(document).ready(function() {
            $('#people').on('input', function() {
                var peopleCount = $(this).val();
                $('#number-of-people').text(peopleCount);
                var basePrice = <?php echo $_SESSION['tour']['base_price']; ?>;
                var totalPrice = basePrice * peopleCount;
                $('#base-price').html(`<b>Base Price:</b> \$${basePrice.toFixed(2)} x${peopleCount}`);
                $('#addon-price').html(`<b>Add-on Price:</b> $XXX x ${peopleCount}`); // Replace XXX with actual add-on price if applicable
                $('#total-price').text(`\$${totalPrice.toFixed(2)}`);
            });
        });
    </script>
</body>

</html>