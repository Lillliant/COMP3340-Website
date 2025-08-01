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
    insertImage($image['tour_id'], $image['image_url'], $image['featured']);
}
