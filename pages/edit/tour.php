<?php
session_start();

// Establish database connection
require_once('../../assets/php/db.php');

// If the user is not logged in, or is not an admin, redirect to home page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: /3340/index.php');
    exit;
}

// Fetch the specific tour detail using the tour ID from the URL
// First validate the tour ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /3340/404.php");
    exit;
}

// Prepare and execute the query to fetch the tour details
$stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $tour = $result->fetch_assoc();
} else {
    header("Location: /3340/404.php");
    exit;
}

// Obtain the associated option details for the tour
$stmt = $conn->prepare("SELECT * FROM options WHERE tour_id = ?");
$stmt->bind_param("i", $tour['id']);
$stmt->execute();
$optionsResult = $stmt->get_result();
$options = [];
while ($option = $optionsResult->fetch_assoc()) {
    $options[] = $option;
}

// Obtain the associated images for the tour
$stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ?");
$stmt->bind_param("i", $tour['id']);
$stmt->execute();
$imagesResult = $stmt->get_result();
$images = [];
while ($image = $imagesResult->fetch_assoc()) {
    $images[] = $image;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Tour</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Edit Tour</h1>
    <p>
        Use the form below to edit the tour details. Empty fields will not be updated, so ensure to fill in all necessary fields.
    </p>
    <!-- Display any success or error messages -->
    <?php include '../../assets/components/alert.php'; ?>

    <div id="tour-container" class="center-form">
        <h2>Edit Tour Details</h2>
        <?php echo $tour['is_active'] ? '<p>This tour is currently active.</p>' : '<p>This tour is currently inactive.</p>' ?>
        <!-- This form only modifies the tour details in the tours database table. -->
        <form action="tour_validate.php" method="post">
            <!-- Hidden field to store the tour ID, which cannot be modified. -->
            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
            <label for="name">Tour Name:</label>
            <input type="text" name="name" id="name" placeholder="Tour Name" value="<?php echo htmlspecialchars($tour['name']); ?>">
            <label for="description">Tour Description:</label>
            <textarea name="description" id="description" placeholder="Tour Description"><?php echo htmlspecialchars($tour['description']); ?></textarea>
            <label for="long_description">Itinerary Details:</label>
            <textarea name="long_description" id="long_description" placeholder="Itinerary Details"><?php echo htmlspecialchars($tour['long_description']); ?></textarea>
            <label for="inclusions">Inclusions:</label>
            <textarea name="inclusions" id="inclusions" placeholder="Inclusions"><?php echo htmlspecialchars($tour['inclusions']); ?></textarea>
            <label for="destination">Destination:</label>
            <input type="text" name="destination" id="destination" placeholder="Destination" value="<?php echo htmlspecialchars($tour['destination']); ?>">
            <label for="start_city">Start City:</label>
            <input type="text" name="start_city" id="start_city" placeholder="Start City" value="<?php echo htmlspecialchars($tour['start_city']); ?>">
            <label for="end_city">End City:</label>
            <input type="text" name="end_city" id="end_city" placeholder="End City" value="<?php echo htmlspecialchars($tour['end_city']); ?>">
            <label for="category">Category:</label>
            <input type="text" name="category" id="category" placeholder="Category" value="<?php echo htmlspecialchars($tour['category']); ?>">
            <label for="activity_level">Activity Level:</label>
            <input type="text" name="activity_level" id="activity_level" placeholder="Activity Level" value="<?php echo htmlspecialchars($tour['activity_level']); ?>">
            <label for="duration">Duration (days):</label>
            <input type="number" name="duration" id="duration" placeholder="Duration (days)" min="1" value="<?php echo htmlspecialchars($tour['duration']); ?>">
            <label for="start_day">Start Day:</label>
            <select name="start_day" id="start_day">
                <option value="0" <?php if ($tour['start_day'] == 0) echo 'selected'; ?>>Sunday</option>
                <option value="1" <?php if ($tour['start_day'] == 1) echo 'selected'; ?>>Monday</option>
                <option value="2" <?php if ($tour['start_day'] == 2) echo 'selected'; ?>>Tuesday</option>
                <option value="3" <?php if ($tour['start_day'] == 3) echo 'selected'; ?>>Wednesday</option>
                <option value="4" <?php if ($tour['start_day'] == 4) echo 'selected'; ?>>Thursday</option>
                <option value="5" <?php if ($tour['start_day'] == 5) echo 'selected'; ?>>Friday</option>
                <option value="6" <?php if ($tour['start_day'] == 6) echo 'selected'; ?>>Saturday</option>
            </select>
            <input type="submit" value="Edit">
        </form>
    </div>
    <div id="options-container" class="center-form">
        <h2>Edit Tour Options</h2>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#add-option" aria-expanded="false" aria-controls="add-option">
            Add New Option
        </button>
        <div class="collapse" id="add-option">
            <p>Add new options for this tour. Options can be added with a name, description, and price.</p>
            <form action="../add/option.php" method="post">
                <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                <label for="name">Name:</label>
                <input type="text" name="name" id="add_option_name" placeholder="Option Name" required>
                <label for="description">Description:</label>
                <textarea name="description" id="add_option_description" placeholder="Option Description"></textarea>
                <label for="price">Price:</label>
                <input type="number" name="price" id="add_option_price" placeholder="Option Price" min="0" required>
                <input type="submit" value="Add Option">
            </form>
        </div>

        <?php if (count($options) > 0): ?>
            <h3>Existing Options</h3>
            <ul>
                <?php foreach ($options as $option): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($option['name']); ?></strong> - <?php echo htmlspecialchars($option['description']); ?> ($<?php echo htmlspecialchars($option['price']); ?>)
                        <form action="../edit/option.php" method="get" onsubmit="return confirm('Are you sure you want to edit this option? Changes will only apply to future bookings.');">
                            <input type="hidden" name="option_id" value="<?php echo htmlspecialchars($option['id']); ?>">
                            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Edit">
                        </form>
                        <form action="../delete/option.php" method="post" onsubmit="return confirm('Are you sure you want to delete this option? All associated bookings will be cancelled.');">
                            <input type="hidden" name="option_id" value="<?php echo htmlspecialchars($option['id']); ?>">
                            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No options available for this tour.</p>
        <?php endif; ?>
    </div>
    <div id="image-container" class="center-form">
        <h2>Edit Tour Images</h2>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#add-image" aria-expanded="false" aria-controls="add-image">
            Add New Images
        </button>
        <div class="collapse" id="add-image">
            <p>Add new images for this tour. Images can be added with a URL and alt text.</p>
            <form action="../add/image.php" method="post">
                <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                <label for="image_url">Name:</label>
                <input type="text" name="image_url" id="add_image_url" placeholder="Image URL" required>
                <label for="image_alt">Description:</label>
                <input type="text" name="image_alt" id="add_image_alt" placeholder="Image alt text" required></textarea>
                <input type="submit" value="Add Image">
            </form>
        </div>

        <?php if (count($images) > 0): ?>
            <h3>Existing Images</h3>
            <ul>
                <?php foreach ($images as $image): ?>
                    <li>
                        <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>" style="max-width: 200px; max-height: 200px;">
                        <?php if ($image['is_featured']): ?>
                            <p><strong>Featured Image</strong></p>
                        <?php else: ?>
                            <form action="../edit/image.php" method="post" onsubmit="return confirm('Are you sure you want to make this image <?php echo $image['is_featured'] ? 'un-' : '' ?>featured?');">
                                <input type="hidden" name="image_id" value="<?php echo htmlspecialchars($image['id']); ?>">
                                <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <input type="submit" value="Make featured">
                            </form>
                        <?php endif; ?>
                        <form action="../delete/image.php" method="post" onsubmit="return confirm('Are you sure you want to delete this image?');">
                            <input type="hidden" name="image_id" value="<?php echo htmlspecialchars($image['id']); ?>">
                            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No images available for this tour.</p>
        <?php endif; ?>
    </div>
    <!-- Edit Option page --><!-- Edit Image page -->

    <!-- Footer -->
</body>

</html>