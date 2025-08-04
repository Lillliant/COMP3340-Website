<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>About Trekker Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Learn about Trekker Tours, our mission, values, and commitment to immersive adventure travel. Discover how we connect travelers with local cultures and unique experiences.">
    <meta name="keywords" content="about trekker tours, adventure travel, small group tours, cultural immersion, sustainable travel, local communities, travel company, mission, values">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>About Us</h1>
    <!-- Display errors and success messages, if any -->
    <?php include '../../assets/components/alert.php'; ?>

    <div class="my-2 mx-5 p-2">
        <p style="text-align: justify;">
            Trekker Tour is an adventure travel company built for explorers, not tourists.

            We specialize in small group tours designed for those who crave meaningful experiences—whether it’s hiking remote mountain trails, navigating jungle paths, or discovering hidden villages. Our trips are crafted to take you off the beaten path and deep into the heart of each destination.

            At the core of every Trekker Tour experience is cultural immersion. We partner with local communities, stay in locally-owned lodges, and share meals with families—so you're not just passing through, you're connecting. Our guides are locals and seasoned adventurers who know every trail, story, and secret worth uncovering.

            With Trekker Tour, you’ll find more than a vacation. You’ll find purposeful adventure, lasting friendships, and a new perspective on the world. Contact us today to start your journey into the extraordinary!
        </p>

        <!-- A video showcasing the company's mission and values -->
        <h2 class="my-2">Watch Our Story</h2>
        <div class="ratio ratio-16x9 container-sm">
            <iframe src="https://www.youtube.com/embed/LgtU1h0ck58?si=7dVKkUT4uqExXEaU" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <h2 class="my-2">Our Mission</h2>
        <p style="text-align: justify;">
            At Trekker Tour, our mission is to lead immersive, small-group adventures that connect curious travelers with the world’s most inspiring landscapes and cultures.
            We believe in slow, meaningful travel—trekking beyond the tourist trail to engage deeply with local communities, traditions, and natural wonders. By keeping our groups small and our values rooted in sustainability, we ensure that every journey respects the places we visit and the people who call them home.
        </p>
    </div>
</body>

</html>