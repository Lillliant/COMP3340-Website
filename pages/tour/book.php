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
if (empty($_POST['departure_date']) || empty($_POST['people'] || empty($_POST['option']))) {
    header('Location: /3340/404.php');
    exit;
}

// Add a new booking to the database
if ($stmt = mysqli_prepare($conn, 'INSERT INTO bookings (tour_id, user_id, departure_date, person_count, option_id, total_price) VALUES (?, ?, ?, ?, ?, ?)')) {
    $date = DateTime::createFromFormat('m/d/Y', $_POST['departure_date']);
    $newDate = $date->format('Y-m-d'); // Convert date to 'Y-m-d' format
    $optionId = (int) $_POST['option']; // Get the selected option ID from the form
    // Find the price of the selected option
    $optionPrice = 0;
    foreach ($_SESSION['options'] as $option) {
        if ($option['id'] == $optionId) {
            $optionPrice = $option['price'];
            break;
        }
    }
    $totalPrice = $optionPrice  * $_POST['people']; // Calculate total price
    // Bind POST data to the prepared statement
    mysqli_stmt_bind_param(
        $stmt,
        'iisddd',
        $_SESSION['tour']['id'], // Tour ID
        $_SESSION['account_id'], // User ID from session
        $newDate, // Departure date
        $_POST['people'], // Number of people
        $optionId, // Option ID
        $totalPrice // Total price calculated from the base price and number of people
    );
    mysqli_stmt_execute($stmt); // Execute the query
    mysqli_stmt_close($stmt); // Close the statement
    $bookingId = mysqli_insert_id($conn); // Get the last inserted booking ID
    header('Location: confirmation.php?booking_id=' . $bookingId); // Redirect to confirmation page with booking ID
}
