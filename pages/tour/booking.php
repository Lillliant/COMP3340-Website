<?php
session_start();

// Require the user to be logged in to access the booking page
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['tourid'] = $_GET['tourid'];
    header('Location: /3340/pages/login/login.php');
    exit;
}

if (!isset($_SESSION['tour'])) { // If the tour details are not set, fetch them from the database
    // Fetch tour details from the database
    require_once '../../assets/php/db.php';
    $stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['tourid']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['tour'] = $result->fetch_assoc();
    } else { // If no tour is found, redirect to a 404 page
        header("Location: ../../404.php");
        exit;
    }
}

if (!isset($_SESSION['options'])) { // If the options are not set, fetch them from the database
    require_once '../../assets/php/db.php';
    // Fetch tour options
    $stmt = $conn->prepare("SELECT * FROM options WHERE tour_id = ?");
    $stmt->bind_param("i", $_SESSION['tourid']);
    $stmt->execute();
    $optionsResult = $stmt->get_result();
    $_SESSION['options'] = [];
    if ($optionsResult->num_rows > 0) {
        // Fetch all options into an array
        while ($option = $optionsResult->fetch_assoc()) {
            $_SESSION['options'][] = $option;
        }
    } else { // If no options are available, set an empty array
        $_SESSION['options'] = []; // No options available for this tour
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Booking Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Explore details, itinerary, and options for your selected Trekker Tour. Book your adventure and discover destinations, activities, and pricing.">
    <meta name="keywords" content="trekker tours, tour details, itinerary, booking, travel, adventure, destinations, activity level, price, options">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
    <!-- Import for datepicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Booking form for the selected tour -->
    <div class="booking-body">
        <div class="booking-header d-flex justify-content-between align-items-center">
            <h2>Trip Overview</h2>
            <!-- Responsive design: Hide back to tour details button -->
            <span class="tour-booking">
                <button class="rhide" onclick="window.location.href='tour.php?tourid=<?php echo htmlspecialchars($_GET['tourid']); ?>'">Back to Tour Details</a>
            </span>
        </div>
        <div class="booking-grid">
            <div class="booking-form">
                <form action="book.php" method="post" name="booking" class="no-bg">
                    <label for="datepicker">Departure Date:</label>
                    <input type="text" id="datepicker" placeholder="Select a date" name="departure_date" autocomplete="off" required>
                    <label for="people">Number of People:</label>
                    <input type="number" name="people" id="people" value="1" min="1" max="30" required>
                    <label for="option">Select an Option:</label>
                    <select name="option" id="option" required>
                        <?php foreach ($_SESSION['options'] as $option) : ?>
                            <option value="<?php echo htmlspecialchars($option['id']); ?>">
                                <?php echo htmlspecialchars($option['name']) . " - $" . htmlspecialchars($option['price']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Book Now">
                </form>
            </div>
            <div class="booking-summary rhide">
                <div>
                    <h3>Trip Summary</h3>
                    <?php echo $_SESSION['account_id'] ? "<p>Welcome, User ID: " . htmlspecialchars($_SESSION['account_id']) . "</p>" : "<p>Please log in to book a tour.</p>"; ?>
                    <hr>
                    <div>
                        <!-- Departure Date and Arrival Date -->
                        <h4>Departure Date</h4>
                        <p id="departure-date">N/A</p>
                        <h4>Arrival Date</h4>
                        <p id="arrival-date">N/A</p>
                    </div>
                    <div>
                        <h4>Number of People</h4>
                        <p id="number-of-people">1</p>
                        <h4>Selected Option</h4>
                        <p id="selected-option">None</p>
                    </div>
                    <div>
                        <h4>Total Price</h4>
                        <p id="total-price">$0.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                minDate: 0, // Prevent past dates
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
            // Initialize the total price based on the default option and number of people
            var initialPeopleCount = $('#people').val();
            var selectedOption = $('#option').find('option:selected');
            var optionPrice = parseFloat(selectedOption.text().split('- $')[1]);
            var totalPrice = optionPrice * initialPeopleCount;
            $('#total-price').text('$' + totalPrice.toFixed(2));
            $('#selected-option').text(selectedOption.text());
            $('#number-of-people').text(initialPeopleCount);
            // Update total price and selected option on input change
            $('#people').on('input', function() {
                var peopleCount = $(this).val();
                $('#number-of-people').text(peopleCount);
                var selectedOption = $('#option').find('option:selected');
                var optionPrice = parseFloat(selectedOption.text().split('- $')[1]);
                var totalPrice = optionPrice * peopleCount;
                $('#total-price').text('$' + totalPrice.toFixed(2));
            });
            $('#option').on('change', function() {
                var selectedOption = $(this).find('option:selected').text();
                $('#selected-option').text(selectedOption);
                var peopleCount = $('#people').val();
                var optionPrice = parseFloat(selectedOption.split('- $')[1]);
                var totalPrice = optionPrice * peopleCount;
                $('#total-price').text('$' + totalPrice.toFixed(2));
            });
        });
    </script>
</body>

</html>