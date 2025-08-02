<?php
session_start();
require_once('../../assets/php/db.php');
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['account_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header("Location: /3340/404.php");
    exit;
}

if (
    !($_SERVER['REQUEST_METHOD'] === 'POST')
) {
    header('Location: /3340/pages/admin/booking.php');
    exit;
}

$newBookingData = [
    'user_id' => $_POST['user_id'],
    'tour_id' => $_POST['tour_id'],
    'departure_date' => $_POST['departure_date'],
    'total_price' => $_POST['total_price'],
    'person_count' => $_POST['person_count']
];

// Keep existing values if new ones are empty
foreach (['user_id', 'tour_id', 'departure_date', 'total_price', 'person_count'] as $field) {
    if (empty($_POST[$field])) {
        $newBookingData[$field] = $booking[$field]; // Keep existing value if new one is empty
    }
}

// Modify the user profile in the database
$stmt = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?");
$stmt->bind_param("ssssi", $newProfileData['username'], $newProfileData['first_name'], $newProfileData['last_name'], $newProfileData['email'], $_SESSION['account_id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Profile updated successfully!';
    header('Location: /3340/pages/user/profile.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update profile. Please try again.';
    header('Location: /3340/pages/user/profile.php');
    exit;
}
