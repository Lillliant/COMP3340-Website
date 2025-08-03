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

// Activate the tour associated with the ID
$stmt = $conn->prepare("UPDATE tours SET is_active = 1 WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) { // Generate appropriate success or error messages
    $_SESSION['success'] = 'Tour activated successfully.';
} else {
    $_SESSION['error'] = 'Failed to activate tour: ' . $stmt->error;
}

// Redirect to the tour management page
header('Location: /3340/pages/user/tour.php');
exit;
