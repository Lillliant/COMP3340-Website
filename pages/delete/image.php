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

// Check if the image is featured
$stmt = $conn->prepare("SELECT is_featured FROM images WHERE id = ?");
$stmt->bind_param("i", $_POST['image_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row && $row['is_featured'] == 1) {
    $_SESSION['error'] = 'Featured Image cannot be deleted.';
    header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
    exit;
}

// Prepare and execute the SQL statement to insert the image
$stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
$stmt->bind_param("i", $_POST['image_id']);
if (!$stmt->execute()) {
    $_SESSION['error'] = 'Failed to deleted image: something went wrong.';
} else {
    $_SESSION['success'] = 'Image deleted successfully.';
}

// Redirect to the tour editing page
header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
