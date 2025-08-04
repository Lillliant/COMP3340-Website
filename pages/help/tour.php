<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>How to Manage Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Admin guide for managing tours on Trekker Tours. Learn how to view, edit, add images, and delete tours using the dashboard.">
    <meta name="keywords" content="manage tours, admin guide, trekker tours, edit tour, add tour image, delete tour, tour dashboard, bookings, travel management">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Admin Guide</h1>
    <h2>How to Manage Tours</h2>
    <p class="lead">
        This guide will show you how to use the dynamic PHP and JavaScript functionalities to manage the tour details that are displayed on the website and used in bookings.
    </p>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>
    <div style="max-width: 800px; margin: 0 auto; ">
        <!-- Visual example for managing tours -->
        <video controls style="width: 100%; height: auto; margin-bottom: 20px;">
            <source src="/3340/assets/videos/manage-tour.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <hr>
        <div style="display: flex; flex-direction: column; justify-content: center; gap: 1rem; text-align: justify;">
            <h3>Where to View Tours</h3>
            <div>
                <ol style="text-align: justify;">
                    <li>
                        <a href="/3340/pages/login/login.php">Log in</a> to the admin dashboard. If you need help, visit the <a href="/3340/pages/help/login.php">Login Guide</a>.
                    </li>
                    <li>
                        Go to the <a href="/3340/pages/user/tour.php">Manage Tours</a> section from the dashboard menu.
                    </li>
                    <li>
                        Review all tours, including tour details, options, images, available dates, and status.
                    </li>
                </ol>
            </div>

            <h3>How to Add Tours</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/tour.php">Manage Tours</a> section, click the "Add Tour" button.
                </li>
                <li>
                    Fill in the tour details such as name, description, available dates, and options.
                </li>
                <li>
                    Click "Add" to create the new tour record.
                </li>
                <li>
                    After adding, you can immediately add images and options for the tour using the provided forms in the Edit Tour page.
                </li>
            </ol>

            <h3>How to Edit Tours</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/tour.php">Manage Tours</a> section, locate the tour you wish to update.
                </li>
                <li>
                    Click the "Edit" button next to the tour.
                </li>
                <li>
                    On the edit page, modify tour details such as name, description, available days, images, options, or status. Fields left unchanged will keep their current values. For each option and/or image, separate forms are used to modify their details.
                </li>
                <li>
                    Click "Edit" to update the tour record.
                </li>
            </ol>

            <h3>How to Disable/Enable Tours</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/tour.php">Manage Tours</a> section, find the tour you want to disable or enable.
                </li>
                <li>
                    Click the "Disable" or "Enable" button next to the tour.
                </li>
                <li>
                    Confirm the action when prompted. Disabling a tour will prevent it from being booked and cancel any existing un-completed bookings, while enabling it will make it available again.
                </li>
            </ol>

            <h3>How to Delete Tours</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/tour.php">Manage Tours</a> section, select the tour you wish to remove.
                </li>
                <li>
                    Click the "Delete" button next to the tour.
                </li>
                <li>
                    Confirm the deletion when prompted. This will permanently remove the tour from the system, including all associated images and options.
                </li>
            </ol>

            <h3>Database Schema for Tours</h3>
            <p>
                The tours are stored in the <code>tours</code> table with the following structure. Supplementary data such as images and options are stored in related tables.
            </p>
            <embed src="/3340/assets/sql/tour.txt" type="text/plain" style="width: 100%; height: 500px; border: none; padding: 20px 0;">
        </div>
    </div>
</body>

</html>