<?php
session_start(); // Start the session to access session variables
// If the user is not logged in, or is not an admin, redirect to the index page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Include database connection
require_once('../../assets/php/db.php');

// Obtain all tour information from the database
$stmt = $conn->prepare("SELECT * FROM tours");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $tours = $result->fetch_all(MYSQLI_ASSOC);
} else { // No tours found, initialize an empty array
    $tours = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Manage Tours</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Tour Management dashboard for Trekker Tours. Manage all tours and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, tours, admin, manage tours">
    <!-- Import layout and necessary dynamic theme change function -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Manage Tours</h1>
    <!-- Display errors and success messages -->
    <?php include '../../assets/components/alert.php'; ?>
    <!-- Go back to the user dashboard -->
    <a href="/3340/pages/user/home.php" class="back-button">Back to Dashboard</a>

    <!-- Button to add a new tour -->
    <div class="button-container">
        <button onclick="location.href='../add/tour.php'">Add Tour</button>
    </div>

    <!-- Container for all tours -->
    <div class="item-list">
        <!-- Display a card for each tour -->
        <?php if (count($tours) > 0): ?>
            <?php foreach ($tours as $tour): ?>
                <!-- Display tour details dynamically -->
                <div class="item-grid">
                    <div class="details-card no-bg">
                        <p><strong>Tour ID:</strong> <?php echo htmlspecialchars($tour['id']); ?></p>
                        <p><strong>Status:</strong> <?php
                                                    echo htmlspecialchars($tour['is_active'] ? 'Active' : 'Inactive');
                                                    ?>
                        </p>
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
                        <!-- Start Day represents the day of the week the tour starts -->
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
                    <!-- Display the possible actions for each tour -->
                    <div class="actions-container">
                        <form action="../edit/tour.php" method="get" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Edit Tour">
                        </form>
                        <!-- Enable or disable the tour based on its current status -->
                        <!-- When a tour is disabled, all associated bookings are cancelled -->
                        <?php if (!$tour['is_active']): ?>
                            <form action="../edit/enable_tour.php" method="post" onsubmit="return confirm('Are you sure you want to enable this tour? Existing bookings will not be modified.');" class="no-bg">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <input type="submit" value="Enable Tour">
                            </form>
                        <?php else: ?>
                            <form action="../edit/disable_tour.php" method="post" onsubmit="return confirm('Are you sure you want to enable this tour? All associated bookings will be cancelled.');" class="no-bg">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <input type="submit" value="Disable Tour">
                            </form>
                        <?php endif; ?>
                        <!-- Delete the tour, which also deletes all associated bookings, options, and images -->
                        <form action="../delete/tour.php" method="post" onsubmit="return confirm('Are you sure you want to delete this tour? All associated bookings, options, and images will be deleted.');" class="no-bg">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Delete Tour">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <!-- If no tours are found, display a message -->
            <p>There are no tours.</p>
        <?php endif; ?>
    </div>
</body>

</html>