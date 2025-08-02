<?php
session_start();

require_once('../../assets/php/db.php');

// If the user is already logged in, redirect to home page
if (!isset($_SESSION['loggedin'])) {
    header('Location: /3340/index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
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
            <input type="text" name="user_id" id="user_id" placeholder=<?php echo htmlspecialchars($booking['user_id']); ?>>
            <input type="text" name="tour_id" id="tour_id" placeholder=<?php echo htmlspecialchars($booking['tour_id']); ?>>
            <input type="text" id="datepicker" name="departure_date" placeholder=<?php echo htmlspecialchars($booking['departure_date']); ?>>
            <input type="number" name="total_price" id="total_price" placeholder=<?php echo htmlspecialchars($booking['total_price']); ?>>
            <input type="number" name="person_count" id="person_count" min="1" max="30" value=<?php echo htmlspecialchars($booking['person_count']); ?>>
            <input type="submit" value="Edit">
        </form>
    </div>

    <!-- Footer -->
</body>

</html>