<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['option_id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Prepare and execute the SQL statement to insert the image
$stmt = $conn->prepare("DELETE FROM options WHERE id = ?");
$stmt->bind_param("i", $_POST['option_id']);
if (!$stmt->execute()) {
    $_SESSION['error'] = 'Failed to deleted option: something went wrong.';
} else {
    $_SESSION['success'] = 'Option deleted successfully.';
}

// Redirect to the tour editing page
header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
