<?php
session_start(); // Start the session to access session variables

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
} else { // If no tour is found, redirect to 404 page
    header("Location: /3340/404.php");
    exit;
}

// Obtain the associated option details for the tour
$stmt = $conn->prepare("SELECT * FROM options WHERE tour_id = ?");
$stmt->bind_param("i", $tour['id']);
$stmt->execute();
$optionsResult = $stmt->get_result();
$options = [];
while ($option = $optionsResult->fetch_assoc()) { // There can be multiple options for a tour
    $options[] = $option;
}

// Obtain the associated images for the tour
$stmt = $conn->prepare("SELECT * FROM images WHERE tour_id = ?");
$stmt->bind_param("i", $tour['id']);
$stmt->execute();
$imagesResult = $stmt->get_result();
$images = [];
while ($image = $imagesResult->fetch_assoc()) { // There can be multiple images for a tour
    $images[] = $image;
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Edit Tour</title>
    <!-- Common site-wide SEO metadata for Trekker Tours -->
    <?php include '../../assets/components/seo.php'; ?>
    <meta name="description" content="Edit tours for Trekker Tours. Manage all tours and access admin features if authorized.">
    <meta name="keywords" content="user dashboard, trekker tours, tours, admin, manage tours">
    <!-- Import layout and necessary dynamic theme change function -->
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
    <!-- Back to Tours link -->
    <a href="/3340/pages/user/tour.php" class="back-button">Back to Tours</a>

    <!-- Organize the page into sections for better readability -->
    <div class="item-grid">
        <!-- Display the tour details in a form for editing -->
        <!-- This form only modifies the tour details in the tours database table. -->
        <div class="item-left">
            <h2>Edit Tour Details</h2>
            <?php echo $tour['is_active'] ? '<p>This tour is currently active.</p>' : '<p>This tour is currently inactive.</p>' ?>
            <form action="tour_validate.php" method="post" class="center-form">
                <!-- Hidden field to store the tour ID, which cannot be modified. -->
                <!-- For other fields, the old values are pre-filled for editing -->
                <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                <label for="tour_name">Tour Name:</label>
                <input type="text" name="name" id="tour_name" maxlength="50" placeholder="Tour Name" autocomplete="off" value="<?php echo htmlspecialchars($tour['name']); ?>">
                <label for="lead_description">Tour Description:</label>
                <textarea name="description" id="lead_description" maxlength="4000" autocomplete="off" placeholder="Tour Description"><?php echo htmlspecialchars($tour['description']); ?></textarea>
                <label for="long_description">Itinerary Details:</label>
                <textarea name="long_description" id="long_description" placeholder="Itinerary Details" maxlength="4000" autocomplete="off"><?php echo htmlspecialchars($tour['long_description']); ?></textarea>
                <label for="inclusions">Inclusions:</label>
                <textarea name="inclusions" id="inclusions" placeholder="Inclusions" maxlength="255" autocomplete="off"><?php echo htmlspecialchars($tour['inclusions']); ?></textarea>
                <label for="destination">Destination:</label>
                <input type="text" name="destination" id="destination" placeholder="Destination" autocomplete="off" value="<?php echo htmlspecialchars($tour['destination']); ?>">
                <label for="start_city">Start City:</label>
                <input type="text" name="start_city" id="start_city" placeholder="Start City" maxlength="100" autocomplete="off" value="<?php echo htmlspecialchars($tour['start_city']); ?>">
                <label for="end_city">End City:</label>
                <input type="text" name="end_city" id="end_city" placeholder="End City" maxlength="100" autocomplete="off" value="<?php echo htmlspecialchars($tour['end_city']); ?>">
                <!-- Category represents the type of tour -->
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="adventure" <?php if ($tour['category'] == 'adventure') echo 'selected' ?>>Adventure</option>
                    <option value="cultural" <?php if ($tour['category'] == 'cultural') echo 'selected' ?>>Cultural</option>
                    <option value="relaxation" <?php if ($tour['category'] == 'relaxation') echo 'selected' ?>>Relaxation</option>
                </select>
                <!-- Activity Level represents the physical intensity of the tour -->
                <label for="activity_level">Activity Level:</label>
                <select name="activity_level" id="activity_level" required>
                    <option value="relaxing" <?php if ($tour['activity_level'] == 'relaxing') echo 'selected' ?>>Relaxing</option>
                    <option value="balanced" <?php if ($tour['activity_level'] == 'balanced') echo 'selected' ?>>Balanced</option>
                    <option value="challenging" <?php if ($tour['activity_level'] == 'challenging') echo 'selected' ?>>Challenging</option>
                </select>
                <label for="duration">Duration (days):</label>
                <input type="number" name="duration" id="duration" placeholder="Duration (days)" min="1" value="<?php echo htmlspecialchars($tour['duration']); ?>">
                <!-- Start Day represents the day of the week the tour starts -->
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
        <!-- Display the tour options and images in separate sections -->
        <div class="item-right">
            <div id="options-container">
                <h2>Edit Tour Options</h2>
                <p>
                    Each tour can have multiple options, such as different activities or services.
                </p>
                <!-- Display existing options in a scrollable gallery format -->
                <div class="scrollable-gallery">
                    <?php
                    // Display existing options in a scrollable gallery format
                    // For each option, outputs a card with the option detail and possible actions for the option
                    if (count($options) > 0) {
                        foreach ($options as $option) {
                            echo '<div class="scrollable-card">';
                            echo sprintf(
                                '<div class="scrollable-left"><p><strong>%s ($%s)</strong></p><p>%s</p></div>
                                <div class="scrollable-right">
                                    <form action="../edit/option.php" method="get" onsubmit="return confirm(\'Are you sure you want to edit this option? Price changes will only apply to future bookings.\');" class="no-bg">
                                        <input type="hidden" name="option_id" value="%s">
                                        <input type="hidden" name="tour_id" value="%s">
                                        <input type="submit" value="Edit">
                                    </form>
                                    <form action="../delete/option.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this option? All associated bookings will be cancelled.\');" class="no-bg">
                                        <input type="hidden" name="option_id" value="%s">
                                        <input type="hidden" name="tour_id" value="%s">
                                        <input type="submit" value="Delete">
                                    </form>
                                </div>',
                                htmlspecialchars($option['name']),
                                htmlspecialchars($option['price']),
                                htmlspecialchars($option['description']),
                                htmlspecialchars($option['id']),
                                htmlspecialchars($tour['id']),
                                htmlspecialchars($option['id']),
                                htmlspecialchars($tour['id'])
                            );
                            echo '</div>';
                        }
                    } else {
                        // If no options are available, display a message
                        echo '<p>No options available for this tour.</p>';
                    }
                    ?>
                </div>
                <!-- Controls the collapsible section for adding new options -->
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#add-option" aria-expanded="false" aria-controls="add-option">
                    Add New Option
                </button>
                <!-- This collapsible section allows the admin to add new options for the tour -->
                <div class="collapse" id="add-option">
                    <p>Add new options for this tour. Options can be added with a name, description, and price.</p>
                    <form action="../add/option.php" method="post" class="center-form">
                        <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                        <label for="add_option_name">Name:</label>
                        <input type="text" name="name" id="add_option_name" placeholder="Option Name" required>
                        <label for="add_option_description">Description:</label>
                        <textarea name="description" id="add_option_description" placeholder="Option Description"></textarea>
                        <label for="add_option_price">Price:</label>
                        <input type="number" name="price" id="add_option_price" placeholder="Option Price" min="0" required>
                        <input type="submit" value="Add Option">
                    </form>
                </div>
            </div>
            <div id="images-container">
                <h2>Edit Tour Images</h2>
                <p>
                    Each tour can have multiple images to showcase its highlights.
                </p>
                <!-- Display existing images in a scrollable gallery format -->
                <div class="scrollable-gallery">
                    <?php
                    // For each image, outputs a card with the image and possible actions for the image
                    if (count($images) > 0) {
                        foreach ($images as $image) {
                            // Form template for making images featured
                            $featuredForm = sprintf(
                                '<form action="../edit/image.php" method="post" onsubmit="return confirm("Are you sure you want to make this image featured?" class="no-bg">
                            <input type="hidden" name="image_id" value="%s">
                            <input type="hidden" name="tour_id" value="%s">
                            <input type="submit" value="Feature Image">
                        </form>',
                                htmlspecialchars($image['id']),
                                htmlspecialchars($tour['id']),
                            );

                            // Start generating the HTML for each image
                            echo '<div class="scrollable-card">';
                            echo sprintf(
                                '<div class="scrollable-left">
                                    <img src="%s" alt="%s">
                                </div>
                                <div class="scrollable-right">
                                    %s
                                    <form action="../delete/image.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this image?\');" class="no-bg">
                                        <input type="hidden" name="image_id" value="%s">
                                        <input type="hidden" name="tour_id" value="%s">
                                        <input type="submit" value="Delete">
                                    </form>
                                </div>',
                                htmlspecialchars($image['image_url']),
                                htmlspecialchars($image['alt']),
                                $image['is_featured'] ? '<div class="no-form-button"><button onclick="javascript:void(0);">Featured</button></div>' : $featuredForm,
                                htmlspecialchars($image['id']),
                                htmlspecialchars($tour['id'])
                            );
                            echo '</div>';
                        }
                    } else {
                        // If no images are available, display a message
                        echo '<p>No images available for this tour.</p>';
                    }
                    ?>
                </div>
                <!-- Controls the collapsible section for adding new images -->
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#add-image" aria-expanded="false" aria-controls="add-image">
                    Add New Images
                </button>
                <!-- This collapsible section allows the admin to add new images for the tour -->
                <div class="collapse" id="add-image">
                    <p>Add new images for this tour. Images can be added with a URL and alt text.</p>
                    <form action="../add/image.php" method="post" class="center-form">
                        <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
                        <label for="add_image_url">URL:</label>
                        <input type="text" name="image_url" id="add_image_url" placeholder="Image URL" maxlength="255" required>
                        <label for="add_image_alt">Description:</label>
                        <input type="text" name="image_alt" id="add_image_alt" placeholder="Image alt text" maxlength="255" required>
                        <input type="submit" value="Add Image">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>