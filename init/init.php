<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialization</title>
</head>

<body>
    <h1>Database Initialization</h1>
    <p>This page is used to initialize the database and create necessary tables.</p>
    <p>Please wait while the initialization process completes...</p>
    <?php
    // This file is used to initialize the database and create necessary tables
    // It should be included in the init/init.php file
    echo "<p><b>Initializing database...</b></p>";
    require_once('../assets/php/CreateDb.php');
    createDb();
    echo "<p>Database initialized successfully.</p>";

    // Then, add a process to handle the initialization of data,
    // Including creating initial accounts and uploading files and links to the database

    echo "<p><b>Inserting initial data...</b></p>";
    require_once('../assets/php/insertData.php');
    $obj = json_decode(file_get_contents('../init/init_data.json'), true);

    echo "<p><i>Inserting users...</i></p>";
    foreach ($obj['users'] as $user) {
        insertUser($user['username'], $user['password'], $user['firstName'], $user['lastName'], $user['email'], $user['role']);
    }

    echo "<p><i>Inserting tours...</i></p>";
    foreach ($obj['tours'] as $tour) {
        echo "<p>Inserting tour: " . $tour['name'] . " of ID " . $tour['id'] . "</p>";
        insertTour($tour['id'], $tour['name'], $tour['description'], $tour['inclusions'], $tour['destination'], $tour['start_city'], $tour['end_city'], $tour['category'], $tour['activity_level'], $tour['duration'], $tour['base_price'], $tour['start_date'], $tour['end_date'], $tour['start_day']);
    }

    echo "<p><i>Inserting tour images...</i></p>";
    foreach ($obj['images'] as $image) {
        insertImage($image['tour_id'], $image['image_url'], $image['alt'], $image['featured']);
    }

    echo "<p><b>Initialization complete.</b></p>";
    // Redirect to the main page after initialization
    echo "<a href='../index.php'>Go to Home Page</a>";
    ?>
</body>

</html>