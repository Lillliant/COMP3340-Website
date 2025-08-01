<?php
session_start(); // Start the session
require_once('../../assets/php/db.php'); // Include the database connection file

// Redirect to the login page if the form was not submitted, or if the required fields are not set
if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: /3340/pages/login/login.php');
}

// Examining the username and password from the POST request
if ($stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? AND password = ?')) {
    // Bind the username and password parameters to the prepared statement and execute the query
    mysqli_stmt_bind_param($stmt, 'ss', $_POST['username'], $_POST['password']);
    mysqli_stmt_execute($stmt);
    // Store the result to check if the account with the same username exists
    $result = mysqli_stmt_get_result($stmt);

    // If the account is successfully found, we can proceed to login
    if ($result->num_rows == 1) {
        session_regenerate_id();
        $id = $result->fetch_assoc()['id']; // Fetch the user ID from the result
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['account_name'] = $_POST['username'];
        $_SESSION['account_id'] = $id;
        if (isset($_SESSION['tourid'])) {
            header('Location: /3340/pages/tour/booking.php?tourid=' . $_SESSION['tourid']);
        } else {
            header('Location: /3340/pages/user/home.php');
        }
        exit;
    } else { // If the combination is incorrect, redirect to the login page with an error message
        $_SESSION['error'] = 'Incorrect username and/or password!';
        header('Location: /3340/pages/login/login.php');
        exit;
    }
}
