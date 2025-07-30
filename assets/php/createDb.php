<?php

/* 
    This file creates a connection to the database and retrieves data from a specified table.
*/

function createDb(
    $servername = "localhost", 
    $username = "root", 
    $password = "",
    $dbname = "Newdb",
    $sqlquerypath = "assets/sql/createTables.sql"
)
{
    try { // Test a connection to the database
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    }
    catch(Exception $e) { // Connection failed, assume no database exists and create one
        $conn = new mysqli($servername, $username, $password);
        if (!$conn) { // Something is wrong with the credentials or the server
            die("Connection failed: " . mysqli_connect_error());
        }

        // Create the database and its corresponding tables
        $sql = "CREATE DATABASE $dbname";
        if (mysqli_query($conn, $sql)) { // Check if the database was created successfully
            echo "Database created successfully\n"; 
            if (mysqli_select_db($conn, $dbname)) { // Select the database to work with
                echo "Database selected successfully\n";
            } else {
                die("Error selecting database: " . mysqli_error($conn)); // Stop the script if the database selection fails
            };
        } else {
            die("Error creating database: " . mysqli_error($conn)); // Stop the script if the database creation fails
        }
    }

    // Get SQL query to create the tables
    $sqlcontent = file_get_contents($sqlquerypath);
    if ($sqlcontent === false) { // Check if the SQL file was read successfully
        die("Error reading SQL file: " . error_get_last()['message']);
    }

    if (mysqli_multi_query($conn, $sqlcontent)) { // Execute the SQL queries to create tables
        do {
            // Store the first result set as multiple calls need to be made for each query
            if ($result = mysqli_store_result($conn)) {
                echo $result;
                mysqli_free_result($result); // Free the result set
            }
        } while (mysqli_next_result($conn)); // Move to the next result set
    } else {
        die("Error creating tables: " . mysqli_error($conn)); // Stop the script if table creation fails
    }

    echo "Database and Tables created successfully\n"; // Confirmation message
    mysqli_close($conn); // Close the database connection
}

?>






