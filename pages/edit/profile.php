<?php
session_start(); // Start the session to manage user authentications

require_once('../../assets/php/db.php'); // Include database connection

// If the user is not logged in, redirect to the index page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

// Fetch user details from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['account_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else { // If no user is found, redirect to a 404 page
    header("Location: /3340/404.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="User dashboard for Trekker Tours. Manage your bookings, profile, and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, bookings, profile, admin, manage tours, manage users, website monitor">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Edit Profile</h1>
    <!-- Display error message if there is one -->
    <?php include '../../assets/components/alert.php'; ?>
    <p class="lead">
        You can edit your profile details below. Please ensure all fields are filled out correctly. Any fields left blank will retain their current values.
    </p>
    <a href="/3340/pages/user/profile.php" class="back-button">Go Back to Profile</a>
    <!-- Form to edit user profile -->
    <div class="center-form">
        <form action="profile_validate.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder=<?php echo htmlspecialchars($user['username']); ?>>
            <label for="firstname">First Name:</label>
            <input type="text" name="first_name" id="firstname" placeholder=<?php echo htmlspecialchars($user['first_name']); ?>>
            <label for="lastname">Last Name:</label>
            <input type="text" name="last_name" id="lastname" placeholder=<?php echo htmlspecialchars($user['last_name']); ?>>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder=<?php echo htmlspecialchars($user['email']); ?>>
            <input type="submit" value="Edit">
        </form>
    </div>
</body>

</html>