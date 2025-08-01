<?php
// Start the session
session_start();
require_once('../../assets/php/db.php');

// Fetch tour object of given ID in the URL
if (isset($_GET['tourid'])) {
    $tourId = $_GET['tourid'];

    // Fetch tour details from the database
    $stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $tour = $result->fetch_assoc();
    } else {
        header("Location: ../404.php");
        exit;
    }
    $stmt->close();

    // Fetch tour images
    // Fetch the featured image first
    $stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ? AND is_featured = 1 LIMIT 1");
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $featuredImageResult = $stmt->get_result();
    if ($featuredImageResult->num_rows > 0) {
        $featuredImage = $featuredImageResult->fetch_assoc();
    } else {
        $featuredImage = null; // No featured image found
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ? AND is_featured = FALSE ORDER BY created_at DESC");
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $imagesResult = $stmt->get_result();
    $additionalImages = [];
    while ($image = $imagesResult->fetch_assoc()) {
        $additionalImages[] = $image;
    }

    // TODO: handle case where no images are found

    $stmt->close();
} else { // No tour ID provided, default to the first tour
    header("Location: tour.php?tourid=1");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trekker Tours</title>
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
    <div class="tour-overview">
        <div id="carouseltourIndicators" class="carousel slide to-carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouseltourIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src=<?php echo sprintf("'%s'", $featuredImage != null ? $featuredImage['image_url'] : '/3340/assets/img/404.png') ?>
                        class="d-block w-100"
                        onerror="this.src='/3340/assets/img/404.png'"
                        alt=<?php echo sprintf("'%s'", $featuredImage != null ? $featuredImage['alt'] : 'Error: image not found') ?>>
                </div>
                <!-- Display additional images if available -->
                <?php
                for ($i = 0; $i < count($additionalImages); $i++) {
                    echo sprintf(
                        '<div class="carousel-item"><img src="%s" class="d-block w-100" onerror="this.src=\'/3340/assets/img/404.png\'" alt="%s"></div>',
                        $additionalImages[$i]['image_url'],
                        $additionalImages[$i]['alt']
                    );
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouseltourIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouseltourIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="to-details">
            <div class="to-header">
                <h2 class="to-title"><?php echo sprintf("%s", $tour['name']); ?></h2>
                <p>Tour ID: <?php echo sprintf("%s", $tour['id']); ?></p>
            </div>
            <div class="to-description">
                <p><?php echo sprintf("%s", $tour['description']); ?></p>
                <p><strong>Inclusions:</strong> <?php echo sprintf("%s", $tour['inclusions']); ?></p>
            </div>
            <div class="to-features">
                <div class="to-start-city">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-europe-africa" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M3.668 2.501l-.288.646a.847.847 0 0 0 1.479.815l.245-.368a.81.81 0 0 1 1.034-.275.81.81 0 0 0 .724 0l.261-.13a1 1 0 0 1 .775-.05l.984.34q.118.04.243.054c.784.093.855.377.694.801-.155.41-.616.617-1.035.487l-.01-.003C8.274 4.663 7.748 4.5 6 4.5 4.8 4.5 3.5 5.62 3.5 7c0 1.96.826 2.166 1.696 2.382.46.115.935.233 1.304.618.449.467.393 1.181.339 1.877C6.755 12.96 6.674 14 8.5 14c1.75 0 3-3.5 3-4.5 0-.262.208-.468.444-.7.396-.392.87-.86.556-1.8-.097-.291-.396-.568-.641-.756-.174-.133-.207-.396-.052-.551a.33.33 0 0 1 .42-.042l1.085.724c.11.072.255.058.348-.035.15-.15.415-.083.489.117.16.43.445 1.05.849 1.357L15 8A7 7 0 1 1 3.668 2.501" />
                        </svg>
                        Start City
                    </a>
                    <p><?php echo sprintf("%s", ucfirst($tour['start_city'])); ?></p>
                </div>
                <div class="to-end-city">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-europe-africa" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M3.668 2.501l-.288.646a.847.847 0 0 0 1.479.815l.245-.368a.81.81 0 0 1 1.034-.275.81.81 0 0 0 .724 0l.261-.13a1 1 0 0 1 .775-.05l.984.34q.118.04.243.054c.784.093.855.377.694.801-.155.41-.616.617-1.035.487l-.01-.003C8.274 4.663 7.748 4.5 6 4.5 4.8 4.5 3.5 5.62 3.5 7c0 1.96.826 2.166 1.696 2.382.46.115.935.233 1.304.618.449.467.393 1.181.339 1.877C6.755 12.96 6.674 14 8.5 14c1.75 0 3-3.5 3-4.5 0-.262.208-.468.444-.7.396-.392.87-.86.556-1.8-.097-.291-.396-.568-.641-.756-.174-.133-.207-.396-.052-.551a.33.33 0 0 1 .42-.042l1.085.724c.11.072.255.058.348-.035.15-.15.415-.083.489.117.16.43.445 1.05.849 1.357L15 8A7 7 0 1 1 3.668 2.501" />
                        </svg>
                        End City
                    </a>
                    <p><?php echo sprintf("%s", ucfirst($tour['end_city'])); ?></p>
                </div>
                <div class="to-duration">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                        </svg>
                        Duration
                    </a>
                    <p><?php echo sprintf("%s Day%s", $tour['duration'], $tour['duration'] > 1 ? 's' : ''); ?></p>
                </div>
                <div class="to-price">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank2" viewBox="0 0 16 16">
                            <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                        </svg>
                        Base Price
                    </a>
                    <p>$<?php echo sprintf("%.2f", $tour['base_price']); ?></p>
                </div>
                <div class="to-category">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                            <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                            <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z" />
                        </svg>
                        Category
                    </a>
                    <p><?php echo sprintf("%s", ucfirst($tour['category'])); ?></p>
                </div>
                <div class="to-activity">
                    <a class="icon-link icon-link-hover" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-walking" viewBox="0 0 16 16">
                            <path d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                            <path d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                        </svg>
                        Activity Level
                    </a>
                    <p><?php echo sprintf("%s", ucfirst($tour['activity_level'])); ?></p>
                </div>
            </div>
            <form action="booking.php" method="get">
                <button class="btn btn-primary" type="submit" name="tourid" value=<?php echo sprintf("'%s'", $tour['id']); ?>>Book Now</button>
            </form>
        </div>
    </div>
    <div class="itinerary">
        <div>
            <h2>Day 1</h2>
            <p>
                Your Northern Italy adventure begins in Milan, the cosmopolitan capital of fashion and design. Upon arrival, you'll be welcomed with a guided orientation walk through the city’s historic center, including the iconic Duomo di Milano and the elegant Galleria Vittorio Emanuele II. The evening concludes with a group welcome dinner featuring Lombard specialties like risotto alla Milanese.
            </p>
        </div>
        <div>
            <h2>Day 2</h2>
            <p>
                After breakfast, we head to Lake Como, renowned for its stunning scenery and charming villages. Enjoy a boat ride on the lake, visiting Bellagio and Varenna. In the afternoon, explore the gardens of Villa Carlotta before returning to Milan for an evening at leisure.
            </p>
        </div>
        <div>
            <h2>Day 3</h2>
            <p>
                Departing Milan, we travel to the picturesque town of Verona, famous for its Shakespearean connections. Visit Juliet's House and the ancient Roman amphitheater. After lunch, continue to Venice, where you'll enjoy a gondola ride through the city's enchanting canals.
            </p>
        </div>
    </div>
    <!-- Footer -->
</body>

</html>