<?php
session_start(); // Initialize session
require_once('../../assets/php/db.php'); // Include database connection

if (
    !($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['password'])
) { // Validate request method and presence of password
    $_SESSION['error'] = 'Invalid request. Please try again.';
    header('Location: /3340/pages/edit/password.php');
    exit;
}

// Modify the user profile in the database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $_POST['password'], $_SESSION['account_id']);
if ($stmt->execute()) { // redirect to associated page with alert according to the result
    $_SESSION['success'] = 'Password updated successfully!';
    header('Location: /3340/pages/user/home.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update password. Please try again.';
    header('Location: /3340/pages/edit/password.php');
    exit;
}
