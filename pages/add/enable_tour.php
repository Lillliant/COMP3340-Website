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

// Activate the tour associated with the ID
$stmt = $conn->prepare("UPDATE tours SET is_active = 1 WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Tour activated successfully.';
} else {
    $_SESSION['error'] = 'Failed to activate tour: something went wrong.';
}

// Redirect to the tour management page
header('Location: /3340/pages/user/tour.php');
exit;
