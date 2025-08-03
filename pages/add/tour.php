<?php
session_start(); // Start the session to access session variables

// Establish database connection
require_once('../../assets/php/db.php');

// If the user is not logged in, or is not an admin, redirect to home page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: /3340/index.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Add Tour</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Add tours for Trekker Tours. Manage all tours and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, tours, admin, manage tours">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Add Tour</h1>
    <!-- Display any success or error messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <a href="/3340/pages/user/tour.php" class="back-button">Back to Tours</a>

    <div class="center-form">
        <h2>Add Tour Details</h2>
        <!-- This form only adds to the tour details in the tours database table. -->
        <!-- Additional options and images needs to be added separately by editing the tour -->
        <form action="tour_validate.php" method="post">
            <!-- Autocomplete is off for cleaner looking form -->
            <label for="tour_name">Tour Name:</label>
            <input type="text" name="name" id="tour_name" maxlength="50" placeholder="Tour Name" autocomplete="off" required>
            <label for="lead_description">Tour Description:</label>
            <textarea name="description" id="lead_description" maxlength="4000" placeholder="Enter short tour description..." autocomplete="off" required></textarea>
            <label for="long_description">Itinerary Details:</label>
            <textarea name="long_description" id="long_description" maxlength="4000" placeholder="Enter itinerary details..." autocomplete="off" required></textarea>
            <label for="inclusions">Inclusions:</label>
            <textarea name="inclusions" id="inclusions" maxlength="4000" placeholder="Enter tour inclusions..." autocomplete="off" required></textarea>
            <label for="destination">Destination:</label>
            <input type="text" name="destination" id="destination" maxlength="255" placeholder="Destination" autocomplete="off" required>
            <label for="start_city">Start City:</label>
            <input type="text" name="start_city" id="start_city" maxlength="100" placeholder="Start City" autocomplete="off" required>
            <label for="end_city">End City:</label>
            <input type="text" name="end_city" id="end_city" maxlength="100" placeholder="End City" autocomplete="off" required>
            <!-- Category represents the type of tour -->
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="">Select an option.</option>
                <option value="adventure">Adventure</option>
                <option value="cultural">Cultural</option>
                <option value="relaxation">Relaxation</option>
            </select>
            <!-- Activity Level represents the physical intensity of the tour -->
            <label for="activity_level">Activity Level:</label>
            <select name="activity_level" id="activity_level" required>
                <option value="">Select an option.</option>
                <option value="relaxing">Relaxing</option>
                <option value="balanced">Balanced</option>
                <option value="challenging">Challenging</option>
            </select>
            <label for="duration">Duration (days):</label>
            <input type="number" name="duration" id="duration" placeholder="Duration (days)" min="1" required>
            <!-- Start Day represents the day of the week the tour starts -->
            <label for="start_day">Start Day:</label>
            <select name="start_day" id="start_day" required>
                <option value="">Select an option.</option>
                <option value="0">Sunday</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
            </select>
            <input type="submit" value="Add">
        </form>
    </div>
</body>

</html>