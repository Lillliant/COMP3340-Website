<?php
session_start(); // Start the session to access session variables
?>

<!doctype html>
<html lang="en">

<head>
    <title>Page Not Found - Trekker Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include 'assets/components/seo.php'; ?>
    <meta name="description" content="404 page for Trekker Tours. The page you are looking for does not exist.">
    <meta name="keywords" content="404, page not found, trekker tours, error, missing page">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include 'assets/components/layout.php'; ?>
    <script src="assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>
    <!-- Alert component for displaying messages -->
    <h2>404 - Page Not Found</h2>
    <?php include 'assets/components/alert.php'; ?>
    <p>Oh no, the page you are looking for does not exist!</p>
</body>

</html>