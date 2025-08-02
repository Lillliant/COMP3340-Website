<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['tour_id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Check if any of the required fields are empty
if (empty($_POST['image_url']) || empty($_POST['image_alt'])) {
    $_SESSION['error'] = 'Please fill in all required fields to add an image.';
    header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
    exit;
}

// Prepare and execute the SQL statement to insert the image
$stmt = $conn->prepare("INSERT INTO images (tour_id, image_url, alt) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $_POST['tour_id'], $_POST['image_url'], $_POST['image_alt']);
if (!$stmt->execute()) {
    $_SESSION['error'] = 'Failed to add image: something went wrong.';
} else {
    $_SESSION['success'] = 'Image added successfully.';
}

// Redirect to the tour editing page
header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
