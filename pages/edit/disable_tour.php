<?php
session_start(); // Start the session to access session variables

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Disable the tour associated with the ID
$stmt = $conn->prepare("UPDATE tours SET is_active = 0 WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) { // Generate appropriate success or error messages
    $_SESSION['success'] = 'Tour disabled successfully.';
} else {
    $_SESSION['error'] = 'Failed to disable tour: ' . $stmt->error;
}

// Cancel all bookings associated with the tour
$stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE tour_id = ?");
$stmt->bind_param("i", $_POST['id']);
if (!$stmt->execute()) { // Append appropriate messages to the session
    $_SESSION['error'] .= ' Failed to cancel associated bookings: ' . $stmt->error;
} else {
    $_SESSION['success'] .= ' All associated bookings have been cancelled.';
}

// Redirect to the tour management page
header('Location: /3340/pages/user/tour.php');
exit;
