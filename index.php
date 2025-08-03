<?php
session_start(); // Initialize session
?>

<!doctype html>
<html lang="en">

<head>
  <title>Trekker Tours</title>
  <!-- Common site-wide SEO metadata for Trekker Tours -->
  <?php include 'assets/components/seo.php'; ?>
  <meta name="description" content="Trekker Tours - Your one-stop destination for exploring the world's most beautiful places. Discover and book your next adventure with us!">
  <meta name="keywords" content="tours, travel, adventure, trekking, holidays, destinations, booking">
  <!-- Import layout and necessary dynamic theme change function -->
  <?php include 'assets/components/layout.php'; ?>
  <script src="assets/js/toggleTheme.js" defer></script>
</head>

<body>
  <!-- Header -->
  <?php include 'assets/components/header.php'; ?>

  <!-- Main Content -->
  <h1>Welcome to Trekker Tours<?php
                              if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                // If the user is logged in, display their username
                                echo ', ' . htmlspecialchars($_SESSION['account_name']);
                                echo ', ' . $_SESSION['account_name'];
                              }
                              ?>
  </h1>
  <!-- Display errors and success messages, if any -->
  <?php include 'assets/components/alert.php'; ?>
  <p class="lead">
    Your one-stop destination for exploring the world's most beautiful places.
    Explore our wide range of tours and book your next adventure with us!
  </p>
  <div id="featuredToursCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php
      // Fetch 5 tours from the database
      require_once('assets/php/db.php');
      $stmt = $conn->prepare("SELECT id, name, description FROM tours LIMIT 5");
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $tours = $result->fetch_all(MYSQLI_ASSOC);
      } else { // If no tours are found, initialize an empty array
        $tours = [];
      }

      // For each tour, create a carousel item
      for ($i = 0; $i < count($tours); $i++) {
        // Display each tour's featured image as a clickable link to their tour page
        $stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ? AND is_featured = 1 LIMIT 1");
        $stmt->bind_param("i", $tours[$i]['id']);
        $stmt->execute();
        $featuredImageResult = $stmt->get_result();
        if ($featuredImageResult->num_rows > 0) {
          $featuredImage = $featuredImageResult->fetch_assoc();
        } else {
          $featuredImage = null; // No featured image found
        }
        $activeClass = ($i === 0) ? 'active' : '';

        // Create the carousel item with the tour's image and details
        // The captions is the tour's name and description
        echo sprintf(
          '<div class="carousel-item %s">
          <a href="/3340/pages/tour/tour.php?tourid=%s">
            <img src="%s" class="d-block w-100" alt="%s" onerror="this.src=\'/3340/assets/img/404.jpg\'">
          </a>
          <div class="carousel-caption d-block d-md-block">
            <h5>%s</h5>
            <p>%s</p>
          </div>
        </div>',
          $activeClass,
          htmlspecialchars($tours[$i]['id']),
          $featuredImage ? htmlspecialchars($featuredImage['image_url']) : '/3340/assets/img/404.jpg',
          $featuredImage ? htmlspecialchars($featuredImage['alt']) : 'No image available',
          htmlspecialchars($tours[$i]['name']),
          htmlspecialchars($tours[$i]['description'])
        );
      }
      ?>
    </div>
    <!-- Carousel controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredToursCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredToursCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Footer -->
</body>

</html>