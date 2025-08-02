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

// Fetch old option detail from the database
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Options not found.';
    header('Location: /3340/pages/edit/tour.php?' . $_POST['tour_id']);
    exit;
}
$oldOptionData = $result->fetch_assoc();
$stmt->close();

// Validate form input
// Check if any of the fields are empty
$newOptionData = [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
];
// If any field is empty, keep the old value
foreach ($newOptionData as $key => $value) {
    if (empty($value)) {
        $newOptionData[$key] = $oldOptionData[$key];
    }
}

// Update the option in the database
$stmt = $conn->prepare("UPDATE options SET name = ?, description = ?, price = ? WHERE id = ?");
$stmt->bind_param(
    "ssdi",
    $newOptionData['name'],
    $newOptionData['description'],
    $newOptionData['price'],
    $_POST['id']
);
if ($stmt->execute()) { // Check if the update was successful
    $_SESSION['success'] = 'Option updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update option: Something went wrong.';
}

header('Location: /3340/pages/edit/tour.php?id=' . $_POST['tour_id']);
exit;
