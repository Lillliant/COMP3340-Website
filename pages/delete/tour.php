<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/admin/booking.php');
    exit;
}

// Deactivate the tour associated with the ID
$stmt = $conn->prepare("UPDATE tours SET is_active = 0 WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Tour deactivated successfully.';
} else {
    $_SESSION['error'] = 'Failed to deactivate tour: something went wrong.';
}

// Because of the SQL schema, deleting the tour will also delete all associated bookings, options, and images
$stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Tour deleted successfully.';
} else {
    $_SESSION['error'] = 'Failed to delete tour: something went wrong.';
}

// Redirect to the tour management page
header('Location: /3340/pages/user/tour.php');
exit;
