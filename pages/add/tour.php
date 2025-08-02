<?php
session_start();

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Tour</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
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

    <div id="tour-container" class="center-form">
        <h2>Add Tour Details</h2>
        <!-- This form only adds to the tour details in the tours database table. -->
        <form action="tour_validate.php" method="post">
            <label for="name">Tour Name:</label>
            <input type="text" name="name" id="name" placeholder="Tour Name" required>
            <label for="description">Tour Description:</label>
            <textarea name="description" id="description" placeholder="Tour Description" required></textarea>
            <label for="long_description">Itinerary Details:</label>
            <textarea name="long_description" id="long_description" placeholder="Itinerary Details" required></textarea>
            <label for="inclusions">Inclusions:</label>
            <textarea name="inclusions" id="inclusions" placeholder="Inclusions" required></textarea>
            <label for="destination">Destination:</label>
            <input type="text" name="destination" id="destination" placeholder="Destination" required>
            <label for="start_city">Start City:</label>
            <input type="text" name="start_city" id="start_city" placeholder="Start City" required>
            <label for="end_city">End City:</label>
            <input type="text" name="end_city" id="end_city" placeholder="End City" required>
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="adventure">Adventure</option>
                <option value="cultural">Cultural</option>
                <option value="relaxation">Relaxation</option>
            </select>
            <label for="activity_level">Activity Level:</label>
            <select name="activity_level" id="activity_level" required>
                <option value="easy">Relaxing</option>
                <option value="moderate">Balanced</option>
                <option value="difficult">Challenging</option>
            </select>
            <label for="duration">Duration (days):</label>
            <input type="number" name="duration" id="duration" placeholder="Duration (days)" min="1" required>
            <label for="start_day">Start Day:</label>
            <select name="start_day" id="start_day" required>
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

    <!-- Footer -->
</body>

</html>