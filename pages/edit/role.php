<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// Check if the page is accessed via POST method
if (!($_SERVER['REQUEST_METHOD'] === 'POST') || !isset($_POST['id'])) {
    $_SESSION['error'] = 'Page accessed illegally.';
    header('Location: /3340/pages/user/user.php');
    exit;
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You must be logged in as an admin to modify an user.';
    header('Location: /3340/pages/user/user.php');
    exit;
}

// Check if the user is trying to delete their own account
if ($_SESSION['account_id'] == $_POST['id']) {
    $_SESSION['error'] = 'You cannot modify your own account.';
    header('Location: /3340/pages/user/user.php');
    exit;
}

// Prepare and execute the SQL statement to update the user role
$stmt = $conn->prepare("UPDATE users SET role = CASE WHEN role = 'admin' THEN 'user' ELSE 'admin' END WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
if ($stmt->execute()) {
    $_SESSION['success'] = 'User role updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update user role: ' . $stmt->error;
}

// Redirect to the tour management page
header('Location: /3340/pages/user/user.php');
exit;
