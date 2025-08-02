<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Validate form input
// If any field is empty, exit with an error message
foreach ($_POST as $key => $value) {
    if (empty($value)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: /3340/pages/add/tour.php');
        exit;
    }
}

// Add the tour into the database
$stmt = $conn->prepare("INSERT INTO tours (name, description, long_description, inclusions, destination, start_city, end_city, start_day, category, activity_level, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    'sssssssisss',
    $_POST['name'],
    $_POST['description'],
    $_POST['long_description'],
    $_POST['inclusions'],
    $_POST['destination'],
    $_POST['start_city'],
    $_POST['end_city'],
    $_POST['start_day'],
    $_POST['category'],
    $_POST['activity_level'],
    $_POST['duration']
);

if ($stmt->execute()) { // Check if the update was successful
    $_SESSION['success'] = 'Tour updated successfully.';
    header('Location: /3340/pages/user/tour.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update tour: Something went wrong.';
    header('Location: /3340/pages/add/tour.php');
    exit;
}
