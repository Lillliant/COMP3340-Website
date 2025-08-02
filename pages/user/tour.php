<?php
// We need to use sessions, so you should always initialize sessions using the below function
session_start();
// If the user is not logged in, or is not an admin, redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Include database connection
require_once('../../assets/php/db.php');

// Obtain tour information from the database
$stmt = $conn->prepare("SELECT * FROM tours");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $tours = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $tours = [];
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
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>

    <h2>Tours</h2>
    <button onclick="location.href='../add/tour.php'">Add Tour</button>
    <div class="booking-list">
        <?php if (count($tours) > 0): ?>
            <?php foreach ($tours as $tour): ?>
                <div class="booking-grid">
                    <div class="booking-card">
                        <p><strong>Status:</strong> <?php
                                                    echo htmlspecialchars($tour['is_active'] ? 'Active' : 'Inactive');
                                                    ?>
                        </p>
                        <p><strong>Tour ID:</strong> <?php echo htmlspecialchars($tour['id']); ?></p>
                        <p><strong>Tour Name:</strong> <?php echo htmlspecialchars($tour['name']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($tour['description']); ?></p>
                        <p><strong>Inclusions:</strong> <?php echo htmlspecialchars($tour['inclusions']); ?></p>
                        <p><strong>Destination:</strong> <?php echo htmlspecialchars($tour['destination']); ?></p>
                        <p><strong>Start City:</strong> <?php echo htmlspecialchars($tour['start_city']); ?></p>
                        <p><strong>End City:</strong> <?php echo htmlspecialchars($tour['end_city']); ?></p>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars(ucfirst($tour['category'])); ?></p>
                        <p><strong>Activity Level:</strong> <?php echo htmlspecialchars(ucfirst($tour['activity_level'])); ?></p>
                        <p><strong>Duration:</strong> <?php
                                                        echo htmlspecialchars($tour['duration'] . ' ' .
                                                            ($tour['duration'] > 1 ? 'Days' : 'Day'));
                                                        ?>
                        </p>
                        <p><strong>Start Day:</strong>
                            <?php
                            $days = [
                                0 => 'Sunday',
                                1 => 'Monday',
                                2 => 'Tuesday',
                                3 => 'Wednesday',
                                4 => 'Thursday',
                                5 => 'Friday',
                                6 => 'Saturday'
                            ];
                            echo isset($days[$tour['start_day']]) ? $days[$tour['start_day']] : 'Unknown';
                            ?>
                        </p>
                    </div>
                    <div class="edit-container">
                        <form action="../edit/tour.php" method="get">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Edit Tour">
                        </form>
                        <!-- Delete/Disable Tour -->
                        <!-- Ensure the tour can only be deleted if there are no bookings associated -->
                        <!-- Also allows disabled tours to be re-enabled -->
                        <?php if (!$tour['is_active']): ?>
                            <form action="../add/enable_tour.php" method="post" onsubmit="return confirm('Are you sure you want to enable this tour? Existing bookings will not be modified.');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <input type="submit" value="Enable Tour">
                            </form>
                        <?php else: ?>
                            <form action="../delete/tour.php" method="post" onsubmit="return confirm('Are you sure you want to delete this tour? All associated bookings will be cancelled, and the tour will be disabled. The tour will only be deleted when there are no bookings associated. ');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <input type="submit" value="Delete Tour">
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>There are no tours.</p>
        <?php endif; ?>
    </div>
    <!-- Footer -->
</body>

</html>