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
    } else {
        header("Location: /3340/404.php");
        exit;
    }
} else {
    header("Location: /3340/pages/login/login.php");
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
    <h1>User Profile</h1>
    <div>
        <h2>Edit Profile</h2>
        <?php
        // Display error message if there is one
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // Clear the error message after displaying it
        } else if (isset($_SESSION['success'])) {
            echo '<p class="success">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']); // Clear the success message after displaying it
        }
        ?>
    </div>
    <div>
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>First name: <?php echo htmlspecialchars($user['first_name']); ?></p>
        <p>Last name: <?php echo htmlspecialchars($user['last_name']); ?></p>
        <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
        <p>Account Created: <?php echo htmlspecialchars($user['created_at']); ?></p>
        <button onclick="window.location.href='/3340/pages/edit/profile.php'">Edit Profile</button>
    </div>
    <!-- Footer -->
</body>

</html>