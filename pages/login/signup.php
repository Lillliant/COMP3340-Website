<?php
session_start();
require_once('../../assets/php/db.php'); // Include the database connection file

// Return to the registration page if the form was not submitted or if the required fields are not set
if (
    !($_SERVER['REQUEST_METHOD'] === 'POST') ||
    !isset($_POST['username'], $_POST['email'], $_POST['password'])
) {
    header('Location: /3340/pages/login/register.php');
    exit;
}

// Check if the required fields are empty
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: /3340/pages/login/register.php');
    exit;
}

// Check if username or email already exists
if ($stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? OR email = ?')) {
    mysqli_stmt_bind_param($stmt, 'ss', $_POST['username'], $_POST['email']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // If the username or email already exists, redirect to the registration page with an error message
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = 'Username or email already exists!';
        header('Location: /3340/pages/login/register.php');
        exit;
    } else {
        // Create a new account
        if ($stmt = mysqli_prepare($conn, 'INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
            // Bind POST data to the prepared statement
            mysqli_stmt_bind_param($stmt, 'sss', $_POST['username'], $_POST['password'], $_POST['email']);
            mysqli_stmt_execute($stmt);

            // Output success message
            $_SESSION['success'] = 'You have successfully registered! You can now login!';
            header('Location: /3340/pages/login/login.php');
            exit;
        } else {
            // Something is wrong with the SQL statement, check to make sure the users table exists with all 3 fields
            $_SESSION['error'] = 'Something went wrong with the registration process. Please try again.';
            header('Location: /3340/pages/login/register.php');
            exit;
        }
    }
}
