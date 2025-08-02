<?php
// We need to use sessions, so you should always initialize sessions using the below function
session_start();

// Include database connection
require_once('../../assets/php/db.php');

// Obtain tour information from the database
$stmt = $conn->prepare("SELECT * FROM tours");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $tours = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $tours = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tours</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>

    <h2>Tours</h2>
    <div>
        <input type="text" id="searchInput" placeholder="Search for tours..." onkeyup="searchTour();" class="form-control mb-3">
    </div>
    <?php
    if (count($tours) > 0) {
        foreach ($tours as $tour) {
            echo '<div class="tour-overview">';
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
                '<div class="to-carousel">
                        <a href="/3340/pages/tour/tour.php?tourid=%s">
                            <img src="%s" alt="%s" class="d-block w-100" onerror="this.src=%s">
                        </a>
                    </div>',
                htmlspecialchars($tour['id']),
                $featuredImage ? htmlspecialchars($featuredImage['image_url']) : '/3340/assets/img/404.png',
                $featuredImage ? htmlspecialchars($featuredImage['alt']) : 'No image available',
                '/3340/assets/img/404.png'
            );

            echo sprintf(
                '<div class="to-details">
                        <h3>%s</h3>
                        <p>Duration: %d Day%s</p>
                        <p>Category: %s</p>
                        <p>Activity Level: %s</p>
                        <p>Start City: %s</p>
                        <p>End City: %s</p>
                        <p>Destination: %s</p>
                        <a href="/3340/pages/tour/tour.php?tourid=%s" class="btn btn-primary">View Tour</a>
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

            echo '</div>'; // Close tour-overview div
        }
    }
    ?>
    </div>
    <!-- Footer -->
    <script>
        function searchTour() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const tours = document.querySelectorAll('.tour-overview');

            tours.forEach(tour => {
                const title = tour.querySelector('h3').textContent.toLowerCase();
                if (title.includes(searchInput)) {
                    tour.style.display = 'flex';
                } else {
                    const details = tour.querySelectorAll('p');
                    let found = false;
                    details.forEach(detail => {
                        if (detail.textContent.toLowerCase().includes(searchInput)) {
                            found = true;
                        }
                    });
                    if (found) {
                        tour.style.display = 'flex';
                    } else {
                        tour.style.display = 'none';
                    }
                }
            });

            // Check if any tours are visible
            const visibleTours = Array.from(tours).some(tour => tour.style.display !== 'none');
            let noResults = document.getElementById('noResultsMessage');
            if (!visibleTours) {
                if (!noResults) {
                    noResults = document.createElement('p');
                    noResults.id = 'noResultsMessage';
                    noResults.textContent = 'No tours found.';
                    document.querySelector('body').appendChild(noResults);
                }
            } else {
                if (noResults) {
                    noResults.remove();
                }
            }
        }
    </script>
</body>

</html>