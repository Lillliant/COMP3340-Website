<?php
// We need to use sessions, so you should always initialize sessions using the below function
session_start();
// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once('../../assets/php/db.php');
// Obtain user bookings from the database
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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

    <h2>Manage Users</h2>
    <?php include '../../assets/components/alert.php'; ?>
    <div class="booking-list">
        <?php if (count($users) > 0): ?>
            <?php foreach ($users as $user): ?>
                <div class="booking-grid">
                    <div class="booking-card">
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['first_name'] . $user['last_name']); ?></p>
                        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Registered on:</strong> <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></p>
                    </div>
                    <div class="edit-container">
                        <!-- Make Admin/User and Delete buttons -->
                        <form method="post" action="../edit/role.php">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <?php if ($user['role'] === 'admin'): ?>
                                <input type="submit" value="Make User">
                            <?php else: ?>
                                <input type="submit" value="Make Admin">
                            <?php endif; ?>
                        </form>
                        <form method="post" action="../delete/user.php">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input type="submit" value="Delete User" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You have no users.</p>
        <?php endif; ?>
    </div>
    <!-- Footer -->
</body>

</html>