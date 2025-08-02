<?php
session_start(); // Initialize session
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trekker Tours</title>
  <!-- Import layout -->
  <!-- For static pages, the components can be included directly -->
  <?php include 'assets/components/layout.php'; ?>
  <script src="assets/js/toggleTheme.js" defer></script>
</head>

<body>
  <!-- Header -->
  <?php include 'assets/components/header.php'; ?>

  <!-- Main Content -->
  <h1>Welcome to Trekker Tours<?php
                              if ($_SESSION['loggedin']) {
                                echo ', ' . $_SESSION['account_name'];
                              }
                              ?>
  </h1>

  <!-- Display errors and success messages -->
  <?php include 'assets/components/alert.php'; ?>

  <p>
    Your one-stop destination for exploring the world's most beautiful places.
    Explore our wide range of tours and book your next adventure with us!
  </p>

  <h2>Featured Tours</h2>
  <div id="featuredToursCarousel" class="carousel slide" data-bs-ride="carousel">
    <?php
    // Fetch 5 tours from the database
    require_once('assets/php/db.php');
    $stmt = $conn->prepare("SELECT id, name, description FROM tours LIMIT 5");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $tours = $result->fetch_all(MYSQLI_ASSOC);
    } else {
      $tours = [];
    }

    for ($i = 0; $i < count($tours); $i++) {
      // Display each tour's image as a link
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

      echo sprintf(
        '<div class="carousel-item %s">
          <a href="/3340/pages/tour/tour.php?tourid=%s">
            <img src="%s" class="d-block w-100" alt="%s" onerror="this.src=\'/3340/assets/img/404.jpg\'">
          </a>
          <div class="carousel-caption d-none d-md-block">
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

  <!-- Footer -->
</body>

</html>