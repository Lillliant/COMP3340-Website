<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// If the user is not logged in, or is not an admin, redirect to home page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: /3340/index.php');
    exit;
}

// Fetch the specific booking detail using the booking ID from the URL
// First validate the booking ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /3340/404.php");
    exit;
}

// Actually fetch the booking details
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    header("Location: /3340/404.php");
    exit;
}

// Fetch the details of the specific booking
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $booking['option_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $option = $result->fetch_assoc();
} else {
    $option = null; // Handle case where no option is found
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
    <!-- Import jQuery and jQuery UI for datepicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Edit Booking</h1>
    <p>
        Use the form below to edit the booking details. The new values will be updated in the database.
    </p>
    <!-- Display any success or error messages -->
    <?php include '../../assets/components/alert.php'; ?>

    <div class="center-form">
        <form action="booking_validate.php" method="post">
            <!-- Hidden field to store the booking ID, which cannot be modified. -->
            <!-- The tour ID also cannot be modified, as it is linked to the booking -->
            <!-- However, the user ID can be modified to change the booking to a different user, -->
            <!-- For cases such as allowing an admin to book on behalf of a user -->
            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="pending" <?php if ($booking['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                <option value="confirmed" <?php if ($booking['status'] === 'confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="cancelled" <?php if ($booking['status'] === 'cancelled') echo 'selected'; ?>>Cancelled</option>
                <option value="completed" <?php if ($booking['status'] === 'completed') echo 'selected'; ?>>Completed</option>
            </select>
            <label for="user_id">User ID:</label>
            <!-- Retain the initial values as placeholders, but allow them to be modified -->
            <input type="text" name="user_id" id="user_id" value="<?php echo htmlspecialchars($booking['user_id']); ?>">
            <label for="datepicker">Departure Date:</label>
            <input type="text" id="datepicker" name="departure_date" value="<?php echo htmlspecialchars($booking['departure_date']); ?>">
            <label for="person_count">Person Count:</label>
            <input type="number" name="person_count" id="person_count" min="1" max="30" value="<?php echo htmlspecialchars($booking['person_count']); ?>">
            <!-- Option selection, which depends on the tour and needs to be dynamically populated -->
            <label for="option_id">Option:</label>
            <select name="option_id" id="option_id">
                <!-- Changed the default selected option based on the booking's current option -->
                <?php if ($option): ?>
                    <option value="<?php echo htmlspecialchars($option['id']); ?>" selected><?php echo htmlspecialchars($option['name']) . ' - $' . htmlspecialchars($option['price']); ?></option>
                <?php else: ?>
                    <option value="" disabled selected>Select an option</option>
                <?php endif; ?>
                <!-- Populate the options dynamically -->
                <?php
                // Fetch all options from the database
                $stmt = $conn->prepare("SELECT * FROM options WHERE tour_id = ?");
                $stmt->bind_param("i", $booking['tour_id']);
                $stmt->execute();
                $optionsResult = $stmt->get_result();
                while ($opt = $optionsResult->fetch_assoc()) {
                    // Only add options that are not the current booking's option
                    if ($option == null || $opt['id'] !== $option['id']) {
                        echo '<option value="' . htmlspecialchars($opt['id']) . '">' . htmlspecialchars($opt['name']) . ' - $' . htmlspecialchars($opt['price']) . '</option>';
                    }
                }
                ?>
            </select>
            <label for="total_price">Total Price:</label>
            <input type="number" name="total_price" id="total_price" min="0" value="<?php echo htmlspecialchars($booking['total_price']); ?>">
            <input type="submit" value="Edit">
        </form>
    </div>
    <!-- Old booking details -->
    <div>
        <h3>Old Booking Details</h3>
        <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($booking['status'])); ?></p>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
        <p><strong>Tour ID:</strong> <?php echo htmlspecialchars($booking['tour_id']); ?></p>
        <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($booking['departure_date']); ?></p>
        <p><strong>Person Count:</strong> <?php echo htmlspecialchars($booking['person_count']); ?></p>
        <p><strong>Selected Option:</strong>
            <!-- Display the selected option if it exists, otherwise show a default message -->
            <?php echo sprintf(
                "%s - $%s",
                $option !== null ? htmlspecialchars($option['name']) : 'No option selected',
                $option !== null ? htmlspecialchars($option['price']) : '0.00'
            ); ?>
        </p>
        <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($booking['total_price']); ?></p>
    </div>
    <!-- New booking details -->

    <div>
        <h3>New Booking Details</h3>
        <!-- Display the new booking details dynamically -->
        <!-- The default values are set to the current booking details -->
        <p id="new-status"><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($booking['status'])); ?></p>
        <p id="new-user-id"><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
        <p id="new-tour-id"><strong>Tour ID:</strong> <?php echo htmlspecialchars($booking['tour_id']); ?></p>
        <p id="new-departure-date"><strong>Departure Date:</strong> <?php echo htmlspecialchars($booking['departure_date']); ?></p>
        <p id="new-person-count"><strong>Person Count:</strong> <?php echo htmlspecialchars($booking['person_count']); ?></p>
        <p id="new-option"><strong>Option:</strong> <?php
                                                    if ($option !== null) {
                                                        echo sprintf("%s - $%s", htmlspecialchars($option['name']), htmlspecialchars($option['price']));
                                                    } else {
                                                        echo 'No option selected';
                                                    } ?>
        </p>
        <p id="new-total-price"><strong>Total Price:</strong> $<?php echo htmlspecialchars($booking['total_price']); ?></p>
    </div>

    <!-- Footer -->

    <!-- Script to handle dynamic updates -->
    <script>
        // Update the new booking details dynamically based on form input
        document.querySelector('form').addEventListener('input', function() {
            document.getElementById('new-user-id').innerHTML = '<strong>User ID:</strong> ' + document.getElementById('user_id').value;
            document.getElementById('new-departure-date').innerHTML = '<strong>Departure Date:</strong> ' + document.getElementById('datepicker').value;
            document.getElementById('new-person-count').innerHTML = '<strong>Person Count:</strong> ' + document.getElementById('person_count').value;
            const statusValue = document.getElementById('status').value;
            document.getElementById('new-status').innerHTML = '<strong>Status:</strong> ' + statusValue.charAt(0).toUpperCase() + statusValue.slice(1);
            const optionSelect = document.getElementById('option_id');
            const selectedOption = optionSelect.options[optionSelect.selectedIndex];
            document.getElementById('new-option').innerHTML = '<strong>Option:</strong> ' + selectedOption.textContent;
        });

        // Update the total price based on the selected option and current person count
        document.getElementById('option_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const basePrice = selectedOption.textContent.split('- $')[1];
            const personCount = document.getElementById('person_count').value;
            const totalPrice = (parseFloat(basePrice) * parseInt(personCount, 10)).toFixed(2);
            document.getElementById('new-total-price').innerHTML = '<strong>Total Price:</strong> $' + totalPrice;
            document.getElementById('total_price').value = totalPrice;
        });

        // Update the total price when the person count changes
        document.getElementById('person_count').addEventListener('input', function() {
            const personCount = parseInt(this.value, 10);
            const optionSelect = document.getElementById('option_id');
            const selectedOption = optionSelect.options[optionSelect.selectedIndex];
            const basePrice = selectedOption.textContent.split('- $')[1];
            const totalPrice = (parseFloat(basePrice) * parseInt(personCount, 10)).toFixed(2);
            document.getElementById('new-total-price').innerHTML = '<strong>Total Price:</strong> $' + totalPrice;
            document.getElementById('total_price').value = totalPrice;
        });

        // Initialize the datepicker
        $(function() {
            var beforeShowDay = function(date) {
                var day = date.getDay();
                return [day ==
                    <?php
                    require_once('../../assets/php/db.php');
                    // Fetch the booking details again to get the start day
                    $stmt = $conn->prepare("SELECT start_day FROM tours WHERE id = ?");
                    $stmt->bind_param("i", $booking['tour_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $tour = $result->fetch_assoc();
                    echo $tour['start_day'];
                    ?>
                ];
            };

            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0, // Prevent past dates
                beforeShowDay: beforeShowDay,
                onSelect: function(date) {
                    $('#new-departure-date').html('<strong>Departure Date:</strong> ' + date);
                }
            });
        });
    </script>
</body>

</html>