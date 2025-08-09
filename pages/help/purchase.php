<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>User Guide to Bookings</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="User guide for managing bookings on Trekker Tours. Learn how to view, edit, and delete tour reservations.">
    <meta name="keywords" content="trekker tours, booking management, user guide, tour reservations">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>User Guide</h1>
    <h2>How to Manage Bookings</h2>
    <p class="lead">
        This guide will show you how to use the dynamic PHP and JavaScript functionalities to manage the tour booking reservations.
    </p>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>

    <div style="max-width: 800px; margin: 0 auto; ">
        <!-- Visual example for making bookings -->
        <video controls style="width: 100%; height: auto; margin-bottom: 20px;">
            <source src="/3340/assets/videos/make-booking.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <hr>
        <!-- Instructions for managing bookings -->
        <div style="display: flex; flex-direction: column; justify-content: center; gap: 1rem; text-align: justify;">
            <!-- Where to View Bookings -->
            <h3>Where to View Bookings</h3>
            <div>
                <ol style="text-align: justify;">
                    <li>
                        <a href="/3340/pages/login/login.php">Log in</a> to the user dashboard. If you need help, visit the <a href="/3340/pages/help/login.php">Login Guide</a>.
                    </li>
                    <li>
                        Go to the <a href="/3340/pages/user/booking.php">Manage Bookings</a> section from the dashboard menu.
                    </li>
                    <li>
                        Review all your reservations, including customer details, trip dates, and booking status.
                    </li>
                </ol>
            </div>
            
            <!-- Instructions for adding bookings -->
            <h3>How to Make Bookings</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/index.php">Trekker Tours</a> homepage or the <a href="/3340/pages/tour/search.php">Tour Search</a> page, find the tour you want to book.
                </li>
                <li>Once in the tour detail page, click on the "Book Now" button.</li>
                <li>
                    Fill in the booking form with trip dates and any additional options.
                </li>
                <li>
                    Click "Book Now" to create the new booking record. You will see the booking details on the confirmation page.
                </li>
            </ol>

            <!-- Instructions for editing bookings -->
            <h3>How to Edit Bookings</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/booking.php">Manage Bookings</a> section, find the booking you want to update.
                </li>
                <li>
                    Click the "Edit" button next to the booking.
                </li>
                <li>
                    In the new page, change trip dates and status, update customer and selection information, or adjust group sizes as needed. Any unchanged fields will retain their original values.
                </li>
                <li>Review and compare the old and new booking details on the page before proceeding.</li>
                <li>
                    Click "Edit" to update the booking record.
                </li>
            </ol>

            <!-- Instructions for deleting bookings -->
            <h3>How to Delete a Booking</h3>
            <ol style="text-align: justify;">
                <li>
                    In the <a href="/3340/pages/user/booking.php">Manage Bookings</a> section, select the booking you wish to remove.
                </li>
                <li>
                    Click the "Delete" button next to the booking.
                </li>
                <li>
                    Confirm the deletion when prompted. This will permanently remove the booking from the system.
                </li>
            </ol>
        </div>
    </div>
</body>

</html>