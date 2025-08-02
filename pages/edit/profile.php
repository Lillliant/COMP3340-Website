<?php
session_start();

require_once('../../assets/php/db.php');

// If the user is already logged in, redirect to home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

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

    <h2>Edit Profile</h2>
    <div class="center-form">
        <form action="profile_validate.php" method="post">
            <input type="text" name="username" id="username" placeholder=<?php echo htmlspecialchars($user['username']); ?>>
            <input type="text" name="first_name" id="firstname" placeholder=<?php echo htmlspecialchars($user['first_name']); ?>>
            <input type="text" name="last_name" id="lastname" placeholder=<?php echo htmlspecialchars($user['last_name']); ?>>
            <input type="email" name="email" id="email" placeholder=<?php echo htmlspecialchars($user['email']); ?>>
            <input type="submit" value="Edit">
        </form>
    </div>

    <!-- Footer -->
</body>

</html>