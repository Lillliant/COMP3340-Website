<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/booking.php');
    exit;
}

// Fetch old booking detail from the database
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $_POST['booking_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Booking not found.';
    header('Location: /3340/pages/user/booking.php');
    exit;
}
$oldBookingData = $result->fetch_assoc();
$stmt->close();


// Validate form input
// Check if any of the fields are empty
$newBookingData = [
    'id' => $_POST['booking_id'],
    'status' => $_POST['status'],
    'user_id' => $_POST['user_id'],
    'departure_date' => $_POST['departure_date'],
    'person_count' => $_POST['person_count'],
    'option_id' => $_POST['option_id'],
    'total_price' => $_POST['total_price']
];
// If any field is empty, keep the old value
foreach ($newBookingData as $key => $value) {
    if (empty($value)) {
        $newBookingData[$key] = $oldBookingData[$key];
    }
}

// Check if the user ID is valid
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $newBookingData['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Invalid user ID.';
    header('Location: /3340/pages/edit/booking.php?id=' . $newBookingData['id']);
    exit;
}

// Update the booking in the database
$stmt = $conn->prepare("UPDATE bookings SET status = ?, user_id = ?, departure_date = ?, person_count = ?, option_id = ?, total_price = ? WHERE id = ?");
$stmt->bind_param(
    "sissdii",
    $newBookingData['status'],
    $newBookingData['user_id'],
    $newBookingData['departure_date'],
    $newBookingData['person_count'],
    $newBookingData['option_id'],
    $newBookingData['total_price'],
    $newBookingData['id']
);
if ($stmt->execute()) { // Check if the update was successful
    $_SESSION['success'] = 'Booking updated successfully.';
    header('Location: /3340/pages/user/booking.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update booking: Something went wrong.';
    header('Location: /3340/pages/edit/booking.php?id=' . $newBookingData['id']);
    exit;
}
