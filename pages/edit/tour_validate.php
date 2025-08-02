<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/booking.php');
    exit;
}

// Fetch old tour detail from the database
$stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->bind_param("i", $_POST['tour_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Tour not found.';
    header('Location: /3340/pages/user/tour.php');
    exit;
}
$oldTourData = $result->fetch_assoc();
$stmt->close();

// Validate form input
// Check if any of the fields are empty
$newTourData = [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'long_description' => $_POST['long_description'],
    'inclusions' => $_POST['inclusions'],
    'destination' => $_POST['destination'],
    'start_city' => $_POST['start_city'],
    'end_city' => $_POST['end_city'],
    'start_day' => $_POST['start_day'],
    'category' => $_POST['category'],
    'activity_level' => $_POST['activity_level'],
    'duration' => $_POST['duration'],
];
// If any field is empty, keep the old value
foreach ($newTourData as $key => $value) {
    if (empty($value)) {
        $newTourData[$key] = $oldTourData[$key];
    }
}

// Update the tour in the database
$stmt = $conn->prepare("UPDATE tours SET name = ?, description = ?, long_description = ?, inclusions = ?, destination = ?, start_city = ?, end_city = ?, start_day = ?, category = ?, activity_level = ?, duration = ? WHERE id = ?");
$stmt->bind_param(
    "ssssssssssii",
    $newTourData['name'],
    $newTourData['description'],
    $newTourData['long_description'],
    $newTourData['inclusions'],
    $newTourData['destination'],
    $newTourData['start_city'],
    $newTourData['end_city'],
    $newTourData['start_day'],
    $newTourData['category'],
    $newTourData['activity_level'],
    $newTourData['duration'],
    $_POST['tour_id']
);
if ($stmt->execute()) { // Check if the update was successful
    $_SESSION['success'] = 'Tour updated successfully.';
    header('Location: /3340/pages/user/tour.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update tour: Something went wrong.';
    header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
    exit;
}
