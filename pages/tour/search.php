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
    <div class="tour-overview">
        <?php
        if (count($tours) > 0) {
            foreach ($tours as $tour) {
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
                        <a href="/3340/pages/tour/tour.php?tourid=%s" class="btn btn-primary">View Tour</a>
                    </div>',
                    htmlspecialchars($tour['name']),
                    htmlspecialchars($tour['duration']),
                    htmlspecialchars($tour['duration'] > 1 ? 's' : ''),
                    htmlspecialchars(ucfirst($tour['category'])),
                    htmlspecialchars(ucfirst($tour['activity_level'])),
                    htmlspecialchars($tour['start_city']),
                    htmlspecialchars($tour['end_city']),
                    htmlspecialchars($tour['id'])
                );
            }
        }
        ?>
    </div>
    <!-- Footer -->
</body>

</html>