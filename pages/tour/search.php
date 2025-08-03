<?php
session_start(); // Initialize session

// Include database connection
require_once('../../assets/php/db.php');

// Obtain tour information from the database
$stmt = $conn->prepare("SELECT * FROM tours");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $tours = $result->fetch_all(MYSQLI_ASSOC);
} else { // If no tours are found, initialize an empty array
    $tours = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Search Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Search and discover Trekker Tours. Find your next adventure by browsing our curated list of tours and destinations.">
    <meta name="keywords" content="search tours, travel, adventure, trekking, holidays, destinations, booking, trekker tours">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Search for Tours</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <p class="lead">
        Use the search bar below to find tours that match your interests.
    </p>
    <!-- Search bar for tours -->
    <div id="searchContainer">
        <input type="search" id="searchInput" placeholder="Search for tours..." onkeyup="searchTour();" class="form-control mb-3 border-end-0 rounded-pill">
    </div>
    <!-- Tour result container -->
    <div id="tourContainer">
        <?php
        // For each tour, create a card with details
        if (count($tours) > 0) {
            foreach ($tours as $tour) {
                echo '<div class="card m-3 tour-card">'; // Start card container div
                // Display each tour's image as a link
                $stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ? AND is_featured = 1 LIMIT 1");
                $stmt->bind_param("i", $tour['id']);
                $stmt->execute();
                $featuredImageResult = $stmt->get_result();
                if ($featuredImageResult->num_rows > 0) {
                    $featuredImage = $featuredImageResult->fetch_assoc();
                } else {
                    $featuredImage = null; // No featured image found
                }

                echo sprintf(
                    '<a href="/3340/pages/tour/tour.php?tourid=%s">
                        <img src="%s" alt="%s" class="card-img-top" onerror="this.src=%s">
                    </a>',
                    htmlspecialchars($tour['id']),
                    $featuredImage ? htmlspecialchars($featuredImage['image_url']) : '/3340/assets/img/404.png',
                    $featuredImage ? htmlspecialchars($featuredImage['alt']) : 'No image available',
                    '/3340/assets/img/404.png'
                );

                echo sprintf(
                    '<div class="card-body">
                        <h3 class="card-title">%s</h3>
                        <p class="card-text">Duration: %d Day%s</p>
                        <p class="card-text">Category: %s</p>
                        <p class="card-text">Activity Level: %s</p>
                        <p class="card-text">Start City: %s</p>
                        <p class="card-text">End City: %s</p>
                        <p class="card-text">Destination: %s</p>
                        <button href="/3340/pages/tour/tour.php?tourid=%s">View Tour</button>
                    </div>',
                    htmlspecialchars($tour['name']),
                    htmlspecialchars($tour['duration']),
                    htmlspecialchars($tour['duration'] > 1 ? 's' : ''),
                    htmlspecialchars(ucfirst($tour['category'])),
                    htmlspecialchars(ucfirst($tour['activity_level'])),
                    htmlspecialchars($tour['start_city']),
                    htmlspecialchars($tour['end_city']),
                    htmlspecialchars($tour['destination']),
                    htmlspecialchars($tour['id'])
                );

                echo '</div>'; // Close card container div
            }
        }
        ?>
    </div>
    <!-- Import search functionality script -->
    <script src="../../assets/js/search.js"></script>
</body>

</html>