<?php

/* This file is an utility file containing functions used to initialize the website's database by inserting sample data.
*/

require_once 'db.php'; // require database connection

// Insert user data in the init-data.json file into the database
function insertUser($username, $password, $firstName, $lastName, $email, $role)
{
    global $conn; // access the global database connection variable

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $firstName, $lastName, $email, $role);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "<p>{$role}: {$username} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting user {$username}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Insert tour data in the init-data.json file into the database
function insertTour(
    $id,
    $name,
    $description,
    $long_description,
    $inclusions,
    $destination,
    $start_city,
    $end_city,
    $category,
    $activity_level,
    $duration,
    $start_day,
) {
    global $conn; // access the global database connection variable
    $is_active = 1; // Default value for is_active for tours in init_data.json

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO tours (id, name, description, long_description, inclusions, destination, start_city, end_city, category, activity_level, duration, start_day, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "isssssssssiii",
        $id,
        $name,
        $description,
        $long_description,
        $inclusions,
        $destination,
        $start_city,
        $end_city,
        $category,
        $activity_level,
        $duration,
        $start_day,
        $is_active
    );

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "<p>ID {$id}: Tour {$name} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting tour {$id}: {$name}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Insert image data in the init-data.json file into the database
function insertImage($tour_id, $image_url, $alt, $is_featured)
{
    global $conn; // access the global database connection variable

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO images (tour_id, image_url, alt, is_featured) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $tour_id, $image_url, $alt, $is_featured);
    
    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "<p>Image {$image_url} for tour ID {$tour_id} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting image {$image_url} for tour ID {$tour_id}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Insert option data in the init-data.json file into the database
function insertOption($tour_id, $name, $description, $price)
{
    global $conn; // access the global database connection variable

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO options (tour_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $tour_id, $name, $description, $price);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "<p>Option {$name} for tour ID {$tour_id} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting option {$name} for tour ID {$tour_id}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
