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

// Deactivate the tour associated with the booking
$stmt = $conn->prepare("UPDATE tours SET is_active = 0 WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Tour deactivated successfully.';
} else {
    $_SESSION['error'] = 'Failed to deactivate tour: something went wrong.';
}

// Check if there are any bookings associated with the tour
$stmt = $conn->prepare("SELECT id FROM bookings WHERE tour_id = ?");
$stmt->bind_param("i", $_POST['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Cancel all bookings associated with the tour
    $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE tour_id = ? AND status != 'cancelled' AND status != 'completed'");
    $stmt->bind_param("i", $_POST['id']);
    if ($stmt->execute()) {
        $_SESSION['success'] .= ' All associated bookings have been cancelled.';
    } else {
        $_SESSION['error'] .= ' Failed to cancel bookings: something went wrong.';
    }
} else {
    $_SESSION['success'] = 'No bookings were associated with this tour.';

    // Proceed to delete the tour and its associated images and options
    $stmt = $conn->prepare("DELETE FROM images WHERE tour_id = ?");
    $stmt->bind_param("i", $_POST['id']);
    if ($stmt->execute()) {
        $_SESSION['success'] .= ' Tour images deleted successfully.';
    } else {
        $_SESSION['error'] .= ' Failed to delete tour images: something went wrong.';
    }

    $stmt = $conn->prepare("DELETE FROM options WHERE tour_id = ?");
    $stmt->bind_param("i", $_POST['id']);
    if ($stmt->execute()) {
        $_SESSION['success'] .= ' Tour options deleted successfully.';
    } else {
        $_SESSION['error'] .= ' Failed to delete tour options: something went wrong.';
    }

    $stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    if ($stmt->execute()) {
        $_SESSION['success'] .= ' Tour deleted successfully.';
    } else {
        $_SESSION['error'] .= ' Failed to delete tour: something went wrong.';
    }
}

// Redirect to the tour management page
header('Location: /3340/pages/user/tour.php');
exit;
