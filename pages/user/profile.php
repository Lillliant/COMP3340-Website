<?php
// Start the session
session_start();
require_once('../../assets/php/db.php');

// Fetch profile data from the database
if (isset($_SESSION['account_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['account_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else { // If no user is found, redirect to 404 page
        header("Location: /3340/404.php");
        exit;
    }
} else { // If the user is not logged in, redirect to the login page
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: /3340/pages/login/login.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Profile</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="View and edit your Trekker Tours user profile. See your account details and update your information.">
    <meta name="keywords" content="user profile, trekker tours, account details, edit profile, user information">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>User Profile</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <p class="lead">
        Welcome to your profile page, <?php echo htmlspecialchars($user['username']); ?>! Here you can view and edit your account details.
    </p>
    <!-- Go back to the user dashboard -->
    <a href="/3340/pages/user/home.php" class="back-button">Back to Dashboard</a>
    <!-- Profile details display -->
    <div class="profile-container">
        <div class="details-card rounded">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?><br>
                <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
                <strong>First name:</strong> <?php echo htmlspecialchars($user['first_name']); ?><br>
                <strong>Last name:</strong> <?php echo htmlspecialchars($user['last_name']); ?><br>
                <strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?><br>
                <strong>Account Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?>
            </p>
            <button onclick="window.location.href='/3340/pages/edit/profile.php'">Edit Profile</button>
        </div>
    </div>
</body>

</html>