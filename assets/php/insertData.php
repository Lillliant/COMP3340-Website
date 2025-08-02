<?php

require_once 'db.php';

function insertUser($username, $password, $firstName, $lastName, $email, $role)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $firstName, $lastName, $email, $role);

    if ($stmt->execute()) {
        echo "<p>{$role}: {$username} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting user {$username}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

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
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tours (id, name, description, long_description, inclusions, destination, start_city, end_city, category, activity_level, duration,start_day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "isssssssssii",
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
    );

    if ($stmt->execute()) {
        echo "<p>ID {$id}: Tour {$name} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting tour {$id}: {$name}: " . $stmt->error . "</p>";
    }
}

function insertImage($tour_id, $image_url, $alt, $is_featured)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO images (tour_id, image_url, alt, is_featured) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $tour_id, $image_url, $alt, $is_featured);

    if ($stmt->execute()) {
        echo "<p>Image {$image_url} for tour ID {$tour_id} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting image {$image_url} for tour ID {$tour_id}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

function insertOption($tour_id, $name, $description, $price)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO options (tour_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $tour_id, $name, $description, $price);

    if ($stmt->execute()) {
        echo "<p>Option {$name} for tour ID {$tour_id} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting option {$name} for tour ID {$tour_id}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
