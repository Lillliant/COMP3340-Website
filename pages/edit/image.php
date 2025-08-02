<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['image_id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Prepare and execute the SQL statement to make the image featured
// Make sure there are only one featured image per tour
$stmt = $conn->prepare("UPDATE images SET is_featured = 0 WHERE tour_id = ?");
$stmt->bind_param("i", $_POST['tour_id']);
if (!$stmt->execute()) {
    $_SESSION['error'] = 'Failed to update featured image: something went wrong.';
} else {
    $stmt = $conn->prepare("UPDATE images SET is_featured = 1 WHERE id = ?");
    $stmt->bind_param("i", $_POST['image_id']);
    if (!$stmt->execute()) {
        $_SESSION['error'] = 'Failed to make image featured: something went wrong.';
    } else {
        $_SESSION['success'] = 'Featured image updated successfully.';
    }
}

// Redirect to the tour editing page
header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
