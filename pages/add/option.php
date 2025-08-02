<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !is_numeric($_POST['tour_id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}

// Check if any of the required fields are empty
if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
    $_SESSION['error'] = 'Please fill in all required fields to add an option.';
    header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
    exit;
}

// Prepare and execute the SQL statement to insert the option
$stmt = $conn->prepare("INSERT INTO options (tour_id, name, description, price) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issd", $_POST['tour_id'], $_POST['name'], $_POST['description'], $_POST['price']);

if (!$stmt->execute()) {
    $_SESSION['error'] = 'Failed to add option: something went wrong.';
} else {
    $_SESSION['success'] = 'Option added successfully.';
}

// Redirect to the tour editing page
header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
