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
    $inclusions,
    $destination,
    $start_city,
    $end_city,
    $category,
    $activity_level,
    $duration,
    $base_price,
    $start_date,
    $end_date,
    $start_day,
) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tours (id, name, description, inclusions, destination, start_city, end_city, category, activity_level, duration, base_price, start_date, end_date, start_day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssssssiissi",
        $id,
        $name,
        $description,
        $inclusions,
        $destination,
        $start_city,
        $end_city,
        $category,
        $activity_level,
        $duration,
        $base_price,
        $start_date,
        $end_date,
        $start_day,
    );

    if ($stmt->execute()) {
        echo "<p>ID {$id}: Tour {$name} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting tour {$id}: {$name}: " . $stmt->error . "</p>";
    }
}

function insertImage($tour_id, $image_url, $is_featured)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO images (tour_id, image_url, is_featured) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $tour_id, $image_url, $is_featured);

    if ($stmt->execute()) {
        echo "<p>Image {$image_url} for tour ID {$tour_id} inserted successfully.</p>";
    } else {
        echo "<p>Error inserting image {$image_url} for tour ID {$tour_id}: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
