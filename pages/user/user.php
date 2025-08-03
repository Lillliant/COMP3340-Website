<?php
session_start(); // Start the session to access session variables
// If the user is not logged in, redirect to the home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

require_once('../../assets/php/db.php'); // Include database connection
// Obtain user bookings from the database
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else { // No users found, initialize an empty array
    $users = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Manage Users</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="User Management dashboard for Trekker Tours. Manage user settings and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, admin, manage users">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Manage Users</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Go back to the user dashboard -->
    <a href="/3340/pages/user/home.php" class="back-button">Back to Dashboard</a>

    <!-- COntainer for list of users -->
    <div class="item-list">
        <!-- Display a card for each user -->
        <?php if (count($users) > 0): ?>
            <?php foreach ($users as $user): ?>
                <div class="item-grid">
                    <!-- Display user details for each user dynamically -->
                    <div class="details-card no-bg">
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['first_name'] . $user['last_name']); ?></p>
                        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Registered on:</strong> <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></p>
                    </div>
                    <!-- Display available actions for each user -->
                    <div class="actions-container">
                        <!-- Make Admin/User and Delete buttons -->
                        <!-- Only show the respective button based on the user's role -->
                        <form method="post" action="../edit/role.php" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <?php if ($user['role'] === 'admin'): ?>
                                <input type="submit" value="Make User">
                            <?php else: ?>
                                <input type="submit" value="Make Admin">
                            <?php endif; ?>
                        </form>
                        <form method="post" action="../delete/user.php" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be reversed.');" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input type="submit" value="Delete User">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- If no users are found, display a message -->
            <p>You have no users.</p>
        <?php endif; ?>
    </div>
</body>

</html>