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
    <h1>All Tours</h1>
    <!-- Tour Search Form -->
    <form action="pages/tour/search.php" method="GET">
        <input type="text" name="query" placeholder="Search for tours..." required>
        <input type="submit" value="Search">
    </form>
    <!-- Display all tours -->
    <div class="tour-list">
        <?php
        require_once('assets/php/db.php');
        $stmt = $conn->prepare("SELECT * FROM tours");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($tour = $result->fetch_assoc()) {
                echo '<div class="tour-item">';
                echo '<h2>' . htmlspecialchars($tour['name']) . '</h2>';
                echo '<p>' . htmlspecialchars($tour['description']) . '</p>';
                echo '<p>Price: $' . htmlspecialchars($tour['price']) . '</p>';
                echo '<a href="pages/tour/booking.php?tourid=' . htmlspecialchars($tour['id']) . '">Book Now</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No tours available at the moment.</p>';
        }
        ?>
    </div>

    <!-- Footer -->
</body>

</html>