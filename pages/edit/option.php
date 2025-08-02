<?php
session_start();

// If the user is not logged in, or is not an admin, redirect to home page
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: /3340/index.php');
    exit;
}

// Establish database connection
require_once('../../assets/php/db.php');

// Check if tour_id and option_id are set
if (!isset($_GET['tour_id']) || !isset($_GET['option_id'])) {
    header("Location: /3340/404.php");
    exit;
}

// Retrieve option details
$stmt = $conn->prepare("SELECT * FROM options WHERE id = ?");
$stmt->bind_param("i", $_GET['option_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: /3340/404.php");
    exit;
}
$option = $result->fetch_assoc();
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

    <div class="center-form">
        <form action="../edit/option_validate.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['option_id']); ?>">
            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($_GET['tour_id']); ?>">
            <label for="name">Option Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($option['name']); ?>">
            <label for="description">Description:</label>
            <textarea name="description" id="description"><?php echo htmlspecialchars($option['description']); ?></textarea>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($option['price']); ?>">
            <input type="submit" value="Edit">
        </form>
    </div>
    <!-- Footer -->
</body>

</html>