<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/booking.php');
    exit;
}

// Delete the booking from the database
$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) { // Check if the deletion was successful
    $_SESSION['success'] = 'Booking deleted successfully.';
    header('Location: /3340/pages/user/booking.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to delete booking: Something went wrong.';
    header('Location: /3340/pages/user/booking.php');
    exit;
}
