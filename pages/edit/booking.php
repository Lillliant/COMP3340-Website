<?php
session_start();

require_once('../../assets/php/db.php');

// If the user is already logged in, redirect to home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

// Fetch the booking details from the database
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

// Fetch the selected option for the booking
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $booking['option_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $option = $result->fetch_assoc();
} else {
    header("Location: /3340/404.php");
    exit;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>

    <h2>Edit Booking</h2>
    <div class="center-form">
        <form action="profile_validate.php" method="post">
            <input type="text" name="user_id" id="user_id" placeholder=<?php echo htmlspecialchars($booking['user_id']); ?> value="<?php echo htmlspecialchars($booking['user_id']); ?>">
            <input type="text" name="tour_id" id="tour_id" placeholder=<?php echo htmlspecialchars($booking['tour_id']); ?> value="<?php echo htmlspecialchars($booking['tour_id']); ?>">
            <input type="text" id="datepicker" name="departure_date" placeholder=<?php echo htmlspecialchars($booking['departure_date']); ?> value="<?php echo htmlspecialchars($booking['departure_date']); ?>">
            <input type="number" name="person_count" id="person_count" min="1" max="30" value=<?php echo htmlspecialchars($booking['person_count']); ?> value="<?php echo htmlspecialchars($booking['person_count']); ?>">
            <input type="number" name="total_price" id="total_price" min="0" value=<?php echo htmlspecialchars($booking['total_price']); ?> value="<?php echo htmlspecialchars($booking['total_price']); ?>">
            <!-- Change the status of the booking -->
            <select name="status" id="status">
                <option value="pending" <?php if ($booking['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                <option value="confirmed" <?php if ($booking['status'] === 'confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="cancelled" <?php if ($booking['status'] === 'cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
            <select name="option_id" id="option_id">
                <option value="<?php echo htmlspecialchars($option['id']); ?>" selected><?php echo htmlspecialchars($option['name']) . ' - $' . htmlspecialchars($option['price']); ?></option>
                <?php
                // Fetch all options from the database
                $stmt = $conn->prepare("SELECT * FROM options WHERE tour_id = ?");
                $stmt->bind_param("i", $booking['tour_id']);
                $stmt->execute();
                $optionsResult = $stmt->get_result();
                while ($opt = $optionsResult->fetch_assoc()) {
                    if ($opt['id'] !== $option['id']) {
                        echo '<option value="' . htmlspecialchars($opt['id']) . '">' . htmlspecialchars($opt['name']) . ' - $' . htmlspecialchars($opt['price']) . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="Edit">
        </form>
    </div>
    <!-- Old booking details -->
    <div>
        <h3>Old Booking Details</h3>
        <p>User ID: <?php echo htmlspecialchars($booking['user_id']); ?></p>
        <p>Tour ID: <?php echo htmlspecialchars($booking['tour_id']); ?></p>
        <p>Departure Date: <?php echo htmlspecialchars($booking['departure_date']); ?></p>
        <p>Person Count: <?php echo htmlspecialchars($booking['person_count']); ?></p>
        <p>Total Price: <?php echo htmlspecialchars($booking['total_price']); ?></p>
        <p>Status: <?php echo htmlspecialchars($booking['status']); ?></p>
        <p>Option: <?php echo sprintf("%s - $%s", htmlspecialchars($option['name']), htmlspecialchars($option['price'])); ?></p>
    </div>
    <!-- New booking details -->
    <div>
        <h3>New Booking Details</h3>
        <p id="new-user-id">User ID: <?php echo htmlspecialchars($booking['user_id']); ?></p>
        <p id="new-tour-id">Tour ID: <?php echo htmlspecialchars($booking['tour_id']); ?></p>
        <p id="new-departure-date">Departure Date: <?php echo htmlspecialchars($booking['departure_date']); ?></p>
        <p id="new-person-count">Person Count: <?php echo htmlspecialchars($booking['person_count']); ?></p>
        <p id="new-total-price">Total Price: <?php echo htmlspecialchars($booking['total_price']); ?></p>
        <p id="status">Status: <?php echo htmlspecialchars($booking['status']); ?></p>
        <p id="option">Option: <?php
                                if (isset($booking['option_id'])) {
                                    $optionId = $booking['option_id'];
                                    $stmt = $conn->prepare("SELECT name, price FROM options WHERE id = ?");
                                    $stmt->bind_param("i", $optionId);
                                    $stmt->execute();
                                    $optionResult = $stmt->get_result();
                                    if ($optionResult->num_rows > 0) {
                                        $optionData = $optionResult->fetch_assoc();
                                        echo sprintf("%s - $%s", htmlspecialchars($optionData['name']), htmlspecialchars($optionData['price']));
                                    } else {
                                        echo 'Option not found';
                                    }
                                } else {
                                    echo 'No option selected';
                                } ?></p>
    </div>

    <script>
        // Update the new booking details dynamically
        document.querySelector('form').addEventListener('input', function() {
            document.getElementById('new-user-id').textContent = 'User ID: ' + document.getElementById('user_id').value;
            document.getElementById('new-tour-id').textContent = 'Tour ID: ' + document.getElementById('tour_id').value;
            document.getElementById('new-departure-date').textContent = 'Departure Date: ' + document.getElementById('datepicker').value;
            document.getElementById('new-person-count').textContent = 'Person Count: ' + document.getElementById('person_count').value;
            document.getElementById('new-total-price').textContent = 'Total Price: ' + document.getElementById('total_price').value;
            document.getElementById('status').textContent = 'Status: ' + document.getElementById('status').value;
            const optionSelect = document.getElementById('option_id');
            const selectedOption = optionSelect.options[optionSelect.selectedIndex];
            document.getElementById('option').textContent = 'Option: ' + selectedOption.textContent;
        });

        // Update the total price based on the selected option
        document.getElementById('option_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.value.split('- $')[1];
            //document.getElementById('total_price').placeholder = price.toString();
            document.getElementById('new-total-price').textContent = 'Total Price: $' + price;
        });

        // Update the total price when the person count changes
        document.getElementById('person_count').addEventListener('input', function() {
            const personCount = parseInt(this.value, 10);
            const optionSelect = document.getElementById('option_id');
            const selectedOption = optionSelect.options[optionSelect.selectedIndex];
            const pricePerPerson = parseFloat(selectedOption.value.split('- $')[1]);
            const totalPrice = personCount * pricePerPerson;
            //document.getElementById('total_price').placeholder = totalPrice.toFixed(2).toString();
            document.getElementById('new-total-price').textContent = 'Total Price: $' + totalPrice.toFixed(2);
        });

        // Initialize the datepicker
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0, // Prevent past dates
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day === <?php echo $_SESSION['tour']['start_day']; ?>, '', ''];
                },
                onSelect: function(dateText) {
                    document.getElementById('new-departure-date').textContent = 'Departure Date: ' + dateText;
                    var departureDate = new Date(dateText);
                    var arrivalDate = new Date(departureDate);
                    arrivalDate.setDate(arrivalDate.getDate() + <?php echo $_SESSION['tour']['duration']; ?>);
                    document.getElementById('arrival-date').textContent = 'Arrival Date: ' + arrivalDate.toDateString();
                }
            });
        });
    </script>

    <!-- Footer -->
</body>

</html>